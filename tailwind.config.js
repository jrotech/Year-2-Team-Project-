import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.{js,ts,jsx,tsx,mdx}',
    './resources/**/**/*.{js,ts,jsx,tsx,mdx}',
    './resources/**/*.vue',
    './resources/**/*.{vue,js,ts,jsx,tsx,mdx}',],
  theme: {
    extend: {
      colors: {
        main: {
	  primary: "#010035",
	  accent: "#860017",
	  green: "#0EFF32",
	  bg: "#f5f5f5",
          darken: "rgba(0,0,0, 0.7)",
          dark: "#141414",
          black: "#111111",
        },
	
      },
      boxShadow: {
        main: " 0px 3px 8px rgba(0, 0, 0, 0.24)",
      },
      
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
    },
    plugins: [],
};
