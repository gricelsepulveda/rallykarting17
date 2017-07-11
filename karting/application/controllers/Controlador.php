<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlador extends CI_Controller {

	public function __construct()
    {   
        parent::__construct();                    
        // Carga de Modelos        
        $this->load->model('manager/controladores_model');  
        $this->load->model('manager/usuarios_model');  
        $this->load->model('manager/kartings_model');  
        $this->load->model('manager/pistas_model');  
    }

    // Cargo panel si esta conectado
    public function index()
    {
        $logged_in = $this->session->userdata('logged_controlador_in');
        if ($logged_in)
        { 
            redirect('controlador/panel'); 
        }
        $this->login();
    }

    
    // Login manager
    public function login()
    {
        if ($data = $this->input->post())
        {
            $data["mensaje"] = $this->controladores_model->validar_login($data);			
        }
        $data["pistas"] = $this->pistas_model->listar_pistas(0,'','','');    
        $this->load->view('controlador/header');
        $this->load->view('controlador/login',$data);
    }

   
    
    // Desconectar manager
    public function desconectar()
    {
        $this->session->sess_destroy();
        redirect('controlador');
    }

    // Carga panel principal de controlador
    public function panel()
    {
        $data["mensaje"] = '';
        // Verifico 
        $logged_in = $this->session->userdata('logged_controlador_in');        
        $data["id_pista"] = $this->session->userdata('id_pista');        
        if (!$logged_in)
        { 
            redirect('controlador'); 
        }    
        if (!$data["id_pista"])
        { 
           redirect('controlador'); 
        }           
        // Veo si existe una carrera
        $carrera = $this->controladores_model->recuperar_carrera();
        if ($carrera)
        {
            $data["texto_boton"] = "Recuperar ";
            $data["accion"] = "controlador/ingreso_participante";
        }        
        if (!$carrera) {
            $data["texto_boton"] = "Crear ";
            $data["accion"] = "controlador/nueva_carrera";
        }   
        $this->load->view('controlador/header');         
        $this->load->view('controlador/panel',$data);        
    }

    // Carga ingreso de participantes
    public function ingreso_participante()
    {
        $data["mensaje"] = '';
        
        // Verifico 
        $logged_in = $this->session->userdata('logged_controlador_in');        
        $data["id_pista"] = $this->session->userdata('id_pista');        
        $data["id_carrera"] = $this->session->userdata('id_carrera_en_curso');        
        
        if (!$logged_in)
        { 
            redirect('controlador'); 
        }    
        if (!$data["id_pista"])
        { 
           redirect('controlador'); 
        }  
        if (!$data["id_carrera"])
        { 
           redirect('panel'); 
        }    
        if ($data = $this->input->post())
        {
            $data["mensaje"] = $this->controladores_model->validar_asignar_usuario($data);            
        } 
        
        $this->load->view('controlador/header');         
        $this->load->view('controlador/ingreso_participante',$data);        
    }

    // Creo nueva carrera
    public function nueva_carrera()
    {
        $id_carrera = $this->session->userdata('id_carrera_en_curso');        
        if ($id_carrera)
        { 
            redirect('controlador/asignacion'); 
        }          
        // Verifico 
        $logged_in = $this->session->userdata('logged_controlador_in');        
        $id_pista = $this->session->userdata('id_pista');        
        if (!$logged_in)
        { 
            redirect('controlador'); 
        }    
        if (!$id_pista)
        { 
           redirect('controlador'); 
        }    
        $data["carrera"] = $this->controladores_model->crear_carrera();                    
        $this->load->view('controlador/header');        
        $this->load->view('controlador/crear_carrera',$data);       
    }

    // Registro de nuevo usuario
    public function registro_usuario()
    {
        // Verifico 
        $logged_in = $this->session->userdata('logged_controlador_in');        
        $data["mensaje"] = '';
        if (!$logged_in)
        { 
            redirect('controlador'); 
        }          
        if ($data = $this->input->post())
        {
            $data["mensaje"] = $this->usuarios_model->agregar_usuario_web($data);            
        }            
        $this->load->view('controlador/header');
        $this->load->view('controlador/registro_usuario',$data);  
    }

    public function asignacion()
    {
        // Verifico 
        $logged_in = $this->session->userdata('logged_controlador_in');
        $data["mensaje"] = '';
        
        if (!$logged_in)
        { 
            redirect('controlador'); 
        }          
        
        if ($data2 = $this->input->post())
        {
            $data["mensaje"] = $this->controladores_model->guardar_asignaciones($data2);            
            
            if ($data["mensaje"]=='')
            {
                redirect('controlador/ingreso_participante');
            }
        }            
        
        $data["asignaciones"] = $this->controladores_model->listar_asignaciones();
        $data["kartings"]     = $this->kartings_model->listar_kartings(0,0,'','');
        
        $this->load->view('controlador/header');
        $this->load->view('controlador/asignacion',$data);  
    }

    // Finalizo una carrera
    public function finalizar()
    {
        $logged_in = $this->session->userdata('logged_controlador_in');                
        if (!$logged_in)
        { 
            redirect('controlador'); 
        }          
        $this->controladores_model->finalizar_carrera();      
        redirect('controlador/panel');
        
    }

}