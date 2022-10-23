const Encore = require('@symfony/webpack-encore');
const WorkboxPlugin = require('workbox-webpack-plugin');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets')

    .addEntry('app', './assets/app/index.js')
    .addEntry('admin', './assets/admin/index.js')
    .enableStimulusBridge('./assets/shared/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureImageRule({type: 'asset', maxSize: 4 * 1024})
    .configureFontRule({type: 'asset', maxSize: 4 * 1024})

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    .enableSassLoader()
    .enablePostCssLoader((config) => {
        config.postcssOptions = {
            path: './postcss.config.js'
        };
    })
    .enableIntegrityHashes(Encore.isProduction())
;

// service worker precache assets
Encore.addPlugin(new WorkboxPlugin.InjectManifest({
    additionalManifestEntries: [],
    include: [
        /^css.(.+)?(css|js)$/,
    ],
    maximumFileSizeToCacheInBytes: 5 * 1024 * 1024,
    swSrc: './assets/app/js/sw.js',
    swDest: '../sw.js', // public/sw.js
    mode: Encore.isProduction ? 'production' : 'development'
}), -10);

Encore.addExternals({
    'bootstrap': 'bootstrap'
})

module.exports = Encore.getWebpackConfig();
