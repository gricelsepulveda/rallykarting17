  <div class="login-usuario">
        
        <div class="container">
          <div class="row">
            <div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
            <div class="cuadro-login">
                <br>
                <img src="<?php echo base_url();?>assets/img/icon-user.png" alt="">
                <br><br>
                <strong>Recuperación de Clave</strong>
                <?php if (isset($mensaje)) { ?>
                <p class="error"><?php echo $mensaje; ?></p>
                <?php } ?>
                <br>
                <form action="" method="POST">
                  <p>Ingrese su RUT y le enviarmos <br> una nueva clave de ingreso.</p>
                  <input type="text" name="rut" placeholder="Rut"><br>                  
                  <div class="clearfix"></div>
                  <br>
                  <strong><a href="<?php echo base_url();?>">Volver</a></strong>
                  <div class="clearfix"></div>
                  <br>    
                  <button class="btn btn-amarillo">Listo</button>
                  <div class="clearfix"></div>
                  <br>
                </form>

            </div>
            </div>
          </div>
        </div>

  </div>
  <div class="firma">
    <p>by youtouch</p>
  </div>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>