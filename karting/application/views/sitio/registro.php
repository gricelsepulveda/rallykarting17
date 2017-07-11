<div class="login-usuario">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
                <div class="cuadro-login">
				        <br>
                        <img src="<?php echo base_url();?>assets/img/icon-user.png" alt="">
                        <br><br>
                        <strong>Actualizar datos</strong><br>

                        <?php echo validation_errors('<p class="error">','</p>'); ?>

                        <br>

                        <?php echo form_open('inicio/registro/'); ?>
					   
                            Nombre: <br>
                            <input type="text" name="nombre" id="nombre" placeholder="Ej: Pablo Jara" value="<?php echo set_value('nombre') ?>"><br><br>
                            
                            Correo: <br>
                            <input type="text" name="email" id="email" placeholder="Ej: nombre@rallykarting.cl" value="<?php echo set_value('email') ?>"><br><br>
                            
                            Tel&eacute;fono: <br><input type="text" name="telefono" id="telefono" placeholder="Ej: 987654321" value="<?php echo set_value('telefono') ?>"><br><br>

                            <textarea readonly="true" style="width: 250px;height: 120px;"><?php echo ($terminos && !empty($terminos->valor)) ? $terminos->valor : ''; ?></textarea><br>

                            <label><input type="checkbox" id="tyc" name="tyc" onclick="aceptarTerminos()" />Acepto los t&eacute;rminos y condiciones.</label>

                            <input type="hidden" name="idUsuarioRK" id="idUsuarioRK" value="<?php echo $idUsuarioRK; ?>" />

                            <div class="clearfix"></div>
                            
                            <br>

                            <button class="btn btn-amarillo" id="boton_registro" disabled="true">Listo</button>
                            
                            <div class="clearfix"></div>
                            
                            <br>

                        <?php echo form_close(); ?>
					   
				    <!--
                            <br>
                            <img src="<?php echo base_url();?>assets/img/icon-user.png" alt="">
                            <br><br>
                            <strong>Ingreso</strong>
                            <?php if (isset($mensaje)) { ?>
                                <p class="error"><?php echo $mensaje; ?></p>
                            <?php } ?>
                            <br>

                            <?php echo form_open('inicio/login'); ?>
                                <input type="text" name="rut" id="rut" placeholder="Rut, sin puntos ni guión"><br>

                                <div class="clearfix"></div>
                                <br>

                                <button class="btn btn-amarillo">Listo</button>
                                <div class="clearfix"></div>
                                <br>

                            <?php echo form_close(); ?>
					   
					   -->
					   
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
	   
	   <script>
	   function aceptarTerminos(){
		$("#boton_registro").prop( "disabled", !tyc.checked  );
	   }
	   </script>
    </body>
</html>