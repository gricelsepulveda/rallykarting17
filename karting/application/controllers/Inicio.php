<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();                    

        // Carga de Modelos
        $this->load->model('manager/usuarios_model');
        $this->load->model('manager/ranking_model');
        $this->load->model('manager/configuraciones_model');

        $this->load->helper('form');
    }

    // Cargo panel si esta conectado
    public function index()
    {
        $logged_in = $this->session->userdata('logged_usuario_in');

        if ($logged_in)
        {
            redirect('ranking');
        }

        $this->login();
    }

    // Login usuario
    public function login()
    {
        if ($data = $this->input->post())
        {
            $data["mensaje"] = $this->usuarios_model->validar_login($data);
        }

        $this->load->view('sitio/header');
        $this->load->view('sitio/login',$data);
    }

    // Ranking
    public function ranking()
    {
        $logged_in = $this->session->userdata('logged_usuario_in');

        if (!$logged_in)
        {
            //$this->login();
            redirect('/','refresh');
        }

        $data["ranking"] = $this->usuarios_model->listar_ranking();
        $data["me_id"] = $this->session->userdata('id_usuario');
        $data["in_top"] = false;

        foreach($data['ranking'] as $k => $v)
        {
            if($v->id_usuario == $data["me_id"])
            {
                $data["in_top"] = true;
            }
        }

        // Lista de pistas
        $data['racetracks'] =   $this->html_racetracks_options();

    	$this->load->view('sitio/header');
        $this->load->view('sitio/ranking',$data);
    }

    // Desconecto
    public function desconectar()
    {
        $this->session->sess_destroy();
        session_start();
        session_destroy();
        $this->login();
    }

    // recuperar clave
    public function clave()
    {
        if ($data = $this->input->post())
        {
            $data["mensaje"] = $this->usuarios_model->recuperar_clave($data);
        }

        $this->load->view('sitio/header');
        $this->load->view('sitio/clave',$data);
    }


    /**
     * Generar html de opciones de pistas
     * 
     * @param type|string $offset 
     * @param type|string $cuantos 
     * @param type|string $orden 
     * @param type|string $busqueda 
     * @return type
     */
    private function html_racetracks_options($offset = '',$cuantos = '', $orden = '', $busqueda = '')
    {
        $this->load->model('manager/pistas_model');
        $racetracks =   $this->pistas_model->listar_pistas($offset, $cuantos, $orden, $busqueda);

        $html       =   '';

        foreach($racetracks as $k => $v)
        {
            $html .= "<option value='$v->id_pista'>$v->nombre</option>";
        }

        return $html;
    }

    /**
     * HTML para mostrar el ranking según pista
     */
    public function change_ranking($racetrack)
    {
        $logged_in = $this->session->userdata('logged_usuario_in');

        if (!$logged_in || !$this->input->is_ajax_request())
        {
            return false;
        }

        $data["ranking"]    =   $this->usuarios_model->ranking_by_racetrack($racetrack);
        $data["me_id"]      =   $this->session->userdata('id_usuario');
        $data["racetrack"]  =   $racetrack;
        $data["in_top"]     =   false;

        foreach($data['ranking'] as $k => $v)
        {
            if($v->id_usuario == $data["me_id"])
            {
                $data["in_top"] = true;
            }
        }

        $this->load->view('sitio/cuadro_ranking', $data);
    }

    /**
     * Obtener la pista donde el usuario ha obtenido el mejor tiempo
     */
    public function my_best_racetrack()
    {
        $logged_in = $this->session->userdata('logged_usuario_in');

        if (!$logged_in || !$this->input->is_ajax_request())
        {
            return false;
        }

        $status =   0;
        $data   =   false;

        $me = $this->session->userdata('id_usuario');

        $ranking = $this->usuarios_model->detalle_ranking($me);

        if(array_key_exists(0, $ranking)) {
            if(isset($ranking[0]->id_pista) && !empty($ranking[0]->id_pista)) {
                $status =   1;
                $data   =   $ranking[0]->id_pista;
            }
        }

        $resp = array(
            'status'    =>  $status,
            'data'      =>  $data
        );

        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($resp));
    }
    
    
    /**
     * Actualizar datos del usuario
	*/
	public function registro(){
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	
		$data['idUsuarioRK'] = $this->input->post('idUsuarioRK') != null ? $this->input->post('idUsuarioRK') : $_COOKIE["idUsuarioRK"];
		
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
		$this->form_validation->set_rules('email', 'Correo', 'required|valid_email|trim');
		$this->form_validation->set_rules('telefono', 'Teléfono', 'trim');
		
		$this->form_validation->set_message('required', 'El %s es requerido');
		$this->form_validation->set_message('valid_email', 'El %s es incorrecto');
		
        $data['terminos'] = $this->configuraciones_model->by_item('terminos');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('sitio/header');
			$this->load->view('sitio/registro', $data);
		}
		else
		{
			//Actualizar la DB
			$dataUpdate = array(
			'id_usuario'		=>	$this->input->post('idUsuarioRK'),
			'nombre'			=>	$this->input->post('nombre'),
			'correo'			=>	$this->input->post('email'),
			'telefono'		=>	$this->input->post('telefono')
			);
		
			$this->usuarios_model->actualiza_usuario($dataUpdate);
		}

	}
}