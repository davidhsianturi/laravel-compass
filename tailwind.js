module.exports = {
    theme: {
        extend: {
            colors: {
                'primary': '#e79334',
                'secondary': '#fafafa',
            },
            spacing: {
                '72': '18rem',
                '80': '20rem',
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
    plugins: []
}
