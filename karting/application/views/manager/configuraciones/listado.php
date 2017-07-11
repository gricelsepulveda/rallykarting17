
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

      <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading no-collapse">Listado de <?php echo $item_plural?> </div>
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>                
                <tr>                  
                  <th>Parametro</th>
                  <th>Valor</th>
                  <th>Acciones</th>                  
                </tr>
              </thead>
              <tbody>
                <?php for ($i=0; $i < sizeof($registros); $i++) { ?>
                <tr>                  
                  <td><?php echo $registros[$i]->item;?></td>
                  <td><?php echo substr( htmlentities( $registros[$i]->valor ),0,100 );?></td>                  
                  <td>      
                    <a class="btn btn-success btn-responsive" href="<?php echo $base_path;?>/editar/<?php echo $registros[$i]->id_configuracion;?>">
                      <i class="fa fa-edit"></i> Editar
                    </a> 
                  </td>                  
                </tr>
                <?php } ?>                                
              </tbody>
            </table>         
            </div>
        </div>
        
        
      </div>     
     

      