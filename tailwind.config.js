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
                title: ['Eb Garamond', 'serif'],
                body: ['Old Standard TT', 'serif'],
            },
            colors: {
                'black': '#1A1A1A',
                'white': '#F8F5E9',
                'gray': '#808080',
                "yellow": "#D4A017",
            },
        },
    },
    plugins: [forms],
};
