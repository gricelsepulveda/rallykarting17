
<div class="sidebar-nav">
    <?php $this->load->view('manager/menu'); ?>
</div>

<div class="content">
    
    <div class="header">   
        <h1 class="page-title"><?php echo $plural ?></h1>
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>/manager">Inicio</a> </li>
            <li><a href="<?php echo $base_path; ?>/listado"><?php echo $plural ?></a></li>
            <li class="active">Editar <?php echo $singular ?></li>
        </ul>
    </div>
    <div class="main-content">
        
        <small>* Campo obligatorio</small>
        <br>
        <br>

        <div class="row">
            <div class="col-md-6">
                <form id="frmEditarAcceso" method="POST" action="<?php echo $base_path;?>/actualizar/<?php echo $data->id_acceso;?>" >

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
                        <input type="text" class="form-control" minlength="4" required name="nombre" value="<?php echo $data->nombre;?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="apellidos">Apellidos*: </label>
                        <input type="text" class="form-control"  minlength="4" required name="apellidos" value="<?php echo $data->apellidos;?>">
                    </div>       
                    
                    <div class="form-group">
                        <label for="email">Email*: </label>
                        <input type="email" class="form-control" required email name="correo"  value="<?php echo $data->correo;?>">
                    </div>

                    <div class="form-group">
                        <p>Ingrese una nueva clave para cambiar la actual.</p>
                        <label for="clave">Clave: </label>
                        <input type="clave" class="form-control" minlength="8" name="clave" id="clave" >
                    </div>
                    
                    
                     <div class="form-group">                        
                        <input type="checkbox" value="1"  name="administrador" <?php if ($data->administrador){ echo 'checked';} ?>>
                        <label for="administrador">Administrador General</label>
                    </div>
                    
                    <div class="form-group">
                        <label>Menús: </label>
                        <table class="table table-responsive table-striped table-bordered table-condensed">                            
                            <tbody>
                                <?php for ($i=0;$i< sizeof($menus);$i++) {  ?>
                                <tr>
                                    <td><?php echo $menus[$i]->nombre;?></td>
                                    <td><input type="checkbox" name="menu[]" value="<?php echo $menus[$i]->id_menu;?>" 
                                        <?php if ($this->accesos_model->tiene_acceso($data->id_acceso,$menus[$i]->id_menu)){ echo 'checked'; } ?>
                                        /></td>                                    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>    
                    </div>
                    
                    <div class="form-group">
                        <label>Observaciones : </label>
                        <textarea name="observaciones" value="Smith" rows="3" class="form-control"><?php echo $data->observaciones;?></textarea>
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

       