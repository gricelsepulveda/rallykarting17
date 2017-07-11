 <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12">
      <div class="cuadro-login ">
        <h1>Usuario registrado</h1>
        <div class="clearfix"></div>
          <br>
        <form method="POST" action="<?php echo base_url();?>controlador/ingreso_participante" id="frmLogin">
          <?php if (isset($mensaje)){ ?>
            <div class="alert alert-error">
              <?php echo $mensaje;?>
            </div>
          <?php } ?>
          <div class="form-group">
          <label for="correo" class="col-md-2 col-xs-2 control-label">Rut</label>
          <div class="col-md-10 col-xs-10">
            <input type="text" class="form-control" name="rut"
                   placeholder="Ej: 12.345.678-9">
          </div>           
          
          <div class="clearfix"></div>
          <br><br>
          <button type="Submit" class="btn btn-primary">Enviar</button>
          
          </form>
          <div class="clearfix"></div>
          <br>
          <a href="<?php echo base_url();?>controlador/asignacion">
            <button type="button" class="btn btn-primary">Ver Asignaciones</button>
          </a>
          <!--<a href="<?php //echo base_url();?>controlador/registro_usuario">
            <button type="button" class="btn btn-primary2">Nuevo Usuario</button>
          </a>-->
      </div>
      </div>
    </div>
    </div><!-- /.container -->


    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>