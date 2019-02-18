angular.module('appfenacon')
    .controller('usuariosListaController', function ($scope, usuariosAPI, SimplePaginate) {
        $scope.usuarios = []

        var getUsuarios = function () {
            usuariosAPI.all()
                .then((res) => {
                    SimplePaginate.configure({
                        data: res.data.result,
                        perPage: 10
                    })

                    $scope.paginateUsuarios = {
                        result: SimplePaginate.goToPage(0),
                        total: SimplePaginate.itemsTotal(),
                        totalPages: SimplePaginate.pagesTotal(),
                        next: function() {
                            $scope.paginateUsuarios.result = SimplePaginate.next()
                        },
                        prev: function() {
                            $scope.paginateUsuarios.result = SimplePaginate.prev()
                        },
                        goToPage: function(page) {
                            $scope.paginateUsuarios.result = SimplePaginate.goToPage(page)
                        }
                    }

                    // $scope.usuarios = res.data.result
                })
                .catch((error) => {
                    console.log(error.response)
                    $scope.error = 'Não foi possível carregar os dados'
                })
        }

        $scope.removeUsuario = function (id) {
            swal({
                title: 'Deseja mesmo excluir?',
                text: 'Não porderá ser desfeito!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Excluir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result) {
                    usuariosAPI.delete(id)
                        .then((res) => {
                            if (res.status == 200) {
                                $scope.success = res.data.message
                                getUsuarios()
                            }
                        })
                        .catch((error) => {
                            console.log(error)
                        })
                }
            }).catch(() => {})
        }

        $scope.ordernarPor = function (campo) {
            $scope.ordenacao = campo
            $scope.direcaoDaOrdenacao = !$scope.direcaoDaOrdenacao
        }

        getUsuarios()
    })

    .controller('usuariosNovoController', function($scope, $location, usuariosAPI) {
        $scope.addUsuario = function (usuario) {
            usuariosAPI.create(usuario)
                .then((res) => {
                    if (res.status == 201) {
                        delete $scope.usuario
                        $scope.usuarioForm.$setPristine()
                        swal({
                            type: 'success',
                            title: 'Sucesso!',
                            text: res.data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        $location.path('/usuarios')
                    }
                })
                .catch((error) => {
                    console.log(error)
                    swal({
                        type: 'warning',
                        title: 'Erro!',
                        text: error.status == -1 ? 'Houve um erro ao tentar adicionar' : error.data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                    });
                })
        }
    })

    .controller('usuariosEditaController', function ($scope, $routeParams, $location, usuariosAPI) {
        var getUsuario = function () {
            usuariosAPI.find($routeParams.id)
                .then((res) => {
                    $scope.usuario = res.data.result
                })
                .catch((error) => {
                    console.log(error)
                })
        }

        $scope.editUsuario = function (usuario) {
            usuariosAPI.update(usuario.id, usuario)
                .then((res) => {
                    if (res.status == 200) {
                        delete $scope.usuario
                        $scope.usuarioForm.$setPristine()
                        swal({
                            type: 'success',
                            title: 'Sucesso!',
                            text: res.data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        $location.path('/usuarios')
                    }
                })
                .catch((error) => {
                    console.log(error)
                    swal({
                        type: 'warning',
                        title: 'Erro!',
                        text: error.data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                    });
                })
        }

        $scope.editSenha = function (id, trocaSenha) {
            usuariosAPI.updatePassword(id, trocaSenha)
                .then((res) => {
                    if (res.status == 200) {
                        $scope.usuarioFormSenha.$setPristine()
                        swal({
                            type: 'success',
                            title: 'Sucesso!',
                            text: res.data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        delete $scope.trocaSenha
                    }
                })
                .catch((error) => {
                    console.log(error)
                    swal({
                        type: 'success',
                        title: 'Erro!',
                        text: error.data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                    });
                })
        }

        getUsuario()
    })