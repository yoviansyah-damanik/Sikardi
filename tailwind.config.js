const { addDynamicIconSelectors } = require('@iconify/tailwind');
const { iconsPlugin, getIconCollections } = require("@egoist/tailwindcss-icons")

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    content: [
        "./resources/**/*.blade.php",
        "./app/View/**/*.php",
    ],
    theme: {
        fontFamily: {
            'body': ['QuickSand', 'serif'],
        },
        extend: {
            colors: {
                'scampi': {
                    '50': '#f4f6fa',
                    '100': '#e6eaf3',
                    '200': '#d3daea',
                    '300': '#b5c2db',
                    '400': '#92a3c8',
                    '500': '#7889b9',
                    '600': '#6572ab',
                    '700': '#5a639c',
                    '800': '#4d5380',
                    '900': '#414667',
                    '950': '#2b2d40',
                },
                primary: {
                    '50': '#f2fbfa',
                    '100': '#d2f5f2',
                    '200': '#97e7e1',
                    '300': '#70d8d4',
                    '400': '#42bfbe',
                    '500': '#29a2a3',
                    '600': '#1e8083',
                    '700': '#1c6669',
                    '800': '#1b5154',
                    '900': '#1a4547',
                    '950': '#09272a',
                },
                green: {
                    50: '#edfff5',
                    100: '#d6ffea',
                    200: '#afffd5',
                    300: '#71ffb7',
                    400: '#2dfb90',
                    500: '#02e570',
                    600: '#00bf59',
                    700: '#009b4c',
                    800: '#06753d',
                    900: '#085f34',
                    950: '#00361b',
                },
                yellowSmooth: {
                    50: '#fdffe7',
                    100: '#f8ffc1',
                    200: '#f5ff86',
                    300: '#f7ff41',
                    400: '#fffe0d',
                    500: '#fff000',
                    600: '#d1b300',
                    700: '#a68102',
                    800: '#89640a',
                    900: '#74520f',
                    950: '#442c04',
                },
                lotus: {
                    50: '#fcf4f4',
                    100: '#f9e8e7',
                    200: '#f5d4d3',
                    300: '#edb6b4',
                    400: '#e08c89',
                    500: '#d16562',
                    600: '#bc4a46',
                    700: '#9d3b38',
                    800: '#833331',
                    900: '#743331',
                    950: '#3b1514',
                },
            },
        },
    },
    safelist: [
        'swal2-container'
    ],
    plugins: [
        // Iconify plugin
        addDynamicIconSelectors(),
        iconsPlugin({
            // Select the icon collections you want to use
            // You can also ignore this option to automatically discover all individual icon packages you have installed
            // If you install @iconify/json, you should explicitly specify the collections you want to use, like this:
            collections: getIconCollections(['solar', 'ph']),
            // If you want to use all icons from @iconify/json, you can do this:
            // collections: getIconCollections("all"),
            // and the more recommended way is to use `dynamicIconsPlugin`, see below.
        }),
    ],
}

