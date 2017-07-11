app.service('inicio', ["$http", "$q", function ($http, $q) 
{
    this.uploadFile = function(tipo,car,disp,sed,nom,ed,em,tel,cur,tra,mot,file)
    {

        var deferred = $q.defer();
        var formData = new FormData();

        formData.append("tipo", tipo);
        formData.append("cargo", car);
        formData.append("disponibilidad", disp);
        formData.append("sede", sed);
        formData.append("nombre", nom);
        formData.append("edad", ed);
        formData.append("email", em);
        formData.append("telefono", tel);
        formData.append("curso", cur);
        formData.append("trabajos", tra);
        formData.append("motivacion", mot);
        formData.append("file", file);

        return $http.post("trabajos.php", formData, {
            headers: {
                "Content-type": undefined
            },
            transformRequest: angular.identity
        })
        .success(function(res)
        {
            deferred.resolve(res);
        })
        .error(function(msg, code)
        {
            deferred.reject(msg);
        })
        return deferred.promise;
    }     
}]);