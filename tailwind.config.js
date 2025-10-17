/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public_html/**/*.{php,html,js}",
    "./public_html/modules/**/*.{php,html,js}",
    "./public_html/assets/**/*.{php,html,js}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          red: '#ff0000',
          blue: '#3b82f6', 
          green: '#10b981',
          grey: '#353535',
          DEFAULT: '#3b82f6',
        }
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}