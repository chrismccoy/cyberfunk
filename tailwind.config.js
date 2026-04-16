/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './template-parts/**/*.php',
    './inc/**/*.php',
    './assets/js/**/*.js',
  ],
  safelist: [
    'read-badge',
    'js-reveal',
    'revealed',
    'is-read',
    'kb-focused',
    'nav-scrolled',
    'is-open',
  ],
  theme: {
    extend: {
      colors: {
        base:    '#0a0a0f',
        surface: '#12121a',
        neon:    '#f5e642',
        cyber:   '#00f0ff',
        danger:  '#ff003c',
        signal:  '#39ff14',
        text:    '#e8e8ff',
        muted:   '#7a7a9a',
      },
      fontFamily: {
        sans:    ['Rajdhani', 'sans-serif'],
        display: ['Orbitron', 'sans-serif'],
      },
      maxWidth: {
        layout:  '1240px',
        content: '864px',
        sidebar: '340px',
      },
      spacing: {
        nav:  '58px',
        grid: '36px',
      },
      boxShadow: {
        'glow-neon':     '0 0 24px rgba(245,230,66,0.1), 0 0 48px rgba(245,230,66,0.06)',
        'glow-neon-lg':  '0 0 36px rgba(245,230,66,0.75)',
        'glow-cyber':    '0 0 12px rgba(0,240,255,0.2)',
        'glow-cyber-lg': '0 0 24px rgba(0,240,255,0.35)',
      },
      keyframes: {
        scan: {
          '0%':   { top: '-10px' },
          '100%': { top: '100vh' },
        },
        'pulse-dot': {
          '0%, 100%': { opacity: '1', transform: 'scale(1)' },
          '50%':      { opacity: '0.5', transform: 'scale(1.4)' },
        },
        blink: {
          '0%, 100%': { opacity: '1' },
          '50%':      { opacity: '0.3' },
        },
      },
      animation: {
        scan:        'scan 5s linear infinite',
        'pulse-dot': 'pulse-dot 2s ease-in-out infinite',
        blink:       'blink 1.5s step-end infinite',
      },
    },
  },
  plugins: [],
};
