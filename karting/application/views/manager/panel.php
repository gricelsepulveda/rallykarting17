 <div class="sidebar-nav">
   <?php $this->load->view('manager/menu'); ?>
   
       
    </div>

    <div class="content">
        <div class="header">
   
            <h1 class="page-title">Inicio</h1>
                    <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>manager">Inicio</a> </li>
            
        </ul>

        </div>
        <div class="main-content">

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <a  class="panel-heading" data-toggle="no-collapse">Bienvenid@ <?php echo $this->session->nombre ;?> </a>
                    <div  class="panel-body collapse in">
                        
                        <p>Bienvenido a su panel de administración, mediante esta interfaz usted podrá configurar y administrar los diversos contenidos de su sitio web, 
                            para entrar a una sección en particular, solo seleccione un ítem del listado izquierdo. </p>
                        
                    </div>
                </div>
            </div>
        </div>

 