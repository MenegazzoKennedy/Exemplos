module.exports = {
  "transpileDependencies": [
    "vuetify"
  ],
  productionSourceMap: false,
  configureWebpack: {
    optimization: {
      splitChunks: {
        chunks: 'all',
        maxInitialRequests: Infinity,
        minSize: 10000,
        maxSize: 20000,
      }
    }
  },
  publicPath: process.env.NODE_ENV === 'production'
    ? '/imobl-app/'
    : '/imobl-app/'
}