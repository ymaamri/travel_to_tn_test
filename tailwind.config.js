/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'tunisia-red': '#C1121F',
        'tunisia-red-dark': '#780000',
        'tunisia-gold': '#D4AF37',
        'tunisia-gold-light': '#F4E4B1',
        'med-blue': '#1D3557',
        'deep-teal': '#2A4B4C',
        'sand': '#F4EADB',
        'sand-light': '#FBF7F0',
        'cream': '#FFFDF7',
        'charcoal': '#1E1E24',
      },
      fontFamily: {
        'playfair': ['Playfair Display', 'serif'],
        'cinzel': ['Cinzel', 'serif'],
        'inter': ['Inter', 'sans-serif'],
      },
      animation: {
        'fade-in-up': 'fadeInUp 0.3s ease-out',
      },
      keyframes: {
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
};