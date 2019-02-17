angular.module('appfenacon')
	.service('usuariosAPI', function ($http, config) {
		this.all = function () {
			return $http.get(`${config.apiurl}usuarios`)
		}

		this.find = function (id) {
			return $http.get(`${config.apiurl}usuarios/show/${id}`)
		}

		this.create = function (usuario) {
			return $http.post(`${config.apiurl}usuarios/store`, usuario)
		}

		this.update = function (id, usuario) {
			return $http.post(`${config.apiurl}usuarios/update/${id}`, usuario)
		}

		this.delete = function (id) {
			return $http.post(`${config.apiurl}usuarios/destroy/${id}`)
		}
	})