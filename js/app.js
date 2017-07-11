    var app = angular.module('app', [
    'ngRoute',
  
    ]);

    app.config(['$routeProvider', '$httpProvider', function($routeProvider , $httpProvider){
        $routeProvider
        .when('/',{
            templateUrl:'angular_pages/santiago.php',
            controller:'controlador',
        })
         .when('/santiago',{
            templateUrl:'angular_pages/santiago.php',
            controller:'controlador',
        })
        .when('/santiagooeste',{
            templateUrl:'angular_pages/santiago_oeste.php',
            controller:'controlador',
        })
         .when('/antofagasta',{
            templateUrl:'angular_pages/antofagasta.php',
            controller:'controlador',
        })
        .when('/calama',{
            templateUrl:'angular_pages/calama.php',
            controller:'controlador',
        })
         .when('/la_serena',{
            templateUrl:'angular_pages/la_serena.php',
            controller:'controlador',
        })
         .when('/vina_del_mar',{
            templateUrl:'angular_pages/vina_del_mar.php',
            controller:'controlador',
        })
         .when('/concepcion',{
            templateUrl:'angular_pages/concepcion.php',
            controller:'controlador',
        })
         .when('/pto_montt',{
            templateUrl:'angular_pages/pto_montt.php',
            controller:'controlador',
        })
       
        $httpProvider.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
    }])
    app.controller('tabController', function(){
        this.selectTab = function(tab){
            this.tab = tab;
        };
    });

   app.controller('capsule',function($scope,$http,$location) {
        
         $scope.persons = $http({
            url: '../arbifup/administracion/ajax',
            method: "POST",
             dataType: 'jsonp',
            data: $.param({'case':1}),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        }).success(function (data, status, headers, config) {
                $scope.data = data;// how do pass this to $scope.persons?
            }).error(function (data, status, headers, config) {
                $scope.status = status;
            });
    });
