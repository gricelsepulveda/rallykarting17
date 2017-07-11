<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->model('log_ws_model', 'log_ws');
		$this->load->model('vehicles_model', 'vehicles');
		$this->load->model('racings_model', 'racings');
		$this->load->model('drivers_model', 'drivers');
		$this->load->model('laps_model', 'laps');
	}

	public function login()
    {
		$this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));

        $this->form_validation->set_rules('txt_rut', 'Rut', 'trim|required');
        $this->form_validation->set_rules('txt_pass', 'Contraseña', 'trim|required');
        $this->form_validation->set_message('required', 'El %s es requerido');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('frontend/login');
        }
        else {
            $rut = $this->input->post('txt_rut', true);
            $pass = $this->input->post('txt_pass', true);

            $login = $this->drivers->login($rut, $pass);

            if (count($login) > 0) {
            	$login = (array_key_exists(0, $login)) ? $login[0] : $login;

                $new_session = array(
                   'usr_id'  => $login->id_usuario,
                   'usr_nombre'     => $login->nombre
               	);

               	$this->session->set_userdata($new_session);

                $this->ranking();

            }
            else {
                $this->session->set_flashdata('error_rut', 'Rut incorrecto');
                $this->load->view('frontend/login');
            }
        }
    }

    public function ranking()
    {
    	$session = $this->session->userdata('usr_id');
    	if(!isset($session) || empty($session)) {
    		redirect('frontend/login');
    	}

    	$this->load->helper('laps_helper');

        // Obtener los mejores corredores segun tiempo
        $bests = $this->laps->get_bests_drivers(5);

        // Obtener mejores tiempo por corredor
        foreach($bests as $key => $value)
        {
            if(!empty($value->id_usuario))
            {
                // Actualizar tiempos de corredores
                update_durations($value->id_usuario);

                // Obtener tiempos de corredores
                $drivers[$value->nombre] = $this->laps->get_bests_by_driver($value->id_usuario, 5);

            }
        }

        // Saber si estoy dentro de los mejores ranking
        $my_id = $this->session->userdata('usr_id');
        $my_name = $this->session->userdata('usr_nombre');
        $in_five = false;

        foreach($drivers as $key => $value)
        {
            foreach($value as $k => $v)
            {
                if($v->id_usuario == $my_id)
                {
                    $in_five = true;
                }
            }
        }

        // Soy mal corredor, no estoy dentro de los mejores
        if($in_five == false)
        {
            // Actualizo mis tiempos
            update_durations($my_id);
            $me[$my_name] = $this->laps->get_bests_by_driver($my_id, 5);
        }

        // Salida de información
        $data['drivers']    =   $drivers;
        $data['me']         =   (isset($me) && !empty($me)) ? $me : null;
        //print_r($drivers); exit;

        $this->load->view('frontend/ranking', $data);
    }
}