module.exports = Scroll;

Scroll.$inject = ['$timeout'];

function Scroll($timeout) {
    //scroll to selected id(hash)
    function scroll(hash) {
        return function () {
            var scrollPane = angular.element('html, body');
            var scrollTo = angular.element('#' + hash);
            console.log(scrollTo);
            if (scrollTo.length > 0) {
                var scrollDist = scrollTo.offset().top;
                console.log(scrollDist, 'scrollDist');

                var header = angular.element('nav.navbar-default').prop('offsetHeight') || 0;
                console.log(header, 'header');

                var scrollY = scrollDist - header;
                console.log(scrollY, 'scrollY');

                scrollPane.animate({scrollTop: scrollY}, 750, 'swing', function () {
                    console.log('done');
                });
            }
        }
    }
    return {
        scrollTo: function (hash) {
            $timeout(scroll(hash), 100);
        }

    };
}
