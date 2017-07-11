<?php
	
	$name = $_POST['datos'][0];
	$contacto = $_POST['datos'][1];
	$telefono = $_POST['datos'][2];
	$mensaje = $_POST['datos'][3];
  $asunto = $_POST['datos'][4];
  $sede = $_POST['datos'][5];

  switch ($sede) {
    case 1:
        $correo =  "e@rallykarting.cl";
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
if ($name == "" || $contacto == "" || $telefono == "" || $mensaje == "" || $sede == "") {
  echo "Complete los campos antes de enviar su formulario de contacto ";
}else
{
  if ($asunto == "sugerencias o reclamos" || $asunto == "contacto comercial")
  {
    
    $email_from = "rallykartinsantiagog@rallykarting.cl";
    $email_message .= "Contacto: ".$name."<br>"; 
    $email_message .= "Telefono: ".$telefono."<br>";
    $email_message .= "Email: ".$contacto."<br>";
    $email_message .= "Mensaje: ".$mensaje."<br>";
    $email_to = $correo;
    $email_subject = $asunto;
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    //dirección del remitente 
    $headers .= "From: RallyKarting Web < ".$email_to." >\r\n";
    $headers .= "Cc: ".$email_to2." \r\n";
    $bool = mail($email_to, $email_subject, $email_message, $headers);
    if($bool){
      echo "Su mensaje ha sido enviado exitosamente";
    }else{
      echo "Ha fallado el envío, porfavor inténtelo nuevamente";
    }
  }
  else
  {
    $email_from = "rallykartinsantiagog@rallykarting.cl";        
    $email_message .= "Contacto: ".$name."<br>"; 
    $email_message .= "Telefono: ".$telefono."<br>";
    $email_message .= "Email: ".$contacto."<br>";
    $email_message .= "Mensaje: ".$mensaje."<br>";
    $email_to = $correo;
    $email_subject = $asunto;
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
    //dirección del remitente 
    $headers .= "From: RallyKarting Web < ".$email_to2." >\r\n"; 
    $bool = mail($email_to, $email_subject, $email_message, $headers);
    if($bool){
    echo "Su mensaje ha sido enviado exitosamente";
    }else{
    echo "Ha fallado el envío, porfavor inténtelo nuevamente";
    }
  }
}
  



?>