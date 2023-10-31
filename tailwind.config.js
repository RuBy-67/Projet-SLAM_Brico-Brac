/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./index.php", "./pages/*", "./templates/*"],
    theme: {
        container: {
            center: true,
        },
        extend: {
            colors: {
                black: "#222222",
                white: "#f3f3f3",
                lightGrey: "#616161",
                darkGrey: "#2C2C2C",
                primary: "#12465A",
            },
            fontSize: {
                h1: "56px",
                h2: "48px",
                h3: "40px",
                h4: "32px",
                h5: "24px",
                base: "16px",
                xs: "11px",
            },
            fontFamily: {
                title: ["Barlow", "sans-serif"],
                text: ["Roboto", "sans-serif"],
            },
            backgroundImage: {
                "top-banner": "url('../assets/top-banner-bg.png')",
            },
        },
    },
    plugins: [],
};
