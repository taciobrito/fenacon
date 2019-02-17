angular.module('appfenacon')
	.config(function($routeProvider, $locationProvider) {
    	$routeProvider
	 	    .when('/', {
				templateUrl: 'views/home.html',
				controller: 'homeController'
			})
		  	.when('/usuarios', {
			    templateUrl: 'views/usuarios.html',
			    controller: 'usuariosController'
		  	})
		  	.when('/usuarios_novo', {
			    templateUrl: 'views/novo_usuario.html',
			    controller: 'usuariosController'
		  	})
		  	// .when('/funcionarios', {
			  //   templateUrl: 'views/funcionarios.html',
			  //   controller: 'funcionariosController'
		  	// })
		  	// .when('/ferias', {
			  //   templateUrl: 'views/ferias.html',
			  //   controller: 'feriasController'
		  	// })
	        .otherwise({
	        	templateUrl: 'views/404.html',
	        });

	        // habilitar o uso da API HTML5 History
      		$locationProvider.html5Mode(true);
	})