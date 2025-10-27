// webpack.config.js
/**
 * Webpack configuration.
 */
const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

// const cssnano = require('cssnano'); // https://cssnano.co/
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const webpack = require("webpack");
// JS Directory path.
const JS_DIR = path.resolve(__dirname, "assets/js");
const IMG_DIR = path.resolve(__dirname, "assets/img");
const BUILD_DIR = path.resolve(__dirname, "build");
const entry = {
  index: JS_DIR + "/index.js",
  user: JS_DIR + "/cdc-user.js",
  blog: JS_DIR + "/blog.js",
  main: JS_DIR + "/css.js",
  fontawesome: JS_DIR + "/fonts.js",
};
const output = {
  path: BUILD_DIR,
  filename: "js/[name].js",
};
/**
 * Note: argv.mode will return 'development' or 'production'.
 */
const plugins = (argv) => [
  new CleanWebpackPlugin({
    cleanStaleWebpackAssets: argv.mode === "production", // Automatically remove all unused webpack assets on rebuild, when set to true in production. ( https://www.npmjs.com/package/clean-webpack-plugin#options-and-defaults-optional )
  }),
  new MiniCssExtractPlugin(),
  new TerserPlugin(),
];
const rules = [
  {
    test: /\.js$/,
    include: [JS_DIR],
    exclude: /node_modules/,
    use: "babel-loader",
  },
  {
    test: /\.(woff|woff2|eot|ttf|otf)$/i,
    type: "asset/resource",
    use: [
      "file-loader",
      // 'css-loader',
      // 'sass-loader',
      // 'file-loader'
    ],
  },
  {
    test: /\.(sa|sc|c)ss$/,
    use: [
      MiniCssExtractPlugin.loader,
      // 'style-loader',
      "css-loader",
      "postcss-loader",
      "sass-loader",
    ],
  },

  {
    test: /\.(png|jpg|svg|jpeg|gif|ico)$/,
    use: {
      loader: "file-loader",
      options: {
        name: "[path][name].[ext]",
        publicPath: "production" === process.env.NODE_ENV ? "../" : "../../",
      },
    },
  },
];
/**
 * Since you may have to disambiguate in your webpack.config.js between development and production builds,
 * you can export a function from your webpack configuration instead of exporting an object
 *
 * @param {string} env environment ( See the environment options CLI documentation for syntax examples. https://webpack.js.org/api/cli/#environment-options )
 * @param argv options map ( This describes the options passed to webpack, with keys such as output-filename and optimize-minimize )
 * @return {{output: *, devtool: string, entry: *, optimization: {minimizer: [*, *]}, plugins: *, module: {rules: *}, externals: {jquery: string}}}
 *
 * @see https://webpack.js.org/configuration/configuration-types/#exporting-a-function
 */
module.exports = (env, argv) => ({
  entry: entry,
  output: output,
  /**
   * A full SourceMap is emitted as a separate file ( e.g.  main.js.map )
   * It adds a reference comment to the bundle so development tools know where to find it.
   * set this to false if you don't need it
   */
  devtool: "source-map",
  module: {
    rules: rules,
  },
  optimization: {
    minimizer: [new CssMinimizerPlugin()],
  },
  plugins: plugins(argv),
  externals: {
    jquery: "jQuery",
  },
});
