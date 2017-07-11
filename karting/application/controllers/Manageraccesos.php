<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagerAccesos extends CI_Controller {	

     private $menus_usuario;

     public function __construct()
    {   
        parent::__construct();                    
        // Carga de Modelos
        $this->load->model('manager/accesos_model'); 
        // nombre menu
        $this->nombre_menu = 'manageraccesos';
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
        $this->listado();
    }

    // Listado de Registros
    public function listado(
        $comienzo='0',  
        $cuantos='10',
        $orden='id_acceso-desc',
        $busqueda='',
        $mensaje=array())
    {	        
        if (sizeof($mensaje)==0) $mensaje["tipo"] ='';
        if ($busqueda=='') $busqueda = $this->input->post('busqueda'); 
        
        $data["mensaje"]         = $mensaje;   
        $data["busqueda"]        = $busqueda;                   
        $data["comienzo"]        = $comienzo;
        $data["cuantos"]         = $cuantos; 
        $data["orden"]           = $orden;
        $data["busqueda"]        = $busqueda; 
        $data["total_registros"] = sizeof($this->accesos_model->listar_accesos(0,'','',$data["busqueda"]));
        $data["registros"]       = $this->accesos_model->listar_accesos
        (
            $data["comienzo"],
            $data["cuantos"],
            $data["orden"],
            $data["busqueda"]
        );

        // Configuro paginación
        $config['total_rows']       = $data["total_registros"];        
        $config['base_url']         = base_url().$this->router->fetch_class()."/listado";              
        $config['per_page']         = $data["cuantos"]; 
        $config['uri_segment']      = 3;
        $config['suffix']           = '/'.$data["cuantos"].'/'.$data["orden"].'/'.$data["busqueda"];          
        $config['first_url']        = $config['base_url'].'/0/'.$data["cuantos"].'/'.$data["orden"].'/'.$data["busqueda"];   
        $this->pagination->initialize($config);                                                 

        // Cargo Vistas        
        $data["menus_usuario"]   = $this->menus_usuario;
        $data["singular"]        = "Acceso";
        $data["plural"]          = "Accesos";
        $data["base_path"]       = base_url().$this->router->fetch_class(); 
        $data["nombre_menu"]     = $this->nombre_menu;
        $this->load->view('manager/header');
        $this->load->view('manager/accesos/listado',$data);
        $this->load->view('manager/footer');  
    }

    // Agrego un registro
    public function agregar()
    {                   
        $data["mensaje"]["tipo"] = "";      
        $this->load->view('manager/header');        

        $form = $this->input->post();
        if (sizeof($form)>0)
        {
            $data["mensaje"] = $this->accesos_model->agregar($form);
            unset($form);
        }                    

        $data["menus"]           = $this->accesos_model->listar_menus();
        $data["menus_usuario"]   = $this->menus_usuario;
        $data["singular"]        = "Acceso";
        $data["plural"]          = "Accesos";
        $data["base_path"]       = base_url().$this->router->fetch_class(); 
        $data["nombre_menu"]     = $this->nombre_menu;
        $this->load->view('manager/accesos/agregar',$data);
        $this->load->view('manager/footer');
    }

    // Edito un registro
    public function editar($id)
    {
        
        $mensaje=array();        
        $data["mensaje"]["tipo"] = "";          
        if (isset($id))
        {
            $data["data"]       = $this->accesos_model->traer_registro($id);                   
        }                    
        $data["menus"]          = $this->accesos_model->listar_menus();
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["singular"]       = "Acceso";
        $data["plural"]         = "Accesos";
        $data["base_path"]      = base_url().$this->router->fetch_class(); 
        $data["nombre_menu"]     = $this->nombre_menu;
        $this->load->view('manager/header');  
        $this->load->view('manager/accesos/editar',$data);
        $this->load->view('manager/footer');
        
    }

    // Elimino un registro
    public function eliminar($id)
    {   
        $mensaje=array();
        if (isset($id))
        {
            $mensaje = $this->accesos_model->eliminar($id);            
        }                    
        $this->listado('','','','',$mensaje);        
    }

    // Actualizo un registro
    public function actualizar($id)

    {
        $data["mensaje"]["tipo"] = "";              
        $this->load->view('manager/header');        

        $mensaje=array();
        if (isset($id))
        {
            $form               = $this->input->post();
            $data["mensaje"]    = $this->accesos_model->actualizar($id,$form);
            $data["data"]       = $this->accesos_model->traer_registro($id);    
        }   
        $data["menus"]          = $this->accesos_model->listar_menus();
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["singular"]       = "Acceso";
        $data["plural"]         = "Accesos";
        $data["base_path"]      = base_url().$this->router->fetch_class();    
        $data["nombre_menu"]     = $this->nombre_menu;       
        $this->load->view('manager/accesos/editar',$data);
        $this->load->view('manager/footer');
    }      
}
