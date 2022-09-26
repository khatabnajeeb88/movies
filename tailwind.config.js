/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.{vue,js,ts,jsx,tsx}",
    "./templates/**/*.{html,twig}",
  ],
  theme: {
    extend: {
      backgroundImage: {
        heron: "url('/images/image1.jpg')",
      },
    },
    colors: {
      midnight: "#121063",
    },
  },
  plugins: [],
};
