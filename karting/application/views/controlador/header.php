

<!DOCTYPE html>

<html lang="es">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="http://www.rallykarting.cl/wp-content/uploads/2015/10/logo.png">

    <base href="<?php echo base_url();?>assets/">

    <title>Controlador</title>



    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/controlador.css" rel="stylesheet">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

  </head>



  <body>



    <nav class="navbar navbar-inverse navbar-fixed-top">

      <div class="container">

        <div class="navbar-header">

          <img src="img/logo.png" class="logo img-responsive">

        </div>

        <?php if ($this->session->userdata('logged_controlador_in')) { ?>

              <a href="<?php echo base_url();?>controlador/desconectar">

                <button class="btn btn-header">Desconectar</button>

              </a>

        <?php } ?>  

      </div>

    </nav>

