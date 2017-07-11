<?php
    
    $tipo = $_POST["tipo"];
    $cargo = $_POST["cargo"];
    $disponibilidad = $_POST['disponibilidad'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $email = $_POST['email'];
    $tel = $_POST['telefono'];
    $estudio = $_POST['estudio'];
    $trabajos = $_POST['trabajos'];
    $mot = $_POST['motivacion'];
    $sede = $_POST['sede'];

if ($cargo == "Promotora" || $cargo == "Cajero" || $cargo == "Pistero" || $cargo == "Mecánico"  ) {
    
        if ($sede == "Calama") {
        $sPara =  "e@rallykarting.cl";
        }
        if ($sede == "Antofagasta") {
            $sPara =  "antofagasta@rallykarting.cl";
        }
        if ($sede == "La Serena") {
            $sPara =  "j@rallykarting.cl";
        }
        if ($sede == "Viña del Mar") {
            $sPara =  "a@rallykarting.cl";
        }
        if ($sede == "Santiago Sur") {
            $sPara =  "santiago@rallykarting.cl";
        }
        if ($sede == "Santiago Oeste") {
            $sPara =  "oeste@rallykarting.cl";
        }
        if ($sede == "Concepción") {
            $sPara =  "concepcion@rallykarting.cl";
        }
        if ($sede == "Pto. Montt") {
            $sPara =  "b@rallykarting.cl";
        }
         if ($sede == "La Florida") {
            $sPara =  "b@rallykarting.cl";
        }
        $scopia = "r@rallykarting.cl";
        $scopia2= "p@rallykarting.cl";

}else
{
    $sPara = "r@rallykarting.cl";
    $scopia= "p@rallykarting.cl";
    $scopia2= "rallykartingsantiago@rallykarting.cl";
}


if ($edad == "" || $nombre == "") {
  echo "Complete los campos antes de enviar su formulario de contacto ";
}else
{
    
    $bHayFicheros = 0;
        $sCabeceraTexto = "";
        $sAdjuntos = "";
        $sCuerpo = $sTexto;
        $sSeparador = uniqid("_Separador-de-datos_");
        $sAsunto = "trabaja con nosotros";
        $sCabeceras = "MIME-version: 1.0\n";
        $sCabeceras .= "Cc: ".$scopia." \r\n";
        $sCabeceras .= "Bcc: ".$scopia2." \r\n";

        // Recogemos los campos del formulario 
        foreach ($_POST as $sNombre => $sValor)
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
    }
 
?>