import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

function MyItineraries() {
    const [itineraries, setItineraries] = useState([]);
    const [loading, setLoading] = useState(true);
    const [deleting, setDeleting] = useState(null);
    const [loadingId, setLoadingId] = useState(null);

    const fetchItineraries = async () => {
        setLoading(true);
        try {
            const response = await fetch('/my-itineraries', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                }
            });
            const data = await response.json();
            console.log('Fetched itineraries:', data);
            setItineraries(data);
        } catch (error) {
            console.error('Error fetching itineraries:', error);
            alert('Could not load itineraries');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchItineraries();
    }, []);

    const loadItinerary = async (id) => {
        setLoadingId(id);
        try {
            const response = await fetch(`/itineraries/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                }
            });
            const data = await response.json();

            // Store the loaded itinerary in localStorage so the planner can pick it up
            localStorage.setItem('tripPlannerItinerary', JSON.stringify(data.itinerary_data));
            localStorage.setItem('loadedItineraryName', data.name);

            alert(`Itinerary "${data.name}" loaded! Go to the Trip Planner to view it.`);
            window.location.href = '/planner';
        } catch (error) {
            console.error('Error loading itinerary:', error);
            alert('Could not load itinerary');
        } finally {
            setLoadingId(null);
        }
    };

    const deleteItinerary = async (id) => {
        if (!confirm('Are you sure you want to delete this itinerary?')) return;

        setDeleting(id);
        try {
            const response = await fetch(`/itineraries/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                }
            });
            if (response.ok) {
                setItineraries(itineraries.filter(i => i.id !== id));
                alert('Itinerary deleted successfully');
            } else {
                throw new Error('Delete failed');
            }
        } catch (error) {
            console.error('Error deleting itinerary:', error);
            alert('Could not delete itinerary');
        } finally {
            setDeleting(null);
        }
    };

    if (!window.authUser) {
        return (
            <div className="min-h-screen bg-gradient-to-b from-cream to-sand-light flex items-center justify-center p-4">
                <div className="bg-white rounded-2xl shadow-xl p-8 text-center max-w-md">
                    <i className="fas fa-lock text-5xl text-gray-300 mb-4"></i>
                    <p className="text-gray-600 mb-4">Please log in to view your saved itineraries.</p>
                    <a href="/login" className="inline-block bg-tunisia-red hover:bg-tunisia-red-dark text-white font-semibold py-2 px-6 rounded-xl transition shadow-md">
                        Login
                    </a>
                </div>
            </div>
        );
    }

    if (loading) {
        return (
            <div className="min-h-screen bg-gradient-to-b from-cream to-sand-light flex items-center justify-center p-4">
                <div className="text-center">
                    <i className="fas fa-spinner fa-spin text-3xl text-tunisia-gold"></i>
                    <p className="mt-3 text-gray-600">Loading your itineraries...</p>
                </div>
            </div>
        );
    }

    if (itineraries.length === 0) {
        return (
            <div className="min-h-screen bg-gradient-to-b from-cream to-sand-light py-12">
                <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="bg-white rounded-2xl shadow-xl p-12 text-center">
                        <i className="fas fa-map-marked-alt text-6xl text-gray-300 mb-4"></i>
                        <h3 className="text-2xl font-bold font-playfair text-med-blue mb-2">No saved itineraries yet</h3>
                        <p className="text-gray-500 mb-6">Plan your first trip using the Trip Planner!</p>
                        <a href="/planner" className="inline-flex items-center gap-2 bg-tunisia-gold hover:bg-amber-500 text-charcoal font-semibold py-3 px-8 rounded-xl transition shadow-md">
                            <i className="fas fa-plus"></i> Go to Trip Planner
                        </a>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gradient-to-b from-cream to-sand-light py-12">
            <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                {/* Header */}
                <div className="text-center mb-10">
                    <h1 className="text-4xl md:text-5xl font-bold font-playfair text-med-blue mb-2">
                        <span className="text-tunisia-red">My</span> Itineraries
                    </h1>
                    <p className="text-gray-600 text-lg">Your saved Tunisia trips – ready to explore or modify.</p>
                </div>

                <div className="flex justify-end mb-6">
                    <a href="/planner" className="inline-flex items-center gap-2 bg-tunisia-gold hover:bg-amber-500 text-charcoal font-semibold py-2 px-5 rounded-xl transition shadow-md">
                        <i className="fas fa-plus-circle"></i> Plan New Trip
                    </a>
                </div>

                <div className="grid gap-6 md:grid-cols-2">
                    {itineraries.map(itinerary => (
                        <div key={itinerary.id} className="bg-white rounded-xl shadow-md hover:shadow-xl transition-all border border-gray-100 overflow-hidden">
                            <div className="p-5">
                                <div className="flex justify-between items-start">
                                    <h3 className="text-xl font-bold font-playfair text-med-blue mb-1">{itinerary.name}</h3>
                                    <span className="bg-tunisia-gold/20 text-charcoal px-2 py-1 rounded-full text-xs font-semibold">
                                        {itinerary.total_cost} TND
                                    </span>
                                </div>
                                <div className="text-sm text-gray-500 mb-3 flex items-center gap-2">
                                    <i className="far fa-calendar-alt"></i>
                                    {new Date(itinerary.start_date).toLocaleDateString()} - {new Date(itinerary.end_date).toLocaleDateString()}
                                </div>
                                <div className="text-xs text-gray-400 mb-4">
                                    <i className="far fa-clock"></i> Created: {new Date(itinerary.created_at).toLocaleDateString()}
                                </div>
                                <div className="flex gap-3 mt-2">
                                    <button
                                        onClick={() => loadItinerary(itinerary.id)}
                                        disabled={loadingId === itinerary.id}
                                        className="flex-1 inline-flex justify-center items-center gap-2 bg-med-blue hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition disabled:opacity-50"
                                    >
                                        {loadingId === itinerary.id ? (
                                            <i className="fas fa-spinner fa-spin"></i>
                                        ) : (
                                            <i className="fas fa-download"></i>
                                        )}
                                        Load
                                    </button>
                                    <button
                                        onClick={() => deleteItinerary(itinerary.id)}
                                        disabled={deleting === itinerary.id}
                                        className="flex-1 inline-flex justify-center items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition disabled:opacity-50"
                                    >
                                        {deleting === itinerary.id ? (
                                            <i className="fas fa-spinner fa-spin"></i>
                                        ) : (
                                            <i className="fas fa-trash-alt"></i>
                                        )}
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('itineraries-app');
    if (rootElement) {
        const root = ReactDOM.createRoot(rootElement);
        root.render(<MyItineraries />);
    }
});