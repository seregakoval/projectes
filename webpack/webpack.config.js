 'use strict';
  module.exports = {
      entry: "./main_js",
      resolve: {
        modulesDirectories: ['node_modules']
      },
      output: {
          filename: "build.js"
      },
      module: {
        loaders: [{
            test: /\.js/,
            loader: 'babel',
            exclue: /(node_modules|boser_components)/
        },
            {
                test: /\.css$/,
                loader: 'style!css'
            }
        ]
      }
  };