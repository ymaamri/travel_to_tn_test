import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import { DragDropContext, Droppable, Draggable } from 'react-beautiful-dnd';
import MapComponent from './components/MapComponent';

function TripPlanner() {
    const [formData, setFormData] = useState({
        startDate: '',
        endDate: '',
        budget: '',
        interests: [],
        cities: []
    });

    const [itinerary, setItinerary] = useState(null);
    const [loading, setLoading] = useState(false);
    const [saved, setSaved] = useState(false);
    const [savingStatus, setSavingStatus] = useState('');
    const [showSaveModal, setShowSaveModal] = useState(false);
    const [tripName, setTripName] = useState('My Tunisia Trip');

    const user = window.authUser;

    const interestOptions = [
        'History & Culture', 'Beaches', 'Sahara Desert',
        'Food & Cuisine', 'Shopping', 'Roman Ruins'
    ];

    const cityOptions = [
        'Tunis', 'Sidi Bou Said', 'Hammamet', 'Sousse',
        'Kairouan', 'El Jem', 'Douz', 'Djerba'
    ];

    // Load saved itinerary from localStorage on mount
    useEffect(() => {
        const savedItinerary = localStorage.getItem('tripPlannerItinerary');
        if (savedItinerary) {
            setItinerary(JSON.parse(savedItinerary));
        }
    }, []);

    // Auto-save to localStorage whenever itinerary changes
    useEffect(() => {
        if (itinerary) {
            localStorage.setItem('tripPlannerItinerary', JSON.stringify(itinerary));
            setSaved(true);
            setTimeout(() => setSaved(false), 2000);
        }
    }, [itinerary]);

    const handleInterestChange = (interest) => {
        setFormData(prev => ({
            ...prev,
            interests: prev.interests.includes(interest)
                ? prev.interests.filter(i => i !== interest)
                : [...prev.interests, interest]
        }));
    };

    const handleCityChange = (city) => {
        setFormData(prev => ({
            ...prev,
            cities: prev.cities.includes(city)
                ? prev.cities.filter(c => c !== city)
                : [...prev.cities, city]
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        if (formData.cities.length === 0) {
            alert('Please select at least one city to visit.');
            return;
        }

        const start = new Date(formData.startDate);
        const end = new Date(formData.endDate);
        const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        if (diffDays > 14) {
            alert('Maximum trip duration is 14 days. Please select a shorter date range.');
            return;
        }

        setLoading(true);

        try {
            const response = await fetch('/api/trip-planner/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || `HTTP ${response.status}`);
            }

            const data = await response.json();
            setItinerary(data);
        } catch (error) {
            console.error('Error generating trip:', error);
            alert(error.message || 'Failed to generate trip. Please try again.');
        } finally {
            setLoading(false);
        }
    };

    const onDragEnd = (result) => {
        if (!result.destination || !itinerary) return;

        const items = Array.from(itinerary.days);
        const [reorderedItem] = items.splice(result.source.index, 1);
        items.splice(result.destination.index, 0, reorderedItem);

        const updatedDays = items.map((day, idx) => ({ ...day, day: idx + 1 }));

        setItinerary({
            ...itinerary,
            days: updatedDays
        });
    };

    const clearSaved = () => {
        localStorage.removeItem('tripPlannerItinerary');
        setItinerary(null);
    };

    const saveItinerary = async () => {
        if (!user) {
            alert('Please login to save itineraries.');
            return;
        }
        setSavingStatus('saving');
        try {
            const response = await fetch('/itineraries', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: tripName,
                    itinerary_data: itinerary,
                    total_cost: itinerary.totalCost,
                    start_date: formData.startDate,
                    end_date: formData.endDate
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Save failed');
            }

            setSavingStatus('success');
            setTimeout(() => setSavingStatus(''), 3000);
            setShowSaveModal(false);
            alert(data.message);
        } catch (err) {
            console.error('Save error:', err);
            setSavingStatus('error');
            setTimeout(() => setSavingStatus(''), 3000);
            alert('Could not save itinerary: ' + err.message);
        }
    };

    return (
        <div className="bg-gradient-to-b from-cream to-sand-light min-h-screen py-12">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {/* Hero Header */}
                <div className="text-center mb-12">
                    <h1 className="text-4xl md:text-5xl font-bold font-playfair text-med-blue mb-3">
                        <span className="text-tunisia-red">Interactive</span> Tunisia Trip Planner
                    </h1>
                    <p className="text-gray-600 text-lg max-w-2xl mx-auto">
                        Design your perfect Tunisian adventure – from Mediterranean coasts to Saharan dunes.
                    </p>
                </div>

                {/* Notifications */}
                {saved && (
                    <div className="fixed bottom-4 right-4 z-50 bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in-up">
                        <i className="fas fa-check-circle"></i> Itinerary saved locally
                    </div>
                )}
                {savingStatus === 'saving' && (
                    <div className="fixed bottom-4 right-4 z-50 bg-blue-100 text-blue-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in-up">
                        <i className="fas fa-spinner fa-spin"></i> Saving...
                    </div>
                )}
                {savingStatus === 'success' && (
                    <div className="fixed bottom-4 right-4 z-50 bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in-up">
                        <i className="fas fa-check-circle"></i> Saved to your account!
                    </div>
                )}
                {savingStatus === 'error' && (
                    <div className="fixed bottom-4 right-4 z-50 bg-red-100 text-red-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in-up">
                        <i className="fas fa-exclamation-circle"></i> Save failed
                    </div>
                )}

                <div className="grid lg:grid-cols-2 gap-10">
                    {/* Left column: Form */}
                    <div className="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 md:p-8 transition-all hover:shadow-2xl">
                        <form onSubmit={handleSubmit}>
                            <div className="mb-6">
                                <label className="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <i className="fas fa-calendar-alt text-tunisia-gold"></i> Travel Dates
                                </label>
                                <div className="flex flex-col sm:flex-row gap-4">
                                    <input type="date" className="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-tunisia-gold focus:border-transparent transition"
                                        value={formData.startDate} onChange={e => setFormData({ ...formData, startDate: e.target.value })} required />
                                    <input type="date" className="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-tunisia-gold focus:border-transparent transition"
                                        value={formData.endDate} onChange={e => setFormData({ ...formData, endDate: e.target.value })} required />
                                </div>
                                <p className="text-xs text-gray-500 mt-1">Maximum 14 days</p>
                            </div>

                            <div className="mb-6">
                                <label className="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <i className="fas fa-coins text-tunisia-gold"></i> Budget (TND per person)
                                </label>
                                <select className="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-tunisia-gold focus:border-transparent transition"
                                    value={formData.budget} onChange={e => setFormData({ ...formData, budget: e.target.value })} required>
                                    <option value="">Select budget</option>
                                    <option value="budget">🌱 Budget (under 300 TND)</option>
                                    <option value="moderate">⭐ Moderate (300-800 TND)</option>
                                    <option value="luxury">👑 Luxury (800+ TND)</option>
                                </select>
                            </div>

                            <div className="mb-6">
                                <label className="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <i className="fas fa-heart text-tunisia-gold"></i> Interests
                                </label>
                                <div className="flex flex-wrap gap-2">
                                    {interestOptions.map(interest => (
                                        <button type="button" key={interest}
                                            className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${formData.interests.includes(interest)
                                                ? 'bg-tunisia-red text-white shadow-md'
                                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                            }`}
                                            onClick={() => handleInterestChange(interest)}>
                                            {interest}
                                        </button>
                                    ))}
                                </div>
                            </div>

                            <div className="mb-8">
                                <label className="block text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <i className="fas fa-city text-tunisia-gold"></i> Cities to visit
                                </label>
                                <div className="flex flex-wrap gap-2">
                                    {cityOptions.map(city => (
                                        <button type="button" key={city}
                                            className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${formData.cities.includes(city)
                                                ? 'bg-med-blue text-white shadow-md'
                                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                                            }`}
                                            onClick={() => handleCityChange(city)}>
                                            {city}
                                        </button>
                                    ))}
                                </div>
                                <p className="text-xs text-gray-500 mt-1">Select at least one city</p>
                            </div>

                            <button type="submit" disabled={loading}
                                className="w-full bg-gradient-to-r from-tunisia-gold to-amber-500 text-charcoal font-bold py-3 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-lg">
                                {loading ? <><i className="fas fa-spinner fa-spin"></i> Planning...</> : <><i className="fas fa-magic"></i> Generate My Trip</>}
                            </button>

                            {itinerary && (
                                <button type="button" onClick={clearSaved}
                                    className="w-full mt-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 rounded-xl transition flex items-center justify-center gap-2">
                                    <i className="fas fa-trash-alt"></i> Clear Saved Itinerary
                                </button>
                            )}
                        </form>
                    </div>

                    {/* Right column: Itinerary with Map */}
                    <div className="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 md:p-8 transition-all hover:shadow-2xl">
                        <h2 className="text-2xl font-bold font-playfair text-med-blue mb-2 flex items-center gap-2">
                            <i className="fas fa-map-marked-alt text-tunisia-gold"></i> Your Trip Itinerary
                        </h2>
                        {itinerary && <MapComponent cities={itinerary.days.map(day => day.city)} />}
                        <div className="flex justify-between items-center mb-4 text-sm text-gray-500">
                            <span><i className="fas fa-info-circle text-tunisia-gold"></i> Drag the handle to reorder days</span>
                            <span><i className="fas fa-wallet text-tunisia-gold"></i> All costs are estimates</span>
                        </div>
                        {itinerary ? (
                            <>
                                <DragDropContext onDragEnd={onDragEnd}>
                                    <Droppable droppableId="days">
                                        {(provided) => (
                                            <div {...provided.droppableProps} ref={provided.innerRef} className="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                                                {itinerary.days.map((day, index) => (
                                                    <Draggable key={`day-${day.day}`} draggableId={`day-${day.day}`} index={index}>
                                                        {(provided) => (
                                                            <div
                                                                ref={provided.innerRef}
                                                                {...provided.draggableProps}
                                                                className="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:shadow-md transition"
                                                            >
                                                                <div className="flex items-start gap-3">
                                                                    <div {...provided.dragHandleProps} className="cursor-grab text-gray-400 hover:text-tunisia-gold mt-1">
                                                                        <i className="fas fa-grip-vertical text-lg"></i>
                                                                    </div>
                                                                    <div className="flex-1">
                                                                        <div className="flex flex-wrap justify-between items-start gap-2 mb-2">
                                                                            <h3 className="font-bold text-lg text-med-blue">Day {day.day}: {day.city}</h3>
                                                                            <span className="bg-tunisia-gold/20 text-charcoal px-3 py-1 rounded-full text-xs font-semibold">
                                                                                {day.estimatedCost} TND
                                                                            </span>
                                                                        </div>
                                                                        <div className="mb-3">
                                                                            <p className="text-sm font-semibold text-gray-700 flex items-center gap-1"><i className="fas fa-hiking text-tunisia-gold"></i> Activities</p>
                                                                            <ul className="list-disc ml-6 space-y-1">
                                                                                {day.activities.map((act, idx) => (
                                                                                    <li key={idx} className="text-sm text-gray-600">
                                                                                        {act.title} – <span className="text-green-700 font-medium">{act.cost} TND</span>
                                                                                        {act.description && <p className="text-xs text-gray-500">{act.description.substring(0, 80)}...</p>}
                                                                                    </li>
                                                                                ))}
                                                                            </ul>
                                                                        </div>
                                                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                                                                            <p className="flex items-center gap-1"><i className="fas fa-hotel text-tunisia-gold w-5"></i> <span className="font-medium">Hotel:</span> {day.hotel}</p>
                                                                            <p className="flex items-center gap-1"><i className="fas fa-bus text-tunisia-gold w-5"></i> <span className="font-medium">Transport:</span> {day.transport}</p>
                                                                        </div>
                                                                        {day.hotel_link && (
                                                                            <a href={day.hotel_link} target="_blank" rel="noopener noreferrer" className="text-xs text-blue-600 hover:underline inline-flex items-center gap-1 mt-1">
                                                                                <i className="fas fa-external-link-alt"></i> Hotel website
                                                                            </a>
                                                                        )}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        )}
                                                    </Draggable>
                                                ))}
                                                {provided.placeholder}
                                            </div>
                                        )}
                                    </Droppable>
                                </DragDropContext>
                                <div className="mt-6 pt-4 border-t border-gray-200">
                                    <div className="flex flex-wrap justify-between items-center gap-4">
                                        <div>
                                            <p className="font-bold text-xl text-med-blue">Total: {itinerary.totalCost} TND</p>
                                            <p className="text-sm text-gray-500"><i className="fas fa-cloud-sun"></i> Weather: {itinerary.weather}</p>
                                        </div>
                                        {user && (
                                            <button
                                                onClick={() => setShowSaveModal(true)}
                                                className="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-5 rounded-xl transition flex items-center gap-2 shadow-md"
                                            >
                                                <i className="fas fa-save"></i> Save Itinerary
                                            </button>
                                        )}
                                    </div>
                                </div>
                            </>
                        ) : (
                            <div className="text-center py-16 bg-gray-50 rounded-xl">
                                <i className="fas fa-map-marked-alt text-5xl text-gray-300 mb-3"></i>
                                <p className="text-gray-500">Fill the form and click "Generate My Trip" to see your personalized itinerary.</p>
                            </div>
                        )}
                    </div>
                </div>

                {/* Save Modal */}
                {showSaveModal && (
                    <div className="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 backdrop-blur-sm animate-fade-in">
                        <div className="bg-white rounded-2xl p-8 w-full max-w-md shadow-2xl transform transition-all">
                            <h3 className="text-2xl font-bold font-playfair text-med-blue mb-4">Save Your Trip</h3>
                            <label className="block mb-2 font-semibold text-gray-700">Trip Name</label>
                            <input
                                type="text"
                                value={tripName}
                                onChange={e => setTripName(e.target.value)}
                                className="border border-gray-200 rounded-xl w-full p-3 mb-6 focus:ring-2 focus:ring-tunisia-gold focus:border-transparent"
                            />
                            <div className="flex justify-end gap-3">
                                <button onClick={() => setShowSaveModal(false)} className="px-5 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition">Cancel</button>
                                <button onClick={saveItinerary} className="px-5 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition shadow-md">Save</button>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}

const rootElement = document.getElementById('app');
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(
        <BrowserRouter>
            <TripPlanner />
        </BrowserRouter>
    );
}