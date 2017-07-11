
<div class="sidebar-nav">
    <?php $this->load->view('manager/menu'); ?>
</div>

<div class="content">
    
    <div class="header">   
        <h1 class="page-title"><?php echo $plural ?></h1>
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>/manager">Inicio</a> </li>
            <li><a href="<?php echo $base_path; ?>/listado"><?php echo $plural ?></a></li>
            <li class="active">Agregar <?php echo $singular ?></li>
        </ul>
    </div>
    <div class="main-content">

        <small>* Campo obligatorio</small>
        <br>
        <br>

        <div class="row">
            <div class="col-md-6">
                <form id="frmAgregarAcceso" method="POST" action="<?php echo $base_path; ?>/agregar" >

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
                        <input type="text" value="" class="form-control" minlength="4" required name="nombre">
                    </div>
                    
                    <div class="form-group">
                        <label for="apellidos">Apellidos*: </label>
                        <input type="text" value="" class="form-control"  minlength="4" required name="apellidos">
                    </div>       
                    
                    <div class="form-group">
                        <label for="email">Email*: </label>
                        <input type="email" value="" class="form-control" required email name="correo">
                    </div>

                    <div class="form-group">
                        <label for="clave">Clave*: </label>
                        <input type="text" value="" class="form-control" required minlength="8" id="clave" name="clave" >                        
                    </div>
                    
                    
                     <div class="form-group">                        
                        <input type="checkbox" value="1"  name="administrador">
                        <label for="administrador">Administrador General</label>
                    </div>
                    
                    <div class="form-group">
                        <label>Menús: </label>
                        <table class="table table-responsive table-striped table-bordered table-condensed">                            
                            <tbody>
                                <?php for ($i=0;$i< sizeof($menus);$i++) {  ?>
                                <tr>
                                    <td><?php echo $menus[$i]->nombre;?></td>
                                    <td><input type="checkbox" name="menu[]" value="<?php echo $menus[$i]->id_menu;?>"/></td>                                    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>    
                    </div>
                    
                    <div class="form-group">
                        <label>Observaciones: </label>
                        <textarea name="observaciones" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="btn-toolbar list-toolbar">      
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                        <a href="<?php echo $base_path; ?>/listado">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-list"></i> Volver al Listado
                        </button>
                        </a>
                    </div>

                </form>
            </div>
        </div>

       