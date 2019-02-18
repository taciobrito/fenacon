angular.module('appfenacon')
    .controller('feriasATirarController', function ($scope, feriasAPI, SimplePaginate) {
        $scope.ferias = []

        var getFerias = function () {
            feriasAPI.all('aTirar')
                .then((res) => {
                    console.log(res)
                    SimplePaginate.configure({
                        data: res.data.result,
                        perPage: 10
                    })

                    $scope.paginateFeriasATirar = {
                        result: SimplePaginate.goToPage(0),
                        total: SimplePaginate.itemsTotal(),
                        totalPages: SimplePaginate.pagesTotal(),
                        next: function() {
                            $scope.paginateFeriasATirar.result = SimplePaginate.next()
                        },
                        prev: function() {
                            $scope.paginateFeriasATirar.result = SimplePaginate.prev()
                        },
                        goToPage: function(page) {
                            $scope.paginateFeriasATirar.result = SimplePaginate.goToPage(page)
                        }
                    }

                    // $scope.ferias = res.data.result
                })
                .catch((error) => {
                    console.log(error.response)
                    $scope.error = 'Não foi possível carregar os dados'
                })
        }

        $scope.ordernarPor = function (campo) {
            $scope.ordenacao = campo
            $scope.direcaoDaOrdenacao = !$scope.direcaoDaOrdenacao
        }

        getFerias()
    })

    .controller('feriasTiradasController', function ($scope, feriasAPI, SimplePaginate) {
        $scope.ferias = []

        var getFerias = function () {
            feriasAPI.all('tiradas')
                .then((res) => {
                    SimplePaginate.configure({
                        data: res.data.result,
                        perPage: 10
                    })

                    $scope.paginateFeriasATirar = {
                        result: SimplePaginate.goToPage(0),
                        total: SimplePaginate.itemsTotal(),
                        totalPages: SimplePaginate.pagesTotal(),
                        next: function() {
                            $scope.paginateFeriasATirar.result = SimplePaginate.next()
                        },
                        prev: function() {
                            $scope.paginateFeriasATirar.result = SimplePaginate.prev()
                        },
                        goToPage: function(page) {
                            $scope.paginateFeriasATirar.result = SimplePaginate.goToPage(page)
                        }
                    }

                    // $scope.ferias = res.data.result
                })
                .catch((error) => {
                    console.log(error.response)
                    $scope.error = 'Não foi possível carregar os dados'
                })
        }

        $scope.ordernarPor = function (campo) {
            $scope.ordenacao = campo
            $scope.direcaoDaOrdenacao = !$scope.direcaoDaOrdenacao
        }

        getFerias()
    })

    .controller('feriasNovoController', function($scope, $routeParams, $location, feriasAPI, funcionariosAPI) {
        var getFuncionario = function () {
            funcionariosAPI.find($routeParams.funcionario_id)
                .then((res) => {
                    $scope.funcionario = res.data.result
                })
                .catch((error) => {
                    console.log(error)
                })
        }

        $scope.ferias = $routeParams

        $scope.addFerias = function (ferias) {
            feriasAPI.create(ferias)
                .then((res) => {
                    if (res.status == 201) {
                        delete $scope.ferias
                        $scope.feriasForm.$setPristine()
                        swal({
                            type: 'success',
                            title: 'Sucesso!',
                            text: res.data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        $location.path('/ferias_a_tirar')
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

        getFuncionario()
    })

    .controller('feriasEditaController', function ($scope, $routeParams, $location, feriasAPI) {
        var getFerias = function () {
            feriasAPI.find($routeParams.id)
                .then((res) => {
                    // res.data.result.endereco = JSON.parse(res.data.result.endereco)
                    $scope.ferias = res.data.result
                })
                .catch((error) => {
                    console.log(error)
                })
        }

        $scope.editFerias = function (ferias) {
            feriasAPI.update(ferias.id, ferias)
                .then((res) => {
                    if (res.status == 200) {
                        delete $scope.ferias
                        $scope.feriasForm.$setPristine()
                        swal({
                            type: 'success',
                            title: 'Sucesso!',
                            text: res.data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                        });
                        $location.path('/ferias')
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

        getFerias()
    })