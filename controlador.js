app.controller('controlador', ['$scope', '$http', function ($scope, $http,  $location) 
    {
        $scope.slidertab = 1;
        $scope.selectTab = function(slidertab){
            $scope.slidertab = slidertab;
            switch($scope.slidertab){
                case 1:
                descripcion = "Sede Calama";
                break;
 
                case 2:
                descripcion = "Sede Antofagasta";
                break;

                case 3:
                descripcion = "Sede La Serena";
                break;

                case 4:
                descripcion = "Sede Viña del Mar";
                break;

                case 5:
                descripcion = "Sede Santiago Sur";
                break;

                case 6:
                descripcion = "Sede Santiago Oeste";
                break;

                case 7:
                descripcion = "Sede Concepción";
                break;

                case 8:
                descripcion = "Sede Pto. Montt";
                break;
                }
        $('#asede').html(descripcion);
        };
        $scope.enviar = function(){

            if($('#sugerencias_reclamos').hasClass('activo')){
              
              $scope.asunto = "sugerencias o reclamos"
            }
             if($('#cotizar_campeonato').hasClass('activo')){
             
              $scope.asunto = "cotizar campeonato"
            }
             if($('#contacto_comercial').hasClass('activo')){
              
              $scope.asunto = "contacto comercial"
            }

            footer = [

                $scope.nombre,
                $scope.mail,
                $scope.telefono,
                $scope.mensaje,
                $scope.asunto,
                $scope.sede

            ]
        
            $http({
            url: 'correo.php',
            method: "POST",
            data: $.param({'datos': footer }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data, status, headers, config) {
              
               // $scope.slider = data;// how do pass this to $scope.persons?
            }).error(function (data, status, headers, config) {
                $scope.status = status;
            });
        
        }
        
}])
