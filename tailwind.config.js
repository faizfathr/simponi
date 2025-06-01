import { persist } from 'alpinejs';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-25': '#f2f7ff',
                'brand-50': '#ecf3ff',
                'brand-500': '#465fff',
                'brand-600': '#3641f5',
                'primary': '#465fff',
                'success-50': '#ecfdf3',
                'success-500': '#12b76a',
                'success-600': '#039855',
                'warning-50': '#fffaeb',
            },
            keyframes: {
                progressAnimation: {
                    '0%': {
                        width: '0%',
                    },
                    '100%': {
                        width: '100%',
                    },
                },
            },
            animation: {
                'progress': 'progressAnimation 3000ms linear forwards',
            }
        },
    },
    plugins: [
        require('daisyui'),
        require('tailwind-scrollbar-hide')
    ],
};
