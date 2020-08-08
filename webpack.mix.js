const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

mix
    .js("resources/js/qwertypayment.form.js", "public/js/qwertypayment.form.js")
    .js("resources/js/oldpayment.form.js", "public/js/oldpayment.form.js")
    .sass("resources/sass/app.scss", "public/css")
    .options({
        processCssUrls: false,
        postCss: [tailwindcss("./tailwind.config.js")]
    })
    .browserSync({
        proxy: 'my-domain.test'
    });
