angular.module('appfenacon')
	.filter('name', function() {
		return function (input) {
			var listaDeNomes = input.split(' ')
			var listaFormatada = listaDeNomes.map(function(nome){
				return nome.charAt(0).toUpperCase() + nome.substring(1).toLowerCase()
			})
			return listaFormatada.join(' ')
		}
	})