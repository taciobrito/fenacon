angular.module('appfenacon')
	.constant('config', {
    apiurl: 'http://localhost/fenacon/api/',
		appurl: 'http://localhost/fenacon/app/',
		options: {
          headers: { 
            // 'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
          // responseType: 'json'
        }
	})