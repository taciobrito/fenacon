angular.module('appfenacon')
	.service('funcionariosAPI', function ($http, config) {
		this.all = function () {
			return $http.get(`${config.apiurl}funcionarios`)
		}

		this.find = function (id) {
			return $http.get(`${config.apiurl}funcionarios/show/${id}`)
		}

		this.create = function (funcionario) {
			return $http.post(`${config.apiurl}funcionarios/store`, funcionario)
		}

		this.update = function (id, funcionario) {
			return $http.post(`${config.apiurl}funcionarios/update/${id}`, funcionario)
		}

		this.delete = function (id) {
			return $http.post(`${config.apiurl}funcionarios/destroy/${id}`)
		}
	})