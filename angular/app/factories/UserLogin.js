module.exports = UserLogin;

UserLogin.$inject = ['Acl', 'User', '$q'];

function UserLogin(Acl, User, $q) {
    var setUser = function () {
        var deferred = $q.defer();
        User.current({}, function (data) {
            var user = data.toJSON();
            Acl.login(data.group || 'user', user);//to do: check roles
            deferred.resolve(data);
        }, function (data) {
            deferred.reject(data);
        })
        return deferred.promise;
    }
    return {
        setUser: function () {
            return setUser();
        },
    };
}
