        <div class="login-usuario">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2">
                        <div class="cuadro-login">
                            <br>
                            <img src="<?php echo base_url();?>assets/img/icon-user.png" alt="">
                            <br><br>
                            <strong>Ingreso</strong>
                            <?php if (isset($mensaje)) { ?>
                                <p class="error"><?php echo $mensaje; ?></p>
                            <?php } ?>
                            <br>
                            <!--<form action="" method="POST">-->
                            <?php echo form_open('inicio/login'); ?>
                                <input type="text" name="rut" id="rut" placeholder="Rut, sin puntos ni guión"><br>

                                <div class="clearfix"></div>
                                <br>

                                <button class="btn btn-amarillo">Listo</button>
                                <div class="clearfix"></div>
                                <br>
                            <!--</form>-->
                            <?php echo form_close(); ?>
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