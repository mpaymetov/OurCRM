var path = require('path');

module.exports = {
    entry: "./react-app/src/index.jsx", // входная точка - исходный файл
    output:{
        path: path.resolve(__dirname),
        publicPath: 'web/js',
        filename: "web/js/bundle.js"       // название создаваемого файла
    },
    module:{
        rules:[   //загрузчик для js
            {
                test: /\.jsx?$/, // определяем тип файлов
                exclude: /(node_modules)/,  // исключаем из обработки папку node_modules
                loader: "babel-loader",   // определяем загрузчик
                options:{
                    presets:["@babel/preset-env", "@babel/preset-react"]    // используемые плагины
                }
            }
        ]
    }
}