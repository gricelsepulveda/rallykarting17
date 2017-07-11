
    <div class="sidebar-nav">
    <?php $this->load->view('manager/menu'); ?>
    </div>

    <div class="content">
      <div class="header">   
        <h1 class="page-title"><?php echo $item_plural?></h1>
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url();?>manager">Inicio</a> </li>
          <li class="active"><?php echo $item_plural?></li>
        </ul>
      </div>

  <div class="main-content">

    <div class="row">

      <div class="col-md-12 form-group">
        <a href="<?php echo $base_path;?>/agregar" class="btn btn-primary">Agregar <?php echo $item_singular?></a>         
      </div>

      <div class="col-md-12 form-group">
        <form method="POST" class="form-inline" action="<?php echo $base_path;?>/listado/0/<?php echo $cuantos;?>/<?php echo $orden;?>/" >        
          <input type="text" name="busqueda" class="form-control input-largo" placeholder="Ingrese el texto a buscar" value="<?php echo $busqueda ?>">
          <button type="submit" class="btn btn-default">Buscar</button>      
          <button type="button" class="btn btn-default" onclick="javascript:location.href='<?php echo $base_path;?>/listado'" >Limpiar</button>
        </form>
      </div>

    </div>
    <div class="row">

      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading no-collapse">Listado de <?php echo $item_plural?> </div>

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

            <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>                
                <tr>                  
                  <th>Nombre                     
                      <?php create_link_orden('nombre',$base_path,$comienzo,$cuantos,$busqueda) ?>
                  </th>
                   <th>Descripción                     
                      <?php create_link_orden('descripcion',$base_path,$comienzo,$cuantos,$busqueda) ?>
                  </th>                                   
                  <th>Acciones</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php for ($i=0; $i < sizeof($registros); $i++) { ?>
                <tr>                  

                  <td> <?php echo $registros[$i]->nombre;?>  </td>
                  <td> <?php echo $registros[$i]->descripcion;?>  </td>
                  <td>      
                    
                    <a class="btn btn-success btn-responsive" href="<?php echo $base_path;?>/editar/<?php echo $registros[$i]->id_pista;?>">
                      <i class="fa fa-edit"></i> Editar
                    </a> 
                    <!--<a class="btn btn-danger btn-responsive triger-modal" href="#deleteModal" data-id="<?php echo $registros[$i]->id_pista;?>" data-toggle="modal">
                      <i class="fa fa-trash-o"></i> Eliminar
                    </a>-->
                  </td>                  
                </tr>
                <?php } ?>                
                <tr><td colspan="4"> Mostrando <?php echo sizeof($registros); ?> de <?php echo $total_registros; ?></td></tr>
              </tbody>
            </table>         
            </div>
        </div>
        
        <ul class="pagination">
          <?php echo $this->pagination->create_links(); ?>
        </ul>
      </div>

     
     

      <div class="modal small fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3>Confirmación</h3>
            </div>
            <div class="modal-body">
              
              <p class="error-text"><i class="fa fa-warning modal-icon"></i>¿Esta seguro que desea eliminar esta <?php echo $item_singular?>?</p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
              <a class="triger-action-modal" href="<?php echo $base_path;?>/eliminar/">
                <button class="btn btn-danger" >Eliminar </button>
              </a>
            </div>
          </div>
        </div>
      </div>

       