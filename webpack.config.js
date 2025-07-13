// webpack.config.js
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = (env, argv) => {
  const isProduction = argv.mode === 'production';
  
  return {
    entry: {
      'admin': './assets/js/admin.js',
      'admin-styles': './assets/css/admin.scss',
      'product-template-manager': './assets/js/product-template-manager.js', 

    },
    
    output: {
      path: path.resolve(__dirname, 'assets/dist'),
      filename: 'js/[name].min.js',
      clean: true
    },
    
    module: {
      rules: [
        {
          test: /\.jsx?$/, 
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env'],
              plugins: [ 
                ['@babel/plugin-transform-react-jsx', {
                  runtime: 'automatic', // Habilita el nuevo JSX transform
                  importSource: 'preact' // Le dice a Babel que use Preact para las importaciones de JSX
                }]
              ]
            }
          }
        },
        {
          test: /\.(scss|css)$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader',
            {
              loader: 'sass-loader',
              options: {
                sassOptions: {
                  outputStyle: isProduction ? 'compressed' : 'expanded'
                }
              }
            }
          ]
        },
        {
          test: /\.(png|jpg|jpeg|gif|svg)$/i,
          type: 'asset/resource',
          generator: {
            filename: 'images/[name][ext]'
          }
        },
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/i,
          type: 'asset/resource',
          generator: {
            filename: 'fonts/[name][ext]'
          }
        }
      ]
    },

    resolve: { 
     extensions: ['.js', '.jsx', '.json', '.wasm'], 
      alias: {
        'react': 'preact/compat',
        'react-dom/test-utils': 'preact/test-utils',
        'react-dom': 'preact/compat',     // Asegura que react-dom también use preact/compat
        'react/jsx-runtime': 'preact/jsx-runtime' // Para el nuevo JSX transform automático
      }
    },
    
    plugins: [
      new MiniCssExtractPlugin({
        filename: 'css/[name].min.css'
      })
    ],
    
    optimization: {
      minimize: isProduction,
      minimizer: [
        new TerserPlugin({
          terserOptions: {
            compress: {
              drop_console: isProduction
            }
          }
        }),
        new CssMinimizerPlugin()
      ]
    },
    
    devtool: isProduction ? false : 'source-map',
    
    watch: !isProduction,
    
    watchOptions: {
      ignored: /node_modules/,
      aggregateTimeout: 300,
      poll: 1000
    }
  };
};