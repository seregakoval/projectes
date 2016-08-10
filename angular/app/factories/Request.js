module.exports = Request;

Request.$inject = ['$timeout'];

function Request() {
    return {
        //transform to form data(for files)
        transformRequestToFormData: function (data) {
            if (data === undefined)
                return data;
            var formData = new FormData();
            function set(key, value) {
                if (value instanceof File) {
                    formData.append(key, value);
                }
                else if (value instanceof Blob) {
                    formData.append(key, value, "image.png");
                }
                else if (typeof (value) == "object") {
                    for (var i in value) {
                        set(key + '[' + i + ']', value[i]);
                    }
                } else if (value instanceof FileList) {
                    if (value.length == 1) {
                        formData.append(key, value[0]);
                    } else {
                        for (var i in value) {
                            set(key + '[' + i + ']', value[i]);
                        }
                        /*angular.forEach(value, function (file, index) {
                         formData.append(key + '_' + index, file);
                         });*/
                    }
                } else {
                    if (typeof (value) != 'undefined') {
                        formData.append(key, value);
                    }
                }
            }
            for (var key in data) {
                set(key, data[key]);
            }
            return formData;
        }

    };
}