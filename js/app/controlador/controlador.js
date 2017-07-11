app.controller('controlador', ['$scope', 'inicio' ,'$http', function ($scope, upload, $http,  $location) 
    {
        $scope.slidertab = 2;
        $scope.selectTab = function(slidertab){
            $scope.slidertab = slidertab;
            switch($scope.slidertab){
                case 1:
                descripcion = "Sede Concepción Centro";
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
                descripcion = "Sede Concepción Trebol";
                break;

                case 8:
                descripcion = "Sede Pto. Montt";
                break;

                case 9:
                descripcion = "Sede Barnechea";
                break;

                case 10:
                descripcion = "Sede La Florida";
                break;

                case 11:
                descripcion = "Sede Curicó";
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
               alert(data)
               window.location.href="http://www.rallykarting.cl";
               // $scope.slider = data;// how do pass this to $scope.persons?
            }).error(function (data, status, headers, config) {
                $scope.status = status;
            });
                
            }
        
        $scope.pkar = function(){
     
            footer = [

                $scope.nombre_kar,
                $scope.email_kar,
                $scope.auto_kar,
                $scope.sede_kar,
                $scope.mensaje_kar,

            ]
            console.log(footer)
            $http({
            url: 'pkar.php',
            method: "POST",
            data: $.param({'datos': footer }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data, status, headers, config) {
               alert(data)
               window.location.href="http://www.rallykarting.cl";
               // $scope.slider = data;// how do pass this to $scope.persons?
            }).error(function (data, status, headers, config) {
                $scope.status = status;
            });
        
        }
        $scope.pper = function(){
     
            footer = [

                $scope.nombre_per,
                $scope.email_per,
                $scope.personal_per,
                $scope.sede_per,
                $scope.mensaje_per,

            ]
            console.log(footer)
            $http({
            url: 'pper.php',
            method: "POST",
            data: $.param({'datos': footer }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data, status, headers, config) {
               alert(data)
               window.location.href="http://www.rallykarting.cl";
               // $scope.slider = data;// how do pass this to $scope.persons?
            }).error(function (data, status, headers, config) {
                $scope.status = status;
            });
        
        }
        $scope.trabajos = function()
        {
         
        var tipo = $scope.tipo
        var car = $scope.car
        var disp = $scope.disp
        var sed = $scope.sed
        var nom = $scope.nom
        var em = $scope.em
        var ed = $scope.ed
        var tel = $scope.tel
        var cur = $scope.cur
        var tra = $scope.tra
        var mot = $scope.mot
        var file = $scope.file
       

    upload.uploadFile(tipo,car,disp,sed,nom,ed,em,tel,cur,tra,mot,file).then(function(res)
    {
         
    })
    }
    $scope.registrar = function()
    {
        array = {

            "first_name" : ''+$scope.nombre+'',
            "last_name": ''+$scope.apellido+'',
            "ciudad": ''+$scope.ciudad+'',
            "municipalidad": ''+$scope.municipalidad+'',
            "direccion": ''+$scope.direccion+'',
            "telefono": ''+$scope.telefono+'',
            "email": ''+$scope.email+'',
            "link": ''+$scope.facebook+'',
            "twitter": ''+$scope.twitter+'',
        }
        var registro = JSON.stringify(array);
        
        $http({
            url: 'registro.php',
            method: "POST",
            data: $.param({'datos': registro }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data, status, headers, config) {
               alert(data)
               //window.location.href="http://www.rallykarting.cl";
               // $scope.slider = data;// how do pass this to $scope.persons?
            }).error(function (data, status, headers, config) {
                $scope.status = status;
            });

    }

      
        

        
}])
