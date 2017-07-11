
<div class="sidebar-nav">
    <?php $this->load->view('manager/menu'); ?>
</div>

<div class="content">
    
    <div class="header">   
        <h1 class="page-title"><?php echo $item_plural ?></h1>
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>manager">Inicio</a> </li>
            <li><a href="<?php echo $base_path; ?>/listado"><?php echo $item_plural ?></a></li>
            <li class="active">Editar <?php echo $item_singular ?></li>
        </ul>
    </div>
    <div class="main-content">

        <small>* Campo obligatorio</small>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6">
                <form id="frmEditarConf" method="POST" action="<?php echo $base_path;?>/actualizar/<?php echo $data->id_configuracion;?>" >

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
                        <label for="item">Parametro: </label> <br>
                        <input type="text" class="form-control"  minlength="4" readonly required name="item" value="<?php echo $data->item;?>">                        
                    </div>
                    
                    <div class="form-group">
                        <label for="valor">Valor*: </label>

                        <?php if ($data->tipo=='text') { ?>
                            <input type="text" class="form-control"  minlength="4" required name="valor" value="<?php echo $data->valor;?>">
                        <?php } ?>
                         <?php if ($data->tipo=='textarea') { ?>
                            <textarea name="valor" class="form-control" rows="10" required><?php echo $data->valor;?></textarea>
                        <?php } ?>


                    </div>       

                    <div class="btn-toolbar list-toolbar">      
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                        <a href="<?php echo $base_path; ?>">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-list"></i> Volver al Listado
                        </button>
                        </a>
                    </div>

                </form>
            </div>
        </div>

       