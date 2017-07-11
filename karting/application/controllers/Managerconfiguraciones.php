<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagerConfiguraciones extends CI_Controller {	

    public function __construct()
    {   
        parent::__construct();    
        // Carga de Modelos
        $this->load->model('manager/accesos_model');                 
        $this->load->model('manager/configuraciones_model');      
        $this->nombre_menu = "managerconfiguraciones";           
        // Valido la session  
        $logged_in = $this->session->userdata('logged_in');       
        if (!$logged_in)
        { 
            redirect('manager/login'); 
        } 
        else
        {       
            
            // Cargo los menúes de usuario
            $this->menus_usuario = $this->accesos_model->listar_menus_usuario($this->session->userdata('id_acceso'));
            // Verifico si el menu actual esta en los permitidos           
            if (!in_multiarray($this->router->fetch_class(),$this->menus_usuario))
            {
                redirect('manager/desconectar'); 
            }
        }
    }

    // Cargo listado
    public function index()
    {
        $this->configuraciones();
    }

    public function configuraciones($mensaje=array())
    {   
        if (sizeof($mensaje)==0)
        {
            $mensaje["tipo"] ='';
        }        
        $data["nombre_menu"]    = $this->nombre_menu;
        $data["menus_usuario"]      =  $this->menus_usuario;        
        $data["item_plural"]        = "Configuraciones";        
        $data["mensaje"]            = $mensaje;   
        $data["base_path"]          = base_url().$this->router->fetch_class();        
        $data["registros"]          = $this->configuraciones_model->listar_configuraciones(0);
        $this->load->view('manager/header');    
        $this->load->view('manager/configuraciones/listado',$data);
        $this->load->view('manager/footer');  
    }

    // Edito un registro
    public function editar($id)
    {       
        $data["menus_usuario"]      =  $this->menus_usuario;
        $mensaje                    = array();        
        $data["item_singular"]      = "Configuración";
        $data["item_plural"]        = "Configuraciones";
        $data["mensaje"]["tipo"]    = "";  
        $data["nombre_menu"]        = $this->nombre_menu;
        if (isset($id))
        {
            $data["data"] = $this->configuraciones_model->traer_registro($id);                   
        }                    
        $data["base_path"] = base_url().$this->router->fetch_class();
        $this->load->view('manager/header');  
        $this->load->view('manager/configuraciones/editar',$data);
        $this->load->view('manager/footer');
        
    }

    // Actualizo un registro
    public function actualizar($id)

    {       
        $data["menus_usuario"]      =  $this->menus_usuario;        
        $data["item_singular"]      = "Configuración";
        $data["item_plural"]        = "Configuraciones";
        $data["mensaje"]["tipo"]    = "";    
        $data["nombre_menu"]        = $this->nombre_menu;  
        $this->load->view('manager/header');        

        $mensaje=array();
        if (isset($id))
        {
            $form               = $this->input->post();
            $data["mensaje"]    = $this->configuraciones_model->actualizar($id,$form);
            $data["data"]       = $this->configuraciones_model->traer_registro($id);    
        }             
        $data["base_path"] = base_url().$this->router->fetch_class();
        $this->load->view('manager/configuraciones/editar',$data);
        $this->load->view('manager/footer');
    }

}
