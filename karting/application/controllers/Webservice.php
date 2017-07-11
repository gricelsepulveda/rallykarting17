<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        ini_set('max_execution_time', 700);
        $this->load->model('log_ws_model', 'log_ws');
        $this->load->model('vehicles_model', 'vehicles');
        $this->load->model('racings_model', 'racings');
        $this->load->model('drivers_model', 'drivers');
        $this->load->model('laps_model', 'laps');
        $this->load->model('manager/ranking_model');

        $this->load->library('zipper');
    }

    public function update_ranking()
    {
        // Actualizar detalle ranking
        $this->ranking_model->nuevo_detalle_ranking();

        // Actualizar ranking
        $this->ranking_model->nuevo_ranking();
    }

    /**
     * Retornar listado de todas las pistas
     * 
     * @return json 
     */
    public function racetracks()
    {
        // Obtener pistas
        $this->load->model('manager/pistas_model');
        $racetracks =   $this->pistas_model->listar_pistas('', '', '', '');
        
        $output['status']   =   (empty($racetracks)) ? 0 : 1;
        $output['data']     =   $racetracks;

        $getXML = $this->racetrack_xml($output);

        return $this->output
                ->set_content_type('text/xml')
                ->set_output($getXML);
    }

    /**
     * Generar XML de las pistas
     */
    public function racetrack_xml($output)
    {
        $this->load->helper('my_xml_helper');
        
        $dom    = xml_dom();
        $racetracks = xml_add_child($dom, 'racetracks');

        foreach($output['data'] as $k => $v)
        {
            $racetrack = xml_add_child($racetracks, 'racetrack');
            xml_add_child($racetrack, 'id_pista', $v->id_pista);
            xml_add_child($racetrack, 'nombre', $v->nombre, true);
        }

        return xml_print($dom, true);
    }
    
    /**
     * Eliminar datos que no nos importan de las fechas
     *
     * @param $time
     * @return mixed
     */
    public function clear_time($time)
    {
        $replace_T		=	str_replace('T', ' ', $time);
        $replace_str	=	str_replace('-03:00', '', $replace_T);

        return $replace_str;
    }

    /**
     * Procesar archivo ZIP
     * 
     * Se obtiene el archivo zip y se sube al servidor
     * 
     * @return json
     */
    public function upload_zip($racetrack)
    {
        // Se validan directorios
        if (!file_exists('./temp'))
            mkdir('./temp', 0777, true);

        if (!file_exists("./temp/$racetrack"))
            mkdir("./temp/$racetrack", 0777, true);        

        // Por seguridad, se intentan eliminar archivos antes de iniciar el proceso
        $zipfile    = "./temp/$racetrack/temp.zip";
        $jsonfile   = "./temp/$racetrack/temp.json";
        
        if(file_exists($zipfile))
            unlink($zipfile);
        
        if(file_exists($jsonfile))
            unlink($jsonfile);

        $config['upload_path']          = "./temp/$racetrack/";
        $config['allowed_types']        = '*';
        $config['max_size']             = 4096;

        $this->load->library('upload', $config);

        if ( !$this->upload->do_upload('myFile')) {
            $error = array('error' => $this->upload->display_errors());
            return 2;
        } else {
            $data = array('upload_data' => $this->upload->data());

            $this->load->library('zipper');
            $zip_file   =   './temp/'.$racetrack.'/'.$data['upload_data']['file_name'];
            $this->zipper->unzip_all($zip_file, "./temp/$racetrack/", true);

            $json = file_get_contents("./temp/$racetrack/temp.json");
            
            return $json;
        }
    }

    /**
     * Proceso para guardar toda la información desde la aplicación
     *
     * @return     integer
     */
    public function save_racing()
    {
        // Parametros POST
        $racetrack  =   $this->input->post('ID_de_Sucursal', true);

        // En primer lugar se valida el id de sucursal,
        // debido a que los nombres de zip trabajan con él.
        if( !isset($racetrack) || empty($racetrack) || !is_numeric($racetrack) ) {
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(2);
        }

        // Obtener información
        $json   =   $this->upload_zip($racetrack);

        // Validar que contenga datos
        if(empty($json))
        {
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(2);
        }

        // Decode
        $decoded_json   =   (array)json_decode($json);

        // Validar que contenga la información necesaria
        if( (!isset($decoded_json['racingobjects']) || empty($decoded_json['racingobjects']) )
            || ( !isset($decoded_json['rounds']) || empty($decoded_json['rounds']) )
            || ( !isset($decoded_json['vehicles']) || empty($decoded_json['vehicles']) )
            || ( !isset($decoded_json['drivers']) || empty($decoded_json['drivers']) )
        )
        {
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(2);
        }

        // Obtener cada entidad por independiente
        $racingobjects	=	$decoded_json['racingobjects'];
        $rounds			=	$decoded_json['rounds'];
        $vehicles		=	$decoded_json['vehicles'];
        $drivers		=	$decoded_json['drivers'];

        // Llamar a cada proceso
        $resp['vehicles']   =   $this->processing_vehicles($vehicles);
        $resp['races']      =   $this->processing_races($rounds, $racetrack);
        $resp['drivers']    =   $this->processing_drivers($drivers);
        $resp['laps']       =   $this->processing_laps($racingobjects, $drivers, $vehicles, $rounds, $racetrack);

        // Obtener todos los conductores
        $all_drivers = $this->drivers->get_all();

        // Actualizamos tiempos
        foreach($all_drivers as $key => $value)
        {
            $this->load->helper('laps_helper');
            update_durations($value->id_usuario);
        }

        // Actualizar ranking
        $this->ranking_model->nuevo_ranking();

        // Actualizar detalle ranking
        $this->ranking_model->nuevo_detalle_ranking();

        // Validación de respuesta
        if($resp['vehicles'] != false && $resp['races'] != false
            && $resp['drivers'] != false && $resp['laps'] != false)
        {
            $resp = 1;
        }
        else
        {
            $resp = 0;
        }

        // Se eliminan los archivos cargados
        $zipfile    = './temp/temp.zip';
        $jsonfile   = './temp/temp.json';
        
        if(file_exists($zipfile))
        {
            unlink($zipfile);    
        }
        
        if(file_exists($jsonfile))
        {
            unlink($jsonfile);
        }

        return $this->output
                    ->set_content_type('application/json')
                    ->set_output($resp);
    }

    /**
     * Guardar vehiculos nuevos en la base de datos
     *
     * @param $vehicles
     * @return bool
     */
    public function processing_vehicles($vehicles)
    {
        $response = true;

        foreach($vehicles as $key => $value) {
            // Si el vehiculo no existe en la base de datos, se crea.
            if($this->vehicles->validate($value->Number) < 1)
            {
                $insert 	=	$this->vehicles->insert_data($value);

                // Exito al insertar
                if($insert > 0) {
                    $this->log_ws->insert_data('exito', 'Éxito al crear vehiculo ' . $value->Number);
                }
                // Error al insertar
                else {
                    $this->log_ws->insert_data('error', 'Error al crear vehiculo ' . $value->Number);
                    $response = false;
                }
            }
        }

        return $response;
    }

    /**
     * Guardar carreras nuevas en la base de datos
     *
     * @param $rounds
     * @return bool
     */
    public function processing_races($rounds, $racetrack)
    {
        $response = true;

        foreach($rounds as $key => $value)
        {
            // Limpiar fecha
            $formated_time = $this->clear_time($value->Date);

            // Si la carrera no existe en la base de datos, se crea
            // se valida segun la fecha (formateada con anterioridad)
            if($this->racings->validate($formated_time) < 1) {
                $insert 	=	$this->racings->insert_data($value, $racetrack);

                // Exito al insertar
                if($insert > 0) {
                    $this->log_ws->insert_data('exito', 'Éxito al crear carrera ' . $value->Date);
                }
                // Error al insertar
                else {
                    $this->log_ws->insert_data('error', 'Error al crear carrera ' . $value->Date);
                    $response = false;
                }
            }
        }

        return $response;
    }

    /**
     * Guardar conductores nuevas en la base de datos
     *
     * @param $drivers
     * @return bool
     */
    public function processing_drivers($drivers)
    {
        $response = true;

        foreach($drivers as $key => $value) {
            // Si la conductor no existe en la base de datos, se crea
            // se valida segun la fecha (formateada con anterioridad)
            if($this->drivers->validate($value->firstName) < 1) {
                $insert 	=	$this->drivers->insert_data($value);

                // Exito al insertar
                if($insert > 0) {
                    $this->log_ws->insert_data('exito', 'Éxito al crear conductor ' . $value->firstName);
                }
                // Error al insertar
                else {
                    $this->log_ws->insert_data('error', 'Error al crear conductor ' . $value->firstName);
                    $response = false;
                }
            }
        }

        return $response;
    }

    /**
     * Limpiar el formato de tiempos
     * 
     * Se obtienen el tiempo en el formato de RaceManeger y se procesa para ser guardado en db
     * 
     * @param string $time
     * 
     * @return mixed
     */
    public function clean_new_time($time)
    {
        $time = str_replace('PT', '', $time);

        // Validar Hora
        if (strpos($time, 'H') !== false)
        {
            $hexp   =   explode('H', $time);

            if(isset($hexp[0]) && is_numeric($hexp[0]))
            {
                $hour   =   $hexp[0];
                $hour   =   (strlen($hour) == 1) ? '0'.$hour.':' : $hour.':';
            }
            else
            {
                $hour   =   '00:';
            }
        }
        else
        {
            $hexp[1]    =   $time;
            $hour       =   '00:';
        }

        $time   =   $hexp[1];

        // Validar minutos
        if(!isset($time) || empty($time) || !array_key_exists(1, $hexp) )
        {
            $minute =   '00:';
        }
        else
        {
            if (strpos($time, 'M') !== false)
            {
                $mexp   =   explode('M', $time);

                if(isset($mexp[0]) && is_numeric($mexp[0]))
                {
                    $minute     =   $mexp[0];
                    $minute     =   (strlen($minute) == 1) ? '0'.$minute.':' : $minute.':';
                }
                else
                {
                    $minute     =   '00:';
                }
            }
            else
            {
                $mexp[1]    =   $time;
                $minute     =   '00:';
            }
        }

        // Validar segundos
        $time   =   $mexp[1];

        if(!isset($time) || empty($time) || !array_key_exists(1, $mexp) )
        {
            $second =   '00.000';
        }
        else
        {
            if (strpos($time, 'S') !== false)
            {
                $sexp   =   str_replace('S', '', $time);

                if(isset($sexp) && is_numeric($sexp))
                {
                    $second     =   $sexp;
                    $second     =   (strlen($second) == 1) ? '0'.$second : $second;

                    $sexp       =   explode('.', $second);

                    if(array_key_exists(1, $sexp))
                    {
                        $second =   (strlen($sexp[0]) == 1) ? '0'. $sexp[0].'.'.$sexp[1] : $sexp[0].'.'.$sexp[1];
                    }
                    else
                    {
                        $second =   $second.'.000';
                    }
                }
                else
                {
                    $second     =   '00.000';
                }
            }
            else
            {
                $second   =   '00.000';
            }
        }

        $final_time =   $hour . $minute . $second;

        if(strtotime($final_time) <= strtotime('00:00:05.000'))
        {
            $final_time =   NULL;
        }

        return $final_time;

        /*$time = str_replace('S', '', $time);
        $expl_blp = explode('M', $time);

        if(array_key_exists(1, $expl_blp))
        {
            if(strlen($expl_blp[0]) == 1)
            {
                $minute = '0'.$expl_blp[0].':';
            }
            else
            {
                $minute = $expl_blp[0].':';
            }

            $exlp_sec = explode('.', $expl_blp[1]);

            if(strlen($exlp_sec[0]) == 1)
            {
                $second = '0'.$exlp_sec[0].'.'.$exlp_sec[1];
            }
            else
            {
                $second = $exlp_sec[0].'.'.$exlp_sec[1];
            }

            $time = '00:'.$minute.$second;
        }
        else
        {
            $exlp_sec = explode('.', $expl_blp[0]);

            if(strlen($exlp_sec[0]) == 1)
            {
                $second = '0'.$exlp_sec[0].'.'.$exlp_sec[1];
            }
            else
            {
                $second = $exlp_sec[0].'.'.$exlp_sec[1];
            }

            $time = '00:'.$second;
        }

        return $time;*/
    }

    /**
     * Guardar vueltas nuevas en la base de datos
     *
     * @param $passings
     * @param $racingobjects
     * @return bool
     */
    public function processing_laps($racingobjects, $drivers, $vehicles, $rounds, $racetrack)
    {
        $response   =   true;
        $laps       =   array();

        foreach ($racingobjects as $k => $v)
        {
            // Validar Vehiculo
            if(isset($v->FK_Vehicle) && !empty($v->FK_Vehicle))
            {
                foreach($vehicles as $vk => $vv)
                {
                    if($vv->id == $v->FK_Vehicle)
                    {
                        $vehicle_id = $this->vehicles->get_id_by_name($vv->Number);
                    }
                }
            }

            // Validar Carrera
            if(isset($v->FK_Round) && !empty($v->FK_Round))
            {
                foreach($rounds as $rk => $rv)
                {
                    if($rv->id == $v->FK_Round)
                    {
                        $racing_id = $this->racings->get_id_by_date($this->clear_time($rv->Date));
                    }
                }
            }

            // Validar Conductor
            if(isset($v->FK_Driver) && !empty($v->FK_Driver))
            {
                foreach($drivers as $dk => $dv)
                {
                    if($v->FK_Driver == $dv->id)
                    {
                        $card = str_replace('.', '', $dv->firstName);
                        $card = str_replace('-', '', $card);
                        $driver_id = $this->drivers->get_by_card($card);
                        $driver_id = (array_key_exists(0, $driver_id)) ? $driver_id[0] : $driver_id;
                        $driver_id = (isset($driver_id->id_usuario) && !empty($driver_id->id_usuario)) ? $driver_id->id_usuario : null;
                    }
                }
            }

            if(isset($v->bestLap) && !empty($v->bestLap) && isset($v->totalTime) && !empty($v->totalTime))
            {
                $best_lap = $this->clean_new_time($v->bestLap);
                $duration = $this->clean_new_time($v->totalTime);

                $laps[]   =   array(
                    'time'       => (isset($best_lap) && !empty($best_lap)) ? $best_lap : null,
                    'duration'   => (isset($duration) && !empty($duration)) ? $duration : null,
                    'position'   => null,
                    'laps'       => (isset($v->Laps) && !empty($v->Laps)) ? $v->Laps : null,
                    'id_carrera' => (isset($racing_id) && !empty($racing_id)) ? $racing_id : null,
                    'id_karting' => (isset($vehicle_id) && !empty($vehicle_id)) ? $vehicle_id : null,
                    'id_usuario' => (isset($driver_id) && !empty($driver_id)) ? $driver_id : null,
                    'id_pista'   => (isset($racetrack) && !empty($racetrack)) ? $racetrack : null
                );

                /* PROCESO ANTERIOR
                 $laps   =   array(
                    'time'       => (isset($best_lap) && !empty($best_lap)) ? $best_lap : null,
                    'duration'   => (isset($duration) && !empty($duration)) ? $duration : null,
                    'position'   => null,
                    'laps'       => (isset($v->Laps) && !empty($v->Laps)) ? $v->Laps : null,
                    'id_carrera' => (isset($racing_id) && !empty($racing_id)) ? $racing_id : null,
                    'id_karting' => (isset($vehicle_id) && !empty($vehicle_id)) ? $vehicle_id : null,
                    'id_usuario' => (isset($driver_id) && !empty($driver_id)) ? $driver_id : null,
                );
                

                $insert = $this->laps->insert_data($laps);

                // Exito al insertar
                if($insert > 0) {
                    $this->log_ws->insert_data('exito', 'Éxito al crear vuelta ' . $v->bestLap);
                }
                // Error al insertar
                else {
                    $this->log_ws->insert_data('error', 'Error al crear vuelta ' . $v->bestLap);
                    $response = false;
                }
                 */
            }
        }

        if(isset($laps) && !empty($laps))
        {
            $this->db->insert_batch('laps', $laps);
            $response = true;
        }
        else
        {
            $response = false;
        }

        return $response;
    }

    /**
     * Mostrar lo que se envía al server vía POST
     * 
     * @return array
     */
    public function pruebas_post()
    {
        print_r($_POST);
    }
}