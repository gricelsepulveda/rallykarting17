 <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2">
      <div class="cuadro-login ">
        <h1>Nueva Carrera</h1>
        <div class="clearfix"></div>
          <br>        
          <?php if (isset($mensaje)){ ?>
            <div class="alert alert-error">
              <?php echo $mensaje;?>
            </div>
          <?php } ?>

          <div class="form-group ">                    
          		<label for="numero">N° : <?php echo $carrera->id_carrera;?></label>
          		<div class="clearfix"></div>
          		<label for="numero">Fecha/Hora:  <?php echo mysql_to_date_complete($carrera->fecha); ?></label>
          		<div class="clearfix"></div>
          </div>
          
        

      </div>
      </div>
    </div>
    </div><!-- /.container -->

    <div class="clearfix"></div>
	    <br>
	    <br>    
	    <footer class="footer">	      	
        	<a href="<?php echo base_url();?>controlador/ingreso_participante">
        		<button type="submit" class="btn btn-asignacion" style="width:100%;">Aceptar</button>
	        </a>
	    </footer>


    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>