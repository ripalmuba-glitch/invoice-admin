const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors'); // <-- MODIFIKASI 1: Tambahkan ini

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // MODIFIKASI 2: Ganti font 'sans'
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // MODIFIKASI 3: Tambahkan palet 'primary'
                primary: colors.blue,
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
