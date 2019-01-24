// @ts-check
const webpack = require('webpack')
const webpackDevServer = require('webpack-dev-server')
const merge = require('webpack-merge')
const autoprefixer = require('autoprefixer')
const AssetsPlugin = require('assets-webpack-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin')
const path = require('path')
const fs = require('fs')

const appDirectory = fs.realpathSync(process.cwd())

function resolveApp(relPath) {
  return path.resolve(appDirectory, relPath)
}

const paths = {
  src: resolveApp('src'),
  dist: resolveApp('dist'),
  entries: {
    main: resolveApp('src/index.ts'),
    home: resolveApp('src/templates/home/index.ts')
  },
  appNodeModules: resolveApp('node_modules')
}

const isDev = process.env.NODE_ENV === 'development'

/** @type webpack.Configuration */
const config = {
  mode: isDev ? 'development' : 'production',
  bail: !isDev,
  target: 'web',
  stats: 'errors-only',
  devtool: isDev ? 'cheap-eval-source-map' : 'source-map',
  entry: paths.entries,
  output: {
    path: paths.dist,
    filename: isDev ? '[name].bundle.js' : '[name].bundle.[hash:8].js'
  },
  resolve: {
    alias: {
      '@': paths.src
    },
    extensions: ['.ts', '.tsx', '.js']
  },
  module: {
    rules: [
      { parser: { requireEnsure: false } },
      { test: /\.tsx?$/, loader: 'ts-loader' },
      {
        test: /\.scss$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: ['css-loader', 'sass-loader']
        })
      }
    ]
  },

  plugins: [
    // @ts-ignore
    new ExtractTextPlugin({
      filename: getPath => {
        return getPath('css/[name].css').replace('css/js', 'css')
      },
      allChunks: true
    }),
    new AssetsPlugin({
      path: paths.dist,
      filename: 'assets.json'
    }),
    isDev &&
      new BrowserSyncPlugin({
        notify: false,
        host: 'localhost',
        port: 4000,
        logLevel: 'silent',
        files: ['./*.php'],
        proxy: 'http://localhost:8080/'
      })
  ].filter(Boolean)
}

module.exports = config
