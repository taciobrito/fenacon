angular.module('appfenacon')
	.service('externalAPI', function ($http) {
		this.getAdressByCep = function (cep) {
			return $http.get(`https://viacep.com.br/ws/${cep}/json/`)
		}
	})