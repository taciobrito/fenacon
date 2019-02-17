angular.module('appfenacon')
    .controller('menuController', function ($scope, config) {
        $scope.appurl = config.appurl
    })