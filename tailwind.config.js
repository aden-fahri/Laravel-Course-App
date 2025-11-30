/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                serene: {
                    50: "#f0fdf4",
                    100: "#dcfce7",
                    200: "#bbf7d0",
                    300: "#86efac",
                    400: "#4ade80",
                    500: "#22c55e",
                    600: "#16a34a",
                    700: "#15803d",
                    800: "#166534",
                    900: "#14532d",
                },
            },
            fontFamily: {
                sans: ["Inter", "system-ui", "sans-serif"],
            },
            borderRadius: {
                xl: "0.75rem",
                "2xl": "1rem",
                "3xl": "1.5rem",
            },
            boxShadow: {
                soft: "0 4px 15px rgba(0,0,0,0.06)",
                card: "0 8px 25px rgba(0,0,0,0.08)",
                float: "0 12px 35px rgba(0,0,0,0.1)",
            },
            spacing: {
                18: "4.5rem",
                22: "5.5rem",
            },
        },
    },
    plugins: [],
};
