// @ts-check
const webpack = require('webpack')
const config = require('./webpack.config')

/** @type webpack.Compiler */
const clientCompiler = webpack(config)

clientCompiler.watch({ poll: true }, (err, stats) => {
  if (err) {
    console.log(err)
    return
  }
})
