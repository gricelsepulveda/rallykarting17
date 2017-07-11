    <div class="dialog">
        <div class="panel panel-default">
            <p class="panel-heading no-collapse">Inicio de Sesión</p>
            <div class="panel-body">
                <form method="POST" action="<?php echo base_url();?>manager/login" id="frmLogin">
                    <?php if (isset($mensaje)){ ?>
                        <div class="alert alert-error">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                             <?php echo $mensaje;?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control span12" required email>
                    </div>
                    <div class="form-group">
                        <label>Clave</label>
                        <input type="password" name="clave" class="form-control span12 form-control" required>
                    </div>
                    <button type="Submit" class="btn btn-primary pull-right">Ingresar</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <p class="pull-right footer-manager">
            <!-- <a href="http://www.gbarrerasaez.cl/?utm_source=manager" target="_blank">gbarrerasaez</a> -->
        </p>
        <p class="footer-manager">
            <a href="<?php echo base_url();?>manager/recuperar_clave">Olvido su clave?</a>
        </p>
    </div>

    
    <script src="lib/jquery-1.11.1.min.js" type="text/javascript"></script>   
    <script src="lib/bootstrap/js/bootstrap.js"></script>    
    <script src="lib/jquery.validate.min.js"></script>       
    <script src="lib/custom.js"></script>
    
  
</body>
</html>
