<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagerVueltas extends CI_Controller
{	
    private $menus_usuario;

    public function __construct()
    {
        parent::__construct();
        
        // Carga de Modelos
        $this->load->model('manager/accesos_model');
        $this->load->model('manager/usuarios_model');
        $this->load->model('manager/vueltas_model');
        $this->load->model('manager/ranking_model');

        $this->nombre_menu = "managervueltas";
        
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
    public function listado($comienzo='0', $cuantos='10', $orden='id-desc', $busqueda='', $mensaje=array())
    {
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["base_path"]      = base_url().$this->router->fetch_class(); 
        $data["nombre_menu"]    = $this->nombre_menu;
        
        if (sizeof($mensaje)==0)
        {
            $mensaje["tipo"] ='';
        }                
        
        $data["item_singular"]  = "Vuelta";
        $data["item_plural"]    = "Vueltas";        
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
        
        $data["registros"]          = $this->vueltas_model->listar($data["comienzo"],$data["cuantos"],$data["orden"],$data["busqueda"]);
        
        $config['total_rows']       = sizeof($this->vueltas_model->listar(0,'','',$data["busqueda"]));
        
        $data["total_registros"]    = $config['total_rows'];                        
        
        $config['base_url']         = base_url().$this->router->fetch_class()."/listado";
        $config['per_page']         = $data["cuantos"]; 
        $config['uri_segment']      = 3;
        $config['suffix']           = '/'.$data["cuantos"].'/'.$data["orden"].'/'.$data["busqueda"];          
        $config['first_url']        = $config['base_url'].'/0/'.$data["cuantos"].'/'.$data["orden"].'/'.$data["busqueda"];         
        
        $this->pagination->initialize($config);                                                 
        
        $this->load->view('manager/vueltas/listado',$data);
        $this->load->view('manager/footer');
    }

    /**
     * Eliminar registro via Ajax
     * 
     * @param integer $id 
     * @return view
     */
    public function eliminar($id)
    {
        $data["menus_usuario"]  = $this->menus_usuario;
        $data["base_path"]      = base_url().$this->router->fetch_class();
        $mensaje=array();
        
        if (isset($id)) {
            // Eliminar registro
            $mensaje = $this->vueltas_model->eliminar($id);

            // Actualizar detalle ranking
            $this->ranking_model->nuevo_detalle_ranking();

            // Actualizar ranking
            $this->ranking_model->nuevo_ranking();
        }
        
        $this->listado('','','','', $mensaje);
    }
}