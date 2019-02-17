angular.module('appfenacon')
	.service('feriasAPI', function ($http, config) {
		this.all = function () {
			return $http.get(`${config.apiurl}ferias`)
		}

		this.find = function (id) {
			return $http.get(`${config.apiurl}ferias/show/${id}`)
		}

		this.create = function (ferias) {
			return $http.post(`${config.apiurl}ferias/store`, ferias)
		}

		this.update = function (id, ferias) {
			return $http.post(`${config.apiurl}ferias/update/${id}`, ferias)
		}

		this.delete = function (id) {
			return $http.post(`${config.apiurl}ferias/destroy/${id}`)
		}
	})