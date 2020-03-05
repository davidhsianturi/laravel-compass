module.exports = {
    theme: {
        extend: {
            colors: {
                'primary': '#f75858',
                'secondary': '#f5f5fa',
                'light': '#fff7f1'
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
