const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      fontFamily: {
        sans: [
          'NotoSansArabic',
          'NotoSans',
          ...defaultTheme.fontFamily.sans
        ]
      },
      colors: {
        negarin: {
          gray: '#2F495E',
          lightgreen: '#00C58E',
          green: '#108775'
        }
      },
      fill: theme => ({
        'negarin-gray': theme('colors.negarin.gray'),
        'negarin-lightgreen': theme('colors.negarin.lightgreen'),
        'negarin-green': theme('colors.negarin.green')
      }),
      stroke: theme => ({
        'negarin-gray': theme('colors.negarin.gray'),
        'negarin-lightgreen': theme('colors.negarin.lightgreen'),
        'negarin-green': theme('colors.negarin.green')
      }),
      boxShadow: {
        negarin: '0 0 8px 0 rgba(10, 31, 68, 0.08)'
      },
      inset: {
        24: '6rem'
      }
    }
  },
  variants: {
    textColor: ['responsive', 'hover', 'focus', 'group-hover']
  },
  plugins: []
}
