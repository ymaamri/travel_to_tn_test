import React, { useState, useEffect, useRef } from 'react';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import 'leaflet.markercluster';

// Fix default Leaflet icon paths
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
});

// Custom marker colors
const getMarkerColor = (type, category) => {
    if (type === 'destination') {
        if (category === 'beach') return '#1D3557';
        if (category === 'desert_area') return '#D4AF37';
        if (category === 'historical_place') return '#780000';
        if (category === 'city') return '#2A4B4C';
        return '#1D3557';
    } else if (type === 'establishment') {
        if (category === 'hotel' || category === 'resort') return '#D4AF37';
        if (category === 'traditional_restaurant' || category === 'luxury_dining') return '#C1121F';
        if (category === 'cafe') return '#2A4B4C';
        return '#2A4B4C';
    }
    return '#D4AF37';
};

const createCustomIcon = (color, size = 28) => {
    return L.divIcon({
        html: `<div style="background-color: ${color}; width: ${size}px; height: ${size}px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"><i class="fas fa-map-marker-alt" style="color: white; font-size: ${size * 0.45}px;"></i></div>`,
        iconSize: [size, size],
        popupAnchor: [0, -size/2],
        className: 'custom-marker'
    });
};

const ExploreMap = () => {
    const mapRef = useRef(null);
    const [markers, setMarkers] = useState([]);
    const [filteredMarkers, setFilteredMarkers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [mapReady, setMapReady] = useState(false);
    const [routeMode, setRouteMode] = useState(false);
    const [routePoints, setRoutePoints] = useState([]);
    const [cityNames, setCityNames] = useState({});
    
    const filters = {
        destinations: true,
        hotels: true,
        restaurants: true,
        cafes: true,
    };

    // Fetch markers
    useEffect(() => {
        fetch('/map-markers')
            .then(res => res.json())
            .then(data => {
                // Store city names for route planning
                const names = {};
                data.forEach(m => {
                    if (m.type === 'destination') {
                        names[m.id] = m.name;
                    }
                });
                setCityNames(names);
                setMarkers(data);
                setFilteredMarkers(data.filter(m => m.type === 'destination')); // Only show destinations by default
                setLoading(false);
            })
            .catch(err => {
                console.error('Failed to load map markers', err);
                setLoading(false);
            });
    }, []);

    // Initialize map
    useEffect(() => {
        const timer = setTimeout(() => {
            const container = document.getElementById('explore-map');
            if (container && !mapRef.current) {
                const map = L.map(container).setView([34.5, 9.5], 7);
                mapRef.current = map;

                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>',
                    subdomains: 'abcd',
                    maxZoom: 19,
                }).addTo(map);
                
                setMapReady(true);
                setTimeout(() => map.invalidateSize(), 100);
            }
        }, 200);
        
        return () => clearTimeout(timer);
    }, []);

    // Add markers to map
    useEffect(() => {
        if (!mapReady || !mapRef.current) return;

        // Clear existing layers (keep tile layer)
        mapRef.current.eachLayer((layer) => {
            if (layer instanceof L.Marker || layer instanceof L.MarkerClusterGroup || layer instanceof L.Polyline) {
                mapRef.current.removeLayer(layer);
            }
        });

        const markersCluster = L.markerClusterGroup({ chunkedLoading: true });

        filteredMarkers.forEach(marker => {
            const color = getMarkerColor(marker.type, marker.category);
            const icon = createCustomIcon(color);
            
            let iconEmoji = marker.category === 'beach' ? '🏖️' : (marker.category === 'desert_area' ? '🏜️' : (marker.category === 'historical_place' ? '🏛️' : '📍'));
            
            const popupContent = `
                <div style="min-width: 200px; font-family: Inter, sans-serif;">
                    <h3 style="margin:0 0 5px; font-size:14px;">${iconEmoji} ${marker.name}</h3>
                    <p style="margin:0; font-size:11px;">⭐ ${marker.rating} (${marker.review_count} reviews)</p>
                    <div style="margin-top:8px;">
                        <a href="/${marker.type === 'destination' ? 'destinations' : 'directory'}/${marker.slug}" target="_blank" style="background:#1D3557; color:white; padding:3px 10px; border-radius:20px; text-decoration:none; font-size:11px;">View</a>
                        <button onclick="window.addToTrip('${marker.name}', ${marker.lat}, ${marker.lng})" style="background:#D4AF37; border:none; padding:3px 10px; border-radius:20px; margin-left:5px; font-size:11px; cursor:pointer;">➕ Trip</button>
                        ${marker.type === 'destination' ? `<button onclick="window.startRoute(${marker.lat}, ${marker.lng}, '${marker.name}')" style="background:#2A4B4C; border:none; padding:3px 10px; border-radius:20px; margin-left:5px; font-size:11px; cursor:pointer; color:white;">🗺️ Route</button>` : ''}
                    </div>
                </div>
            `;
            const m = L.marker([marker.lat, marker.lng], { icon }).bindPopup(popupContent);
            markersCluster.addLayer(m);
        });

        mapRef.current.addLayer(markersCluster);
        
        if (filteredMarkers.length > 0) {
            const bounds = filteredMarkers.map(m => [m.lat, m.lng]);
            mapRef.current.fitBounds(bounds);
        }
    }, [mapReady, filteredMarkers]);

    // Draw route between points
    const drawRoute = (points) => {
        if (!mapRef.current || points.length < 2) return;
        
        // Clear existing route
        mapRef.current.eachLayer((layer) => {
            if (layer instanceof L.Polyline) {
                mapRef.current.removeLayer(layer);
            }
        });
        
        // Draw new route
        const routeLine = L.polyline(points, { color: '#C1121F', weight: 4, opacity: 0.7 }).addTo(mapRef.current);
        
        // Add markers for route points
        points.forEach((point, idx) => {
            const icon = L.divIcon({
                html: `<div style="background-color: #C1121F; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 11px; font-weight: bold;">${idx + 1}</div>`,
                iconSize: [20, 20],
                className: 'route-marker'
            });
            L.marker([point.lat, point.lng], { icon }).addTo(mapRef.current);
        });
        
        mapRef.current.fitBounds(routeLine.getBounds());
    };

    // Global functions for popup buttons
    window.addToTrip = (name, lat, lng) => {
        const place = { name, lat, lng, addedAt: new Date() };
        const saved = localStorage.getItem('tripPlaces');
        const places = saved ? JSON.parse(saved) : [];
        places.push(place);
        localStorage.setItem('tripPlaces', JSON.stringify(places));
        alert(`✅ ${name} added to your trip! Go to Trip Planner.`);
    };

    window.startRoute = (lat, lng, name) => {
        const newPoint = { lat, lng, name };
        const newPoints = [...routePoints, newPoint];
        setRoutePoints(newPoints);
        
        if (newPoints.length >= 2) {
            const routeLatLngs = newPoints.map(p => [p.lat, p.lng]);
            drawRoute(routeLatLngs);
        }
        
        alert(`📍 ${name} added to route. ${newPoints.length === 1 ? 'Add another city to see the route.' : 'Route drawn!'}`);
    };

    const clearRoute = () => {
        setRoutePoints([]);
        if (mapRef.current) {
            mapRef.current.eachLayer((layer) => {
                if (layer instanceof L.Polyline || (layer instanceof L.Marker && layer.options.icon && layer.options.icon.className === 'route-marker')) {
                    mapRef.current.removeLayer(layer);
                }
            });
        }
        alert('Route cleared!');
    };

    if (loading) {
        return (
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', height: '100vh' }}>
                <div style={{ textAlign: 'center' }}>
                    <i className="fas fa-spinner fa-spin" style={{ fontSize: '2rem', color: '#D4AF37' }}></i>
                    <p style={{ marginTop: '0.5rem', fontSize: '14px' }}>Loading map...</p>
                </div>
            </div>
        );
    }

    return (
        <div style={{ height: '100vh', display: 'flex', flexDirection: 'column' }}>
            {/* Header */}
            <div style={{ background: 'white', padding: '8px 12px', borderBottom: '1px solid #e5e7eb', flexShrink: 0 }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: '8px' }}>
                    <h1 style={{ fontSize: '18px', fontWeight: 'bold', margin: 0 }}>
                        <span style={{ color: '#C1121F' }}>🗺️ Interactive</span> Map of Tunisia
                    </h1>
                    <div style={{ display: 'flex', gap: '8px' }}>
                        {routePoints.length > 0 && (
                            <button onClick={clearRoute} style={{ background: '#C1121F', color: 'white', padding: '5px 12px', borderRadius: '20px', border: 'none', fontSize: '12px', cursor: 'pointer' }}>
                                Clear Route ({routePoints.length})
                            </button>
                        )}
                        <a href="/planner" style={{ background: '#D4AF37', padding: '5px 12px', borderRadius: '20px', textDecoration: 'none', color: '#1E1E24', fontSize: '12px', fontWeight: 'bold' }}>
                            📍 Trip Planner
                        </a>
                    </div>
                </div>
            </div>

            {/* Map */}
            <div id="explore-map" style={{ flex: 1, width: '100%', background: '#e8e4dc' }}></div>

            {/* Footer */}
            <div style={{ padding: '6px', textAlign: 'center', fontSize: '11px', color: '#6B7280', background: '#F9FAFB', borderTop: '1px solid #e5e7eb' }}>
                📍 {filteredMarkers.length} destinations | Click marker → 🗺️ Route to plan journey between cities
                {routePoints.length > 0 && ` | Route: ${routePoints.map(p => p.name).join(' → ')}`}
            </div>
        </div>
    );
};

export default ExploreMap;