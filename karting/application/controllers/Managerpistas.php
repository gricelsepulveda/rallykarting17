<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagerPistas extends CI_Controller {	

     private $menus_usuario;

     public function __construct()
    {   
        parent::__construct();                    
        // Carga de Modelos
        $this->load->model('manager/accesos_model'); 
        $this->load->model('manager/pistas_model');                
        $this->nombre_menu = "managerpistas";
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

    // Presento listado de registros        
    public function listado(
        $comienzo='0',
        $cuantos='10',
        $orden='id_pista-desc',
        $busqueda='',
        $mensaje=array())
    {   
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["base_path"]      = base_url().$this->router->fetch_class(); 
        $data["nombre_menu"]    = $this->nombre_menu;
        if (sizeof($mensaje)==0)
        {
            $mensaje["tipo"] ='';
        }                
        $data["item_singular"]  = "Pista";
        $data["item_plural"]    = "Pistas";        
        $data["mensaje"]        = $mensaje;   
        $this->load->view('manager/header');    

        if ($busqueda=='')
        {
            $busqueda = $this->input->post('busqueda');                                            
        }     

        $data["busqueda"]           = $busqueda;                   
        $data["comienzo"]           = $comienzo;
        $data["cuantos"]            = $cuantos; 
        $data["orden"]              = $orden;
        $data["busqueda"]           = $busqueda;                                  
        $data["registros"]          = $this->pistas_model->listar_pistas($data["comienzo"],$data["cuantos"],$data["orden"],$data["busqueda"]);
        $config['total_rows']       = sizeof($this->pistas_model->listar_pistas(0,'','',$data["busqueda"]));
        $data["total_registros"]    = $config['total_rows'];                        
        $config['base_url']         = base_url().$this->router->fetch_class()."/listado";
        $config['per_page']         = $data["cuantos"]; 
        $config['uri_segment']      = 3;
        $config['suffix']           = '/'.$data["cuantos"].'/'.$data["orden"].'/'.$data["busqueda"];          
        $config['first_url']        = $config['base_url'].'/0/'.$data["cuantos"].'/'.$data["orden"].'/'.$data["busqueda"];         
        $this->pagination->initialize($config);                                                 
        $this->load->view('manager/pistas/listado',$data);
        $this->load->view('manager/footer');  
    }

    // Agrego un nuevo registro
    public function agregar()
    {   
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["base_path"]      = base_url().$this->router->fetch_class(); 
        $data["nombre_menu"]    = $this->nombre_menu;        
        $data["item_singular"]      = "Pista";
        $data["item_plural"]        = "Pistas";
        $data["mensaje"]["tipo"]    = "";      
        $this->load->view('manager/header');        

        $form = $this->input->post();

        if (sizeof($form)>0)
        {
            $data["mensaje"] = $this->pistas_model->agregar($form);
            unset($form);
        }                            
        
        $this->load->view('manager/pistas/agregar',$data);
        $this->load->view('manager/footer');
    }

    // Edito un  registro            
    public function editar($id)
    {
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["base_path"]      = base_url().$this->router->fetch_class(); 
        $data["nombre_menu"]    = $this->nombre_menu;
        $mensaje=array();                
        $data["item_singular"]      = "Pista";
        $data["item_plural"]        = "Pistas";
        $data["mensaje"]["tipo"]    = "";           
        if (isset($id))
        {
            $data["data"] = $this->pistas_model->traer_registro($id);                   
        }         
        $this->load->view('manager/header');  
        $this->load->view('manager/pistas/editar',$data);
        $this->load->view('manager/footer');
        
    }

    // Elimino un  registro            
    public function eliminar($id)
    {
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["base_path"]      = base_url().$this->router->fetch_class(); 
        $mensaje=array();
        if (isset($id))
        {
            $mensaje = $this->pistas_model->eliminar($id);            
        }                    
        $this->listado('','','','',$mensaje);        
    }

    // Actualizo un  registro            
    public function actualizar($id)

    {
        $data["menus_usuario"]      = $this->menus_usuario;
        $data["base_path"]          = base_url().$this->router->fetch_class();         
        $data["item_singular"]      = "Pista";
        $data["item_plural"]        = "Pistas";
        $data["mensaje"]["tipo"]    = "";      
        $data["nombre_menu"]        = $this->nombre_menu;
        $this->load->view('manager/header');        

        $mensaje=array();
        if (isset($id))
        {
            $form = $this->input->post();
            $data["mensaje"] = $this->pistas_model->actualizar($id,$form);
                
        }             
        $data["data"]           = $this->pistas_model->traer_registro($id);
        $this->load->view('manager/pistas/editar',$data);
        $this->load->view('manager/footer');
    }   

    

}