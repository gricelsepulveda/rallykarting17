<?php
    $url='https://api.bsale.cl/v1/clients.json';
    //$access_token='e5cbe67f94257c6b815580e4266010d28d2ca1fe';
    $sede = $_POST['sede'];
    $datos = json_decode($_POST['datos'],true);

    if($sede != '')
    {
        $datos['ciudad'] = $sede;
    }
    
    if($datos['ciudad'] == 'Antofagasta' || $datos['ciudad'] == 'La Serena' || $datos['ciudad'] == 'Curico')
    {
        //$access_token='7abea8735796ec8146fb203464561569a3a4f756';
        $access_token='f2233ead4c68c0b7a52dff3cc1db8dea33567ac6';
    }
    if ($datos['ciudad'] == 'Santiago Oeste') {

        $access_token='1221968b2b226a48738303e70c2ffccec81e25fe';
    }
    if ($datos['ciudad'] == 'Barnechea' || $datos['ciudad'] == 'Calama' || $datos['ciudad'] == 'Viña del Mar' || $datos['ciudad'] == 'Santiago Sur' || $datos['ciudad'] == 'Concepción' || $datos['ciudad'] == 'Pto. Montt' || $datos['ciudad'] == 'La Florida'){

        

        $access_token='f9c3201164928a11fcec6efd45f85be8c3d720d7';
    }
    // token demo $access_token='e5cbe67f94257c6b815580e4266010d28d2ca1fe';
    
    $estructura_json = array(
        "facebook"=> "".$datos['direccion']."",
        "municipality" => "".$datos['municipalidad']."",
        "phone"=> "".$datos['telefono']."",
        "activity"=> "Sin datos",
        "city"=> "".$datos['ciudad']."",
        "maxCredit"=> 0,
        "hasCredit"=> 0,
        "lastName"=> "".$datos['last_name']."",
        "note"=> "Sin datos",
        "firstName"=> "".$datos['first_name']."",
        "company"=> "Sin datos",
        "address"=> "".$datos['link']."",
        "email"=> "".$datos['email']."",
        "twitter"=> "".$datos['twitter']."",
        "code"=> "".strtotime('now').""
    );
/*
    {
  "facebook": "",
  "municipality": "Las Condes",
  "phone": "66287196",
  "activity": "Venta de ropa",
  "city": "Santiago",
  "maxCredit": 100000,
  "hasCredit": 1,
  "lastName": "Muñoz",
  "note": "Cliente premiun",
  "firstName": "Marcela",
  "company": "Particular",
  "address": "Los trigales 372",
  "email": "mmunoz@.email.cl",
  "twitter": "",
  "code": "2-7"
}*/
   
    // Parsea a JSON
    $data =  json_encode( $estructura_json );

    // Inicia cURL
    $session = curl_init($url);


    // Indica a cURL que retorne data
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

    // Activa SSL
    @curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, true);

    // Configura cabeceras
    $headers = array(
        'access_token: ' . $access_token,
        'Accept: application/json',
        'Content-Type: application/json'
    );
    curl_setopt($session, CURLOPT_HTTPHEADER, $headers);

    // Indica que se va ser una petición POST
    curl_setopt($session, CURLOPT_POST, true);

    // Agrega parámetros
    curl_setopt($session, CURLOPT_POSTFIELDS, $data);

    // Ejecuta cURL
    $response = curl_exec($session);
    $code = curl_getinfo($session, CURLINFO_HTTP_CODE);

    // Cierra la sesión cURL
    curl_close($session);
    
    /*$fecha = strtotime('now');
    var_dump($access_token);
    die();*/
    //Esto es sólo para poder visualizar lo que se está retornando
    //print_r($response);
    print_r("Registro completado con exito, recibira un correo con los datos ingresados!");


    // **********************************CORREO******************************
    $sPara = $datos['email'];
    //$sPara = "jumatamala@gmail.com";
    //$scopia= "p@rallykarting.cl";
    //$scopia2= "rallykartingsantiago@rallykarting.cl";

    $bHayFicheros = 0;
        $sCabeceraTexto = "";
        $sAdjuntos = "";
        $sCuerpo = $sTexto;
        $sSeparador = uniqid("_Separador-de-datos_");
        $sAsunto = "Registro con exito";
        $sCabeceras = "MIME-version: 1.0\n";
        //$sCabeceras .= "Cc: ".$scopia." \r\n";
        //$sCabeceras .= "Bcc: ".$scopia2." \r\n";

        // Recogemos los campos del formulario 
        foreach ($datos as $sNombre => $sValor)
            $sCuerpo = $sCuerpo."\n".$sNombre." = ".$sValor;
 
        // Recorremos los Ficheros 
        foreach ($_FILES as $vAdjunto)
        {
 
            if ($bHayFicheros == 0)
            {
 
                // Hay ficheros 
 
                $bHayFicheros = 1;
 
                // Cabeceras generales del mail 
                $sCabeceras .= "Content-type: multipart/mixed;";
                $sCabeceras .= "boundary=\"".$sSeparador."\"\n";
 
                // Cabeceras del texto 
                $sCabeceraTexto = "--".$sSeparador."\n";
                $sCabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1\n";
                $sCabeceraTexto .= "Content-transfer-encoding: 7BIT\n\n";
 
                $sCuerpo = $sCabeceraTexto.$sCuerpo;
 
            }
 
            // Se añade el fichero 
            if ($vAdjunto["size"] > 0)
            {
                $sAdjuntos .= "\n\n--".$sSeparador."\n";
                $sAdjuntos .= "Content-type: ".$vAdjunto["type"].";name=\"".$vAdjunto["name"]."\"\n";
                $sAdjuntos .= "Content-Transfer-Encoding: BASE64\n";
                $sAdjuntos .= "Content-disposition: attachment;filename=\"".$vAdjunto["name"]."\"\n\n";
 
                $oFichero = fopen($vAdjunto["tmp_name"], 'rb');
                $sContenido = fread($oFichero, filesize($vAdjunto["tmp_name"]));
                $sAdjuntos .= chunk_split(base64_encode($sContenido));
                fclose($oFichero);
            }
 
        }
 
        // Si hay ficheros se añaden al cuerpo 
        if ($bHayFicheros)
            $sCuerpo .= $sAdjuntos."\n\n--".$sSeparador."--\n";
 
        // Se añade la cabecera de destinatario
        $sDe = "rallykartingsantiago@rallykarting.cl";
        if ($sDe)$sCabeceras .= "From:".$sDe."\n";
 
        // Por último se envia el mail 
        return(mail($sPara, $sAsunto, $sCuerpo, $sCabeceras));


?>