import React from 'react';
import ReactDOM from 'react-dom/client';
import ExploreMap from './components/ExploreMap';

// Make sure DOM is fully loaded before rendering
window.addEventListener('load', () => {
    const rootElement = document.getElementById('map-app');
    if (rootElement) {
        const root = ReactDOM.createRoot(rootElement);
        root.render(<ExploreMap />);
    }
});