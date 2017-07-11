
<div class="sidebar-nav">
    <?php $this->load->view('manager/menu'); ?>
</div>


<div class="content">
    
    <div class="header">   
        <h1 class="page-title"><?php echo $item_plural ?></h1>
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>manager">Inicio</a> </li>
            <li><a href="<?php echo $base_path;?>/listado"><?php echo $item_plural ?></a></li>
            <li class="active">Editar <?php echo $item_singular ?></li>
        </ul>
    </div>
    <div class="main-content">

    <small>* Campo obligatorio</small>
        <br>
        <br>
        <div class="row">
            <div class="col-md-9">
                <form id="frmEditarControlador" method="POST" action="<?php echo $base_path;?>/actualizar/<?php echo $data->id_controlador;?>" >

                    <?php if ($mensaje["tipo"]=='Aviso') { ?>
                    <div class="alert alert-success">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $mensaje["texto"]; ?>
                    </div>
                    <?php } ?>
                    <?php if ($mensaje["tipo"]=='Error') { ?>
                    <div class="alert alert-error">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $mensaje["texto"]; ?>
                    </div>
                    <?php } ?>
                    
                    <div class="form-group">
                        <label for="nombre">Nombre*: </label>
                        <input type="text" value="<?php echo $data->nombre; ?>" class="form-control" minlength="4" required name="nombre">
                    </div> 

                     <div class="form-group">
                        <label for="correo">Correo*: </label>
                        <input type="text" value="<?php echo $data->correo; ?>" class="form-control required" minlength="4" required name="correo">
                    </div>

                    <div class="form-group">
                        <p>Ingrese una nueva clave para cambiar la actual.</p>
                        <label for="clave">Clave: </label>
                        <input type="clave" class="form-control" minlength="8" name="clave" id="clave" >
                    </div>

                    <div class="form-group">
                        <label for="pistas">Pistas </label>
                            <div class="clearfix"></div> 
                             <select name="pistas[]" id="pistas"  
                              data-placeholder="Seleccione las Pistas" 
                                class="form-control chosen-select" 
                                multiple>
                                <?php for ($i=0; $i < sizeof($pistas); $i++) { ?>
                                <option value="<?php echo $pistas[$i]->id_pista;?>"
                                <?php 
                                 echo $this->controladores_model->controlador_pertenece_pista($data->id_controlador,$pistas[$i]->id_pista) ? 
                                "selected" : '';  ?>>
                                    <?php echo $pistas[$i]->nombre;?> 

                                </option>
                                <?php } ?>
                            </select>
                    </div>

                    <div class="btn-toolbar list-toolbar">      
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                        <a href="<?php echo $base_path;?>/listado">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-list"></i> Volver al Listado
                        </button>
                        </a>
                    </div>

                </form>
            </div>
        </div>

        
        