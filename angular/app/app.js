/**
 * Style Guide
 * @link https://github.com/johnpapa/angular-styleguide
 */

module.exports = AppProvider;

AppProvider.$inject = [];

function AppProvider() {
    var provider = this;

    this.config = {};
    this.viewPath = viewPath;
    this.$get = App;

    App.$inject = [];

    function App() {

        var app = {
            viewPath: viewPath
        };

        Object.defineProperties(app, {
            config: {
                get: function () {
                    return provider.config;
                }
            },
        });
        return app;
    }

    /**
     * Get view path
     *
     * @param {string} path
     * @returns {string}
     */
    function viewPath(path) {
        return 'views/' + path + '.html';
    }
}
