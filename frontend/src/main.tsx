import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { App } from './App';
import './index.css';

// Extend Window interface
declare global {
  interface Window {
    TodoApp: {
      App: typeof App;
    };
  }
}

// Export the App component to the global window object
// This is necessary for WordPress integration
window.TodoApp = {
  App,
};

// Only mount the app when running in development mode
// In WordPress, we'll use the global App component
if (document.getElementById('root')) {
  createRoot(document.getElementById('root')!).render(
    <StrictMode>
      <App />
    </StrictMode>
  );
}
