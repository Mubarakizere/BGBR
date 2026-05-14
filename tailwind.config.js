import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#1E2FA3',
                secondary: '#F4C542',
                success: '#22C55E',
                danger: '#D62828',
                accent: '#8BC665',
                background: '#F8FAFC',
                surface: '#FFFFFF',
                text: '#101828',
                muted: '#667085',
                border: '#E4E7EC',
            }
        },
    },

    plugins: [forms],
};
