angular.module('appfenacon')
	.filter('cargo', function() {
		return function (input) {
			var listaFormatada = listaDeNomes.map(function(nome){
				return nome.charAt(0).toUpperCase() + nome.substring(1).toLowerCase()
			})
			return listaFormatada.join(' ')
		}
	})