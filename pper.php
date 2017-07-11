<?php
	
	$name = $_POST['datos'][0];
	$email = $_POST['datos'][1];
	$personal = $_POST['datos'][2];
	$sede = $_POST['datos'][3];
    $mensaje = $_POST['datos'][4];
    $asunto = "Problema con Personal";

  switch ($sede) {
    case 1:
        $correo =  "concepcion@rallykarting.cl";
        break;
    case 2:
        $correo =  "antofagasta@rallykarting.cl";
        break;
    case 3:
        $correo =  "j@rallykarting.cl";
        break;
    case 4:
        $correo =  "a@rallykarting.cl";
        break;
    case 5:
        $correo =  "santiago@rallykarting.cl";
        break;
    case 6:
        $correo =  "oeste@rallykarting.cl";
        break;
    case 7:
        $correo =  "concepcion@rallykarting.cl";
        break;
    case 8:
        $correo =  "b@rallykarting.cl";
        break;
}
$email_to2 = "r@rallykarting.cl";
$email_to3 = "p@rallykarting.cl";
if ($name == "" || $email == "" || $personal == "" || $mensaje == "" || $sede == "") {
  echo "Complete los campos antes de enviar su formulario de contacto ";
}else
{
  if ($asunto == "Problema con Personal")
  {
    
    $email_from = "rallykartinsantiagog@rallykarting.cl";
    $email_message .= "Contacto: ".$name."<br>"; 
    $email_message .= "Email o numero de contacto: ".$email."<br>";
    $email_message .= "Persona del problema: ".$personal."<br>";
    $email_message .= "Mensaje: ".$mensaje."<br>";
    $email_to = $correo;
    $email_subject = $asunto;
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    //dirección del remitente 
    $headers .= "From: RallyKarting Web < ".$email_to." >\r\n";
    $headers .= "Cc: ".$email_to2." \r\n";
    $headers .= "Bcc: ".$email_to3." \r\n";
    $bool = mail($email_to, $email_subject, $email_message, $headers);
    if($bool){
      echo "Su mensaje ha sido enviado exitosamente";
    }else{
      echo "Ha fallado el envío, porfavor inténtelo nuevamente";
    }
  }
}
  



?>