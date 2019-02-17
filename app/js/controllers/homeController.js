angular.module('appfenacon')
    .controller('homeController', function ($scope, config) {
        $scope.titulo = 'APP Fenacon'

        $scope.appurl = config.appurl
    })