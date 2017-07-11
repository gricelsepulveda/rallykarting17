 <ul>
    <li><a href="<?php echo base_url();?>manager" class="nav-header"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <?php        
    for ($i=0; $i < sizeof($menus_usuario); $i++)  {                
        if ($menus_usuario[$i]["id_padre"]==0) { ?>
            <li>
                <a href="javascript:void(0);"  class="nav-header" >
                    <i class="fa fa-bars"></i> <?php echo $menus_usuario[$i]["nombre"];?>
                </a>
            </li>
            <?php } else { ?>
            <li>
                <ul class="dashboard-menu-<?php echo $menus_usuario[$i]["id_padre"];?> nav nav-list collapse in">
                    <li <?php if (isset($nombre_menu) && $nombre_menu==$menus_usuario[$i]["metodo"]){ echo "class='menu-active'"; } ?>  >
                        <a href="<?php echo base_url();?><?php echo $menus_usuario[$i]["metodo"];?>">
                            <span class="fa fa-caret-right"></span> 
                            <?php echo $menus_usuario[$i]["nombre"];?> 
                        </a>
                    </li>
                </ul>
            </li>
        <?php } 
    } ?>    
    <li><a href="<?php echo base_url();?>" class="nav-header" target="_blank">
        <i class="glyphicon glyphicon-home"></i> Ver sitio Web</a>
    </li>
     <li><a href="<?php echo base_url();?>manager/desconectar" class="nav-header" >
        <i class="glyphicon glyphicon-user"></i> Desconectar (<?php echo $this->session->nombre ;?>)</a>
    </li>
 </ul>