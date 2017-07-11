 <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12">
      <div class="cuadro-login ">
        <h1><?php echo $texto_boton;?> Carrera</h1>
        <div class="clearfix"></div>
          <br>        
          <?php if (isset($mensaje)){ ?>
            <div class="alert alert-error">
              <?php echo $mensaje;?>
            </div>
          <?php } ?>

          <?php 
          if (!$this->session->userdata('id_carrera_en_curso')) {
          ?>
          <div class="form-group">                    
          <a href="<?php echo base_url();?>controlador/nueva_carrera">
            <button type="button" class="btn btn-primary">Crear</button>
          </a>
          </div>
          <?php } ?>
          
          <?php 
          if ($this->session->userdata('id_carrera_en_curso')) { ?>
          <div class="form-group">
            <div class="clearfix"></div>
            <br>
            <a href="<?php echo base_url();?><?php echo $accion;?>">
              <button type="button" class="btn btn-primary"><?php echo $texto_boton;?></button>
            </a>
          </div>
          <?php } ?>
      </div>
      </div>
    </div>
    </div><!-- /.container -->


    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>