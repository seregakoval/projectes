module.exports = Header;

Header.$inject = ['Acl'];

function Header(Acl) {
    var vm = this;
    vm.user = Acl.user;

    vm.headerCollapsed = true;
    vm.toggleHeaderCollapse = function () {
        vm.headerCollapsed = !vm.headerCollapsed;
    }
    vm.hideHeader = function () {
        vm.headerCollapsed = true;
    }
}
