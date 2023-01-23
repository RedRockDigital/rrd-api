/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.{js,jsx}",
        "./node_modules/rrd-ui/dist/**/*.{js,jsx}",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("@tailwindcss/typography"),
    ],
};
