 <div class="container">
    <div class="row">
      <div class="col-md-12  col-xs-12">
      <div class="cuadro-login ">
        <h1>Acceso controlador</h1>
        <div class="clearfix"></div>
          <br>
        <form method="POST" action="<?php echo base_url();?>controlador/login" id="frmLogin">
          <?php if (isset($mensaje)){ ?>
            <div class="alert alert-error">
              <?php echo $mensaje;?>
            </div>
          <?php } ?>
          <div class="form-group">
          <label for="correo" class="col-md-2 col-xs-2 control-label">Correo</label>
          <div class="col-md-10 col-xs-10">
            <input type="email" required class="form-control" name="correo"
                   placeholder="Ej: nombre@rallykarting.cl">
          </div>
          <div class="clearfix"></div>
          <br>
          <div class="form-group">
          <label for="clave" class="col-md-2 col-xs-2 control-label">Clave</label>
          <div class="col-md-10 col-xs-10">
            <input type="password" required class="form-control" name="clave">
          </div>
          <div class="clearfix"></div>
          <br>
          <div class="form-group">
          <label for="pista" class="col-md-2 col-xs-2 control-label">Pista</label>
          <div class="col-md-10 col-xs-10">
            <select class="form-control" name="pista">
                <?php for ($i=0; $i < sizeof($pistas); $i++) { ?>
                    <option value="<?php echo $pistas[$i]->id_pista;?>" style="color:black">
                        <?php echo $pistas[$i]->nombre; ?>
                    </option>
                <?php } ?>
            </select>
          </div>

          
          <div class="clearfix"></div>
          <br><br>
          <button type="Submit" class="btn btn-primary">Enviar</button>
          
          </form>
      </div>
      </div>
    </div>
    </div><!-- /.container -->


    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>