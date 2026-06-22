import React, { useEffect, useRef } from 'react';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Fix marker icons for Leaflet with Vite
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
});

const MapComponent = ({ cities }) => {
    const mapRef = useRef(null);
    const markersRef = useRef([]);

    const cityCoords = {
        'Tunis': [36.8065, 10.1815],
        'Sidi Bou Said': [36.8689, 10.3415],
        'Hammamet': [36.3981, 10.5624],
        'Sousse': [35.8256, 10.6390],
        'Kairouan': [35.6771, 10.1018],
        'El Jem': [35.2950, 10.7140],
        'Douz': [33.4639, 9.0204],
        'Djerba': [33.8131, 10.9072],
    };

    useEffect(() => {
        if (!mapRef.current && cities && cities.length > 0) {
            const map = L.map('trip-map').setView([34.5, 9.5], 7);
            mapRef.current = map;

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; CartoDB',
                subdomains: 'abcd',
                maxZoom: 19,
            }).addTo(map);
        }

        return () => {
            if (mapRef.current) {
                mapRef.current.remove();
                mapRef.current = null;
            }
        };
    }, []);

    useEffect(() => {
        if (!mapRef.current || !cities) return;

        // Remove old markers
        markersRef.current.forEach(marker => mapRef.current.removeLayer(marker));
        markersRef.current = [];

        // Add markers for each city
        cities.forEach((city, idx) => {
            const coords = cityCoords[city];
            if (coords) {
                const marker = L.marker(coords).addTo(mapRef.current);
                marker.bindPopup(`
                    <b>Day ${idx + 1}: ${city}</b><br>
                    Drag days to reorder itinerary.
                `);
                markersRef.current.push(marker);
            }
        });

        // Fit bounds to show all markers
        const bounds = cities.filter(c => cityCoords[c]).map(c => cityCoords[c]);
        if (bounds.length) mapRef.current.fitBounds(bounds);
    }, [cities]);

    return <div id="trip-map" className="h-80 w-full rounded-xl shadow-md border border-gray-200 mb-5"></div>;
};

export default MapComponent;