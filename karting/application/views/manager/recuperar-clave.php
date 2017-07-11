
    <div class="dialog">
    <div class="panel panel-default">
        <p class="panel-heading no-collapse">Restaure su Clave</p>
        <div class="panel-body">
            <p>Ingrese su correo electrónico y una nueva clave le sera enviada.</p>
            <form method="POST" action="<?php echo base_url();?>manager/recuperar_clave/" id="frmClave">                
                 <?php if (isset($mensaje)){ ?>
                    <div class="alert alert-error">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                         <?php echo $mensaje;?>
                    </div>                    
                <?php } ?>
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control span12 form-control" required email>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Enviar Clave</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
    <a href="<?php echo base_url();?>manager/" style="font-size: .75em; margin-top: .25em;">Volver al inicio de sesión</a>
    </div>    

    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/custom.js"></script>
  
</body>
</html>
