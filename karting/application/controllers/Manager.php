<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

	public function __construct()
    {   
        parent::__construct();                    
        // Carga de Modelos
        $this->load->model('manager/accesos_model');   
        $this->load->model('manager/configuraciones_model');  
    }

    // Cargo manager si esta conectado
    public function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in)
        { 
            redirect('manager/panel'); 
        }
        $this->login();
    }

    // Login manager
    public function login()
    {
        if ($data = $this->input->post())
        {
            $data["mensaje"] = $this->accesos_model->validar_login($data);			
        }
        $this->load->view('manager/header');
        $this->load->view('manager/login',$data);
    }
    
    // Desconectar manager
    public function desconectar()
    {
        $this->session->sess_destroy();
        redirect('manager');
    }
    
    // Recuperar Clave manager
    public function recuperar_clave()
    {
        if ($data = $this->input->post())
        {
            $data["mensaje"] = $this->accesos_model->enviar_clave($data);			
        }
        $this->load->view('manager/header');
        $this->load->view('manager/recuperar-clave',$data);
    }

    // Carga panel manager
    public function panel()
    {
        // Verifico accesos y menus
        $logged_in = $this->session->userdata('logged_in');
        if (!$logged_in)
        { 
            redirect('manager'); 
        }
        $data["menus_usuario"] = $this->accesos_model->listar_menus_usuario($this->session->userdata('id_acceso'));
        $this->load->view('manager/header');
        $this->load->view('manager/panel',$data);
        $this->load->view('manager/footer');
    }

}