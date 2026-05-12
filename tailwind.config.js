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
                bgbr: {
                    blue: '#1E2FA3',
                    gold: '#F4C542',
                    red: '#D62828',
                    green: '#8BC665',
                    dark: '#101828',
                    bg: '#F8FAFC',
                }
            }
        },
    },

    plugins: [forms],
};
