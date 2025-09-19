const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
  const isProduction = argv.mode === 'production';

  return {
    entry: {
      main: './src/js/main.js',
      navigation: './src/js/navigation.js',
      admin: './src/js/admin.js',
      // Add SCSS entry point for proper compilation
      styles: './src/scss/main.scss'
    },
    output: {
      path: path.resolve(__dirname, 'assets'),
      filename: 'js/[name].js',
      clean: false // Don't clean images folder
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          }
        },
        {
          test: /\.scss$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader',
            {
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: [
                    require('autoprefixer')
                  ]
                }
              }
            },
            {
              loader: 'sass-loader',
              options: {
                sassOptions: {
                  includePaths: [
                    path.resolve(__dirname, 'node_modules'),
                    path.resolve(__dirname, 'src/scss')
                  ]
                }
              }
            }
          ]
        },
        {
          test: /\.(png|jpg|jpeg|gif|svg|ico)$/,
          type: 'asset/resource',
          generator: {
            filename: 'images/[name][ext]'
          }
        },
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          type: 'asset/resource',
          generator: {
            filename: 'fonts/[name][ext]'
          }
        }
      ]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: 'css/[name].css'
      })
    ],
    resolve: {
      extensions: ['.js', '.scss', '.css'],
      alias: {
        '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        '~': path.resolve(__dirname, 'node_modules')
      }
    },
    devtool: isProduction ? false : 'source-map',
    optimization: {
      minimize: isProduction
    },
    externals: {
      jquery: 'jQuery'
    }
  };
};
