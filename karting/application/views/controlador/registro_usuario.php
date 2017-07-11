 <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2">
      <div class="cuadro-registro ">
        <h1>Datos Piloto</h1>
        <div class="clearfix"></div>
          <br>
        <form method="POST" action="<?php echo base_url();?>controlador/registro_usuario" id="frmLogin">
          <?php if (isset($mensaje)){ ?>
            <div class="alert alert-error">
              <?php echo $mensaje;?>
            </div>
          <?php } ?>
          <div class="form-group">
          <label for="nombre" required class="col-md-2 col-xs-2 control-label">Nombre</label>
          <div class="col-md-10 col-xs-10">
            <input type="text" required class="form-control" name="nombre"
                   placeholder="Ej: Pablo Jara">
          </div>
          <div class="clearfix"></div>
          <br>

          <div class="form-group">
          <label for="rut" required class="col-md-2 col-xs-2 control-label">Rut</label>
          <div class="col-md-10 col-xs-10">
            <input type="text" required class="form-control" name="rut"
                   placeholder="Ej: 12.345.678-9">
          </div>
          <div class="clearfix"></div>
          <br>

          <div class="form-group">
          <label for="correo" required class="col-md-2 col-xs-2 control-label">Email</label>
          <div class="col-md-10 col-xs-10">
            <input type="email" required class="form-control" name="correo"
                   placeholder="Ej: nombre@rallykarting.cl">
          </div>
          <div class="clearfix"></div>
          <br>

          <div class="form-group">
          <label for="telefono" required class="col-md-2 col-xs-2 control-label">Teléfono</label>
          <div class="col-md-10 col-xs-10">
            <input type="text" class="form-control" name="telefono"
                   placeholder="Ej: 987654321">
          </div>
          <div class="clearfix"></div>
          <br>

          <div class="form-group">
            <textarea class="condiciones"><?php echo traer_config('Terminos'); ?></textarea>          
          <div class="clearfix"></div>
          <br>
          
          <div class="form-group acepto">
            <input type="checkbox" name="acepto" id="acepto"> Acepto los términos.
          </div>          
          
          <div class="clearfix"></div>
          <br><br>
          <button type="Submit" class="btn btn-primary" id="btn-enviar" disabled>Enviar</button>
          <a href="<?php echo base_url();?>controlador/ingreso_participante">
            <button type="button" class="btn btn-primary3">Volver</button>
          </a>
          
          </form>
      </div>
      </div>
    </div>
    </div><!-- /.container -->


    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>

    <script>
      
        $("#acepto").click(function(){
          var checked_status = this.checked;
          console.log(checked_status);
          if (checked_status == true) {
             $("#btn-enviar").prop("disabled",false);
          } else {
             $("#btn-enviar").prop("disabled",true);
          }
        })

      
    </script>
    
  </body>
</html>