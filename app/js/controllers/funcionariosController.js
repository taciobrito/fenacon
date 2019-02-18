angular.module('appfenacon')
    .controller('funcionariosListaController', function ($scope, funcionariosAPI, SimplePaginate) {
        $scope.funcionarios = []

        var getFuncionarios = function () {
            funcionariosAPI.all()
                .then((res) => {
                    SimplePaginate.configure({
                        data: res.data.result,
                        perPage: 10
                    })

                    $scope.paginateFuncionarios = {
                        result: SimplePaginate.goToPage(0),
                        total: SimplePaginate.itemsTotal(),
                        totalPages: SimplePaginate.pagesTotal(),
                        next: function() {
                            $scope.paginateFuncionarios.result = SimplePaginate.next()
                        },
                        prev: function() {
                            $scope.paginateFuncionarios.result = SimplePaginate.prev()
                        },
                        goToPage: function(page) {
                            $scope.paginateFuncionarios.result = SimplePaginate.goToPage(page)
                        }
                    }

                    // $scope.funcionarios = res.data.result
                })
                .catch((error) => {
                    console.log(error.response)
                    $scope.error = 'Não foi possível carregar os dados'
                })
        }

        $scope.removeFuncionario = function (id) {
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
                    funcionariosAPI.delete(id)
                        .then((res) => {
                            if (res.status == 200) {
                                $scope.success = res.data.message
                                getFuncionarios()
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
        
        getFuncionarios()
    })

    .controller('funcionariosNovoController', function($scope, $location, funcionariosAPI, externalAPI) {
        $scope.addFuncionario = function (funcionario) {
            funcionariosAPI.create(funcionario)
                .then((res) => {
                    if (res.status == 201) {
                        delete $scope.funcionario
                        $scope.funcionarioForm.$setPristine()
                        swal({
                            type: 'success',
                            title: 'Sucesso!',
                            text: res.data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        $location.path('/funcionarios')
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

        $scope.getCep = function (cep) {
            externalAPI.getAdressByCep(cep)
                .then((res) => {
                    console.log(res)
                    $scope.funcionario.endereco = res.data
                })
                .catch((error) => console.log(error))
        }

        $scope.supervisorCargo = function (cargo_id) {
            if (cargo_id != '') {
                $scope.supervisores = $scope.supervisoresBackup.filter((supervisor) => {
                    if (cargo_id == 1 || cargo_id == 2) {
                        if (supervisor.cargo_id == 3)
                            return supervisor
                    } else if (cargo_id == 3) {
                        if (supervisor.cargo_id == 4)
                            return supervisor
                    }
                })
            } else {
                $scope.supervisores = $scope.supervisoresBackup
            }
        }

        funcionariosAPI.getCargos()
            .then((res) => {
                $scope.cargos = res.data.result
            })

        funcionariosAPI.getSituacoes()
            .then((res) => {
                $scope.situacoes = res.data.result
            })

        funcionariosAPI.all()
            .then((res) => {
                $scope.supervisores = res.data.result
                $scope.supervisoresBackup = res.data.result
            })
    })

    .controller('funcionariosEditaController', function ($scope, $routeParams, $location, funcionariosAPI, externalAPI) {
        var getFuncionario = function () {
            funcionariosAPI.find($routeParams.id)
                .then((res) => {
                    // res.data.result.endereco = JSON.parse(res.data.result.endereco)
                    $scope.funcionario = res.data.result
                })
                .catch((error) => {
                    console.log(error)
                })
        }

        $scope.editFuncionario = function (funcionario) {
            funcionariosAPI.update(funcionario.id, funcionario)
                .then((res) => {
                    if (res.status == 200) {
                        delete $scope.funcionario
                        $scope.funcionarioForm.$setPristine()
                        swal({
                            type: 'success',
                            title: 'Sucesso!',
                            text: res.data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        $location.path('/funcionarios')
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

        $scope.getCep = function (cep) {
            externalAPI.getAdressByCep(cep)
                .then((res) => {
                    console.log(res)
                    $scope.funcionario.endereco = res.data
                })
                .catch((error) => console.log(error))
        }

        $scope.supervisorCargo = function (cargo_id) {
            if (cargo_id != '') {
                $scope.supervisores = $scope.supervisoresBackup.filter((supervisor) => {
                    if (cargo_id == 1 || cargo_id == 2) {
                        if (supervisor.cargo_id == 3)
                            return supervisor
                    } else if (cargo_id == 3) {
                        if (supervisor.cargo_id == 4)
                            return supervisor
                    }
                })
            } else {
                $scope.supervisores = $scope.supervisoresBackup
            }
        }

        funcionariosAPI.getCargos()
            .then((res) => {
                $scope.cargos = res.data.result
            })

        funcionariosAPI.getSituacoes()
            .then((res) => {
                $scope.situacoes = res.data.result
            })

        funcionariosAPI.all()
            .then((res) => {
                $scope.supervisores = res.data.result
                $scope.supervisoresBackup = res.data.result
            })

        getFuncionario()
    })