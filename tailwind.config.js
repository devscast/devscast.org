/** @type {import('tailwindcss').Config} */

const plugin = require('tailwindcss/plugin');
export default {
    content: ['./templates/**/*.html.twig'],
    darkMode: "class",
    theme: {
        extend: {
            colors:{
                primary : "var(--color-primary)",
                secondary : "var(--color-secondary)",
                background:{
                    DEFAULT : "var(--background)",
                    card:"var(--bg-card)",
                    "card-inside":"var(--bg-card-inside)",
                },
                fg:{
                    DEFAULT :"var(--foreground)",
                    "heading1":"var(--fg-heading1)",
                    "heading2":"var(--fg-heading2)",
                    "heading3":"var(--fg-heading3)",
                },
                bdr:{
                    DEFAULT:"var(--border)",
                    "bdr-1":"var(--border)",
                    "bdr-2":"var(--border)",
                }
            },
            borderRadius:{
                "outer-radius":"0.5rem",
                "inner-radius-gradient":"7px",
                "radius-inside1":"0.375rem",
                "radius-inside2":"",
            },
            screens:{
                xs:"330px"
            },
            zIndex:{
                60:"60",
                70:"70",
                80:"80"
            }
        },
    },
    plugins: [
        plugin(function({ addVariant }) {
            addVariant('children', '&>*')
        }),
        require('@tailwindcss/typography')
    ],
}
