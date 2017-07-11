
<div class="sidebar-nav">
    <?php $this->load->view('manager/menu'); ?>
</div>


<div class="content">
    
    <div class="header">   
        <h1 class="page-title"><?php echo $item_plural ?></h1>
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>manager">Inicio</a> </li>
            <li><a href="<?php echo $base_path;?>/listado"><?php echo $item_plural ?></a></li>
            <li class="active">Agregar <?php echo $item_singular ?></li>
        </ul>
    </div>
    <div class="main-content">

    <small>* Campo obligatorio</small>
        <br>
        <br>
        <div class="row">
            <div class="col-md-9">
                <form id="frmAgregarUsuario" method="POST" action="<?php echo $base_path;?>/agregar" >

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
                        <label for="descripcion">Descripción*: </label>
                        <input type="text" value="" class="form-control" minlength="4" required name="descripcion">
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

       