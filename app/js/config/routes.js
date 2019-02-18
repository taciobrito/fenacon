angular.module('appfenacon')
	.config(function($routeProvider, $locationProvider) {
    	$routeProvider
	 	    .when('/', {
				templateUrl: 'views/home.html',
				controller: 'homeController'
			})
		  	.when('/usuarios', {
			    templateUrl: 'views/usuarios.html',
			    controller: 'usuariosListaController'
		  	})
		  	.when('/usuarios_novo', {
			    templateUrl: 'views/novo_usuario.html',
			    controller: 'usuariosNovoController'
		  	})
		  	.when('/usuarios_edita/:id', {
			    templateUrl: 'views/edita_usuario.html',
			    controller: 'usuariosEditaController'
		  	})
		  	.when('/funcionarios', {
			    templateUrl: 'views/funcionarios.html',
			    controller: 'funcionariosListaController'
		  	})
		  	.when('/funcionarios_novo', {
			    templateUrl: 'views/novo_funcionario.html',
			    controller: 'funcionariosNovoController',
		  	})
		  	.when('/funcionarios_edita/:id', {
			    templateUrl: 'views/edita_funcionario.html',
			    controller: 'funcionariosEditaController'
		  	})
		  	.when('/ferias_a_tirar', {
			    templateUrl: 'views/ferias_a_tirar.html',
			    controller: 'feriasATirarController'
		  	})
		  	.when('/ferias_tiradas', {
			    templateUrl: 'views/ferias_tiradas.html',
			    controller: 'feriasTiradasController'
		  	})
		  	.when('/ferias_novo/:funcionario_id/:periodo', {
			    templateUrl: 'views/novo_ferias.html',
			    controller: 'feriasNovoController',
		  	})
		  	.when('/ferias_edita/:id', {
			    templateUrl: 'views/edita_ferias.html',
			    controller: 'feriasEditaController'
		  	})
	        .otherwise({
	        	templateUrl: 'views/404.html',
	        });

	        // habilitar o uso da API HTML5 History
      		$locationProvider.html5Mode(true);
	})