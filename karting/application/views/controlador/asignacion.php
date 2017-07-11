<form name="frmAsignaciones" action="<?php echo base_url();?>controlador/asignacion" method="POST">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                <div class="listado-usuarios">
                    <?php if (isset($mensaje)){ ?>
                        <div class="alert alert-error">
                            <?php echo $mensaje;?>
                        </div>
                    <?php } ?>
                    <?php for ($i=0; $i < sizeof($asignaciones); $i++) { ?>
                        <div class="col-md-2 col-xs-4">
                            <img src="img/icon-user-1.png">
                        </div>
                        <div class="col-md-10 col-xs-8 info">
                            <h2><?php echo $this->usuarios_model->nombre_usuario($asignaciones[$i]->id_usuario) ?></h2>
                            <h5><?php echo $this->usuarios_model->rut_usuario($asignaciones[$i]->id_usuario) ?></h5>
                            <input type="hidden" name="id_usuario[]" value="<?php echo $asignaciones[$i]->id_usuario; ?>">
                            <div class="form-group">
                                <select class="form-control" name="id_karting[]">
                                <option value="">Sin Asignar</option>
                                <?php for ($j=0; $j < sizeof($kartings); $j++) { ?>
                                    <option value="<?php echo $kartings[$j]->id_karting;?>"
                                    <?php if ($kartings[$j]->id_karting==$asignaciones[$i]->id_karting){ echo "selected"; } ?>>                  
                                    <?php echo $kartings[$j]->nombre;?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div><!-- /.container -->

    <div class="clearfix"></div>
    <br>
    <br>    
    <div class="col-md-12 col-xs-12 btns_footer">
        <?php if ($i==0) { ?>
            <a href="<?php echo base_url();?>controlador/ingreso_participante">
                <button type="button" class="btn btn-actualizar">Volver</button>
            </a>
        <?php } else { ?>
            <a href="<?php echo base_url();?>controlador/finalizar">
                <button type="button" class="btn btn-actualizar">Finalizar</button>
            </a>
        <?php } ?>
        <button type="submit" class="btn btn-asignacion">Listo</button>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>