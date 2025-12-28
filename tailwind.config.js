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
                'child-primary': '#6366F1', // Indigo 500
                'child-secondary': '#8B5CF6', // Violet 500
                'child-accent-green': '#10B981', // Emerald 500
                'child-accent-yellow': '#F59E0B', // Amber 500
                'child-info': '#3B82F6',    // Blue 500
                'child-success': '#10B981', // Emerald 500
                'child-warning': '#F59E0B', // Amber 500
                'child-danger': '#EF4444',  // Red 500
                'child-bg-light': '#F3F4F6', // Gray 100
                'child-text-dark': '#1F2937', // Gray 800
            },
        },
    },

    plugins: [forms],
};
