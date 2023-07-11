/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    colors: {
      primary_first: '#7451EB',
      dark_primary_first: '#231947',
      mid_primary_first: '#372770',
      ligth_primary_first: '#D1C4FD',
      ligther_primary_first: '#EFEBFC',
      primary_second: '#F4CF74',
      dark_primary_second: '#644D15',
      mid_primary_second: '#9A7825',
      ligth_primary_second: '#F7DEA2',
      ligther_primary_second: '#FFFAEE',
      dark_neutral: '#282828',
      mid_neutral: '#ADADAD',
      ligth_neutral: '#FDFDFD',
      ligther_neutral: '#FFFFFF',
    },
    boxShadow: {
      shadow_1: '0 2px 6px 0px rgba(20, 20, 43, 0.06)',
      shadow_2: '0 2px 12px 0px rgba(20, 20, 43, 0.08)',
      shadow_3: '0 8px 28px 0px rgba(20, 20, 43, 0.1)',
      shadow_4: '0 14px 42px 0px rgba(20, 20, 43, 0.14)',
      shadow_5: '0 24px 65px 0px rgba(20, 20, 43, 0.16)',
      shadow_6: '0 32px 72px 0px rgba(20, 20, 43, 0.24)',
    },
    extend: {},
  },
  plugins: [],
}