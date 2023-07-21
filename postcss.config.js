const tailwindcss = require('tailwindcss');

module.exports = {
    plugins: {
        'postcss-import': {},
        autoprefixer: {},
        'tailwindcss/nesting': 'postcss-nested',
        tailwindcss: {},
        'postcss-preset-env': {
            features: {'nesting-rules': false},
        }
    }
}
