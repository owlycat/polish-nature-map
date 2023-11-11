import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'surface-a': 'var(--surface-a)',
                'surface-b': 'var(--surface-b)',
                'surface-c': 'var(--surface-c)',
                'surface-d': 'var(--surface-d)',
                'surface-e': 'var(--surface-e)',
                'surface-f': 'var(--surface-f)',
                'text-color': 'var(--text-color)',
                'text-color-secondary': 'var(--text-color-secondary)',
                'primary': 'var(--primary-color)',
                'primary-text': 'var(--primary-color-text)',
                'surface': {
                    '0': 'var(--surface-0)',
                    '50': 'var(--surface-50)',
                    '100': 'var(--surface-100)',
                    '200': 'var(--surface-200)',
                    '300': 'var(--surface-300)',
                    '400': 'var(--surface-400)',
                    '500': 'var(--surface-500)',
                    '600': 'var(--surface-600)',
                    '700': 'var(--surface-700)',
                    '800': 'var(--surface-800)',
                    '900': 'var(--surface-900)',
                },
                'highlight': {
                    'bg': 'var(--highlight-bg)',
                    'text-color': 'var(--highlight-text-color)',
                },
            }
        },
    },

    plugins: [forms, typography],
};
