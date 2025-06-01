// assets/js/admin.js
import { render } from 'preact';
import AdminPageApp from './components/AdminPageApp';
import { MantineProvider } from '@mantine/core';
import '@mantine/core/styles.css';

document.addEventListener('DOMContentLoaded', () => {
  const rootElement = document.getElementById('pagina_preact_root');
  if (rootElement) {
    const initialPhpData = window.wpLaravelAdminData || {}; // Este es el objeto clave
    
    render(
      <MantineProvider withGlobalStyles withNormalizeCSS theme={{ colorScheme: 'light' }}>
        <AdminPageApp config={initialPhpData} /> {/* Pasamos todo el objeto como 'config' */}
      </MantineProvider>,
      rootElement
    );
  }
});