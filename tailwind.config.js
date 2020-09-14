module.exports = {
    purge: {
        content: [
            './resources/**/*.blade.php',
            './resources/**/*.vue',
            './resources/**/*.js'
        ],
        options: {
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/]
        }
    },
    theme: {
        boxShadow: {
            default: '0 15px 35px 0 rgba(94, 59, 59, .1)'
        },
        extend: {
            colors: {
                primary: {
                    default: '#f75858',
                    light: '#fbe8e7',
                    dark: '#f64949'
                },
                secondary: {
                    default: '#f5f5fa'
                },
                light: '#fff7f1'
            },
            spacing: {
                '72': '18rem',
                '80': '20rem'
            },
            padding: {
                '5/6': '83.3333333%'
            }
        }
    },
    variants: {
        tableLayout: ['responsive', 'hover', 'focus'],
        borderColor: ['responsive', 'hover', 'focus', 'focus-within']
    },
    plugins: [],
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true
    }
}
