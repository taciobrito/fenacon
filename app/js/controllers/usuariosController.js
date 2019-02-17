angular.module('appfenacon')
    .controller('usuariosController', function ($scope, $location, usuariosAPI, config) {
        $scope.appurl = config.appurl

        $scope.usuarios = []

        var getUsuarios = function () {
            usuariosAPI.all()
                .then((res) => {
                    $scope.usuarios = res.data.result
                })
                .catch((error) => {
                    console.log(error.response)
                    $scope.error = 'Não foi possível carregar os dados'
                })
        }

        $scope.addUsuario = function (usuario) {
            usuariosAPI.create(usuario)
                .then((res, status) => {
                    console.log(res)
                    if (status == 201) {
                        delete $scope.usuario
                        $scope.usuarioForm.$setPristine()
                        getUsuarios();
                        $scope.success = res.data.message
                        $location.path('/usuarios')
                    }
                })
                .catch((error) => {
                    console.log(error)
                    $scope.error = 'Não foi possível salvar o registro'
                })
        }

        // $scope.apagarUsuarios = function(usuarios) {
        //     $scope.usuarios = usuarios.filter((usuario) => {
        //         if (!usuario.selecionado) return usuario
        //     })
        // }

        $scope.ordernarPor = function (campo) {
            $scope.criterioDeOrdenacao = campo
            $scope.direcaoDaOrdenacao = !$scope.direcaoDaOrdenacao
        }

        getUsuarios()
    })