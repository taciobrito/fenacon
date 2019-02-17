angular.module('appfenacon').controller('listaController', function ($scope, contatosAPI, usuariosAPI) {
    $scope.app = 'Lista telefônica'

    $scope.contatos = []

    $scope.operadoras = [
        {nome: 'Oi', codigo: 14, categoria: 'Celular', preco: 2},
        {nome: 'Vivo', codigo: 15, categoria: 'Celular', preco: 3},
        {nome: 'Tim', codigo: 41, categoria: 'Celular', preco: 5},
        {nome: 'GVT', codigo: 25, categoria: 'Fixo', preco: 1},
        {nome: 'Embratel', codigo: 21, categoria: 'Fixo', preco: 3.5},
    ]

    var carregarContatos = function () {
        contatosAPI.getContatos()
            .then((res, status) => {
                $scope.contatos = res.data.result
            })
    }
    $scope.adicionarContato = function (contato) {
        $scope.contatos.push(contato)
        delete $scope.contato
        $scope.contatoForm.$setPristine()
    }
    $scope.apagarContatos = function(contatos) {
        $scope.contatos = contatos.filter((contato) => {
            if (!contato.selecionado) return contato
        })
    }
    $scope.ordernarPor = function (campo) {
        $scope.criterioDeOrdenacao = campo
        $scope.direcaoDaOrdenacao = !$scope.direcaoDaOrdenacao
    }
    carregarContatos()
})