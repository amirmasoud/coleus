const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: ['NotoSansArabic', 'NotoSans', ...defaultTheme.fontFamily.sans]
      },
      colors: {
        coleus: {
          gray: '#2F495E',
          lightgreen: '#00C58E',
          green: '#108775'
        }
      },
      fill: (theme) => ({
        'coleus-gray': theme('colors.coleus.gray'),
        'coleus-lightgreen': theme('colors.coleus.lightgreen'),
        'coleus-green': theme('colors.coleus.green')
      }),
      stroke: (theme) => ({
        'coleus-gray': theme('colors.coleus.gray'),
        'coleus-lightgreen': theme('colors.coleus.lightgreen'),
        'coleus-green': theme('colors.coleus.green')
      }),
      boxShadow: {
        coleus: '0 0 8px 0 rgba(10, 31, 68, 0.08)'
      },
      inset: {
        24: '6rem'
      }
    }
  },
  variants: {
    textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    boxShadow: ['responsive', 'group-hover']
  },
  plugins: [],
  purge: {
    enabled: true, // process.env.NODE_ENV === 'production',
    content: [
      'components/**/*.vue',
      'layouts/**/*.vue',
      'pages/**/*.vue',
      'plugins/**/*.js',
      'nuxt.config.js'
    ]
  }
}
