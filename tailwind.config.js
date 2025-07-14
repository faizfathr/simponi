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
             maxHeight: {
      'screen': '100vh',
      '90vh': '90vh',
    },
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
                barUpDown: {
                    '0%, 100%': { transform: 'scaleY(0.5)' },
                    '50%': { transform: 'scaleY(1.5)' },
                },
            },
            animation: {
                'progress': 'progressAnimation 3000ms linear forwards',
                'bar-1': 'barUpDown 1s ease-in-out infinite',
                'bar-2': 'barUpDown 1s ease-in-out infinite 0.1s',
                'bar-3': 'barUpDown 1s ease-in-out infinite 0.2s',
                'bar-4': 'barUpDown 1s ease-in-out infinite 0.3s',
                'bar-5': 'barUpDown 1s ease-in-out infinite 0.4s',
            }
        },
    },
    plugins: [
        require('daisyui'),
        require('tailwind-scrollbar-hide')
    ],
};
