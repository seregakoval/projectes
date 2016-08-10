module.exports = ToasterError;

ToasterError.$inject = ['toaster'];

function ToasterError(toaster) {
    var showError = function (data, showIndexTitle) {
        //for exceptions        
        if (typeof (data.message) != 'undefined') {
            toaster.pop('error', 'Error', data.message);
        } else {
            angular.forEach(data, function (error, index) {
                var message = "";
                var title = showIndexTitle ? index : '';
                angular.forEach(error, function (value, key) {
                    message += value + '<br/>';
                });

                toaster.pop('error', title, message);
            })
        }
    }
    return {
        showError: function (data, showIndexTitle) {          
            if (typeof (showIndexTitle) == 'undefined') {
                showIndexTitle = false;
            }
            return showError(data.data, showIndexTitle);
        },
    };
}
