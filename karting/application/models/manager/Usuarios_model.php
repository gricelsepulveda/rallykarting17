<?php

class Usuarios_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }        



    /********* PRINCIPALES CRUD *****************/



    // Obtengo el listado de registros
    public function listar_usuarios($offset='',$cuantos='',$orden,$busqueda)
    {

        $this->db->select('*')

                 ->from('usuarios');

        if ($orden){

            $orden = explode("-",$orden);

            $this->db->order_by($orden[0]." ".$orden[1]);

        }

        if ($cuantos){

            $this->db->limit($cuantos,$offset);

        }  

        if ($busqueda){

            $this->db->like('nombre',$busqueda);

            $this->db->or_like('rut',$busqueda);

            $this->db->or_like('correo',$busqueda);

            $this->db->or_like('telefono',$busqueda);

        }            

        $query = $this->db->get();            

        //echo $this->db->last_query();

        $usuarios = $query->result(); 

        return $usuarios;

    }    

    

    // Agrego un registro
    public function agregar($data)
    {
        $mensaje = array();

        // Verifico que existan los campos principales
        if (!$data["nombre"])
        {
            $mensaje["texto"]   = "Error: Ingrese todos los campos.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }
        else
        {
            // Agrego la data
            $data["rut"] = str_replace(".","",$data["rut"]);
            $data["rut"] = str_replace("-","",$data["rut"]);

            // Verifico que no exista
            if (!Usuarios_model::validar_existe_usuario($data["rut"], $data["correo"]))
            {
                $mensaje["texto"]   = "Error: El Usuario Ingresado ya Existe."; 
                $mensaje["tipo"]    = "Error";
                return $mensaje;
            }

            $datausuario = array(
                "nombre"    => $data["nombre"],
                "clave"     => md5($data["clave"]),
                "rut"       => $data["rut"],
                "correo"    => $data["correo"],
                "telefono"  => $data["telefono"]
            );

            $this->db->insert('usuarios', $datausuario);  

            $mensaje["texto"]   = "El Registro fue ingresado correctamente.";
            $mensaje["tipo"]    = "Aviso";

            return $mensaje;
        }
    }



    // Traer un registro        

    public function traer_registro($id)

    {

        $this->db->where('id_usuario', $id)->from('usuarios');                

        $query = $this->db->get();             

        $usuario = $query->result(); 

        if ($usuario){

            return $usuario[0];    

        }

        else {

            return null;

        }        

    }    



    // Actualizo un registro        

    public function actualizar($id,$data)

    {

       if  (!$data["nombre"])

        {

            $mensaje["texto"] = "Error: Ingrese todos los campos.";

            $mensaje["tipo"] = "Error";

            return $mensaje;

        }    

        // Actualizo el registro

        $data["rut"] = str_replace(".","",$data["rut"]);

        $data["rut"] = str_replace("-","",$data["rut"]);

        $datausuario = array(

                "nombre"    => $data["nombre"] ,                    

                "rut"       => $data["rut"],                        

                "correo"    => $data["correo"],

                "telefono"  => $data["telefono"]

        );                                

        $this->db->where('id_usuario', $id);

        $this->db->update('usuarios', $datausuario);

        if (!$data["clave"]=='')

        {

           $this->db->where('id_usuario', $id);

           $this->db->update('usuarios', array('clave' => md5($data["clave"])));      

        }           



        $mensaje["texto"] = "El Registro fue Actualizado correctamente.";

        $mensaje["tipo"] = "Aviso";                



        return $mensaje;

    }



    // Elimino un registro        

    public function eliminar($id)

    {

        // Elimino el registro               

        

        $this->db->where('id_usuario', $id);

        $this->db->delete('usuarios');

        $mensaje["texto"] = "El Registro fue eliminado correctamente.";

        $mensaje["tipo"] = "Aviso";                



        return $mensaje;

    }  



    // Obtengo el nombre de una usuario

    public function nombre_usuario($id)

    {

        $data = usuarios_model::traer_registro($id); 

        $nombre = 'Usuario Eliminado';                       

        if (!(NULL==($data)))

        {

            $nombre = $data->nombre;

        } 

        return $nombre;

    }

    /**
     * Obtener rut del usuario
     *
     * @param      Integer  $id     Id de usuario
     *
     * @return     string
     */
    public function rut_usuario($id)
    {
        $data = usuarios_model::traer_registro($id);
        $nombre = 'Usuario Eliminado';

        if (!(NULL==($data)))
        {
            $nombre = $data->rut;
        }

        return $nombre;
    }

    /**
     * Validar que un usuario exista
     *
     * @param      integer   $rut     rut del usuario
     * @param      string   $correo  email del usuariu
     *
     * @return     boolean
     */
    public function validar_existe_usuario($rut, $correo)
    {
        //$this->db->where('rut', $rut)->or_where('correo', $correo)->from('usuarios');
        $this->db->where('rut', $rut)->from('usuarios');
        $query = $this->db->get();
        $usuario = $query->result();

        if(NULL==$usuario)
        {
            return true;
        }

        return false;
    }


    // Agrego un registro desde web
    public function agregar_usuario_web($data)
    {
        $mensaje = array();

        // Verifico que existan los campos principales
        if ( !$data["nombre"]  || !$data["rut"] || !$data["correo"])
        {
            $mensaje    =   "Error: Ingrese todos los campos.";
            return $mensaje;
        }
        else
        {
            $data["rut"] = str_replace(".","",$data["rut"]);
            $data["rut"] = str_replace("-","",$data["rut"]);

            // Verifico que no exista
            if (!Usuarios_model::validar_existe_usuario($data["rut"],$data["correo"]))
            {
                $mensaje  = "Error: El Usuario Ingresado ya Existe.";
                return $mensaje;
            }

            // Agrego la data
            $datausuario = array(
                "nombre"    => $data["nombre"],
                "correo"    => $data["correo"],
                "rut"       => $data["rut"],
                "telefono"  => $data["telefono"]
            );

            $this->db->insert('usuarios', $datausuario);
            $mensaje  = "El Registro fue ingresado correctamente.";

            $id_usuario = $this->db->insert_id();

            // Creo una clave
            $this->load->library('encrypt');
            $clave          = random_string('alnum', 8);
            $correo         = $data["correo"];
            $nombre         = $data["nombre"];

            $dataUpdate     = array('clave' => md5($clave));

            $this->db->where('id_usuario', $id_usuario);
            $this->db->update('usuarios', $dataUpdate); 

            // Envío el correo
            /*$this->load->library('email');
            $nombre_web = traer_config('Nombre Sitio Web');
            $correo_web = traer_config('Correo Contacto');
            $this->email->from($correo_web,$nombre_web);
            $this->email->to($correo);
            $this->email->subject("Nueva clave de acceso a $nombre_web");
            $this->email->set_mailtype('html');

            $texto ="<h4>Estimad@ $nombre.</h4>".

                    "Le informamos que su nueva clave de acceso es $clave<br>".

                    "<br>".

                    "<small>Atte. Equipo $nombre_web</small>";            

            $this->email->message($texto);
            $this->email->send();*/

            return $mensaje;
        }
    }

    // Valido el acceso del controlador
    public function validar_login($data)
    {
        if (trim($data["rut"]==''))   {$mensaje = "Datos de acceso incorrectos."; return $mensaje;}
        //if (trim($data["clave"]==''))    {$mensaje = "Datos de acceso incorrectos."; return $mensaje;}

        $data["rut"] = str_replace("'","",$data["rut"]);
        $data["rut"] = str_replace(".","",$data["rut"]);

        $mensaje = '';

        $this->db->select('*')
                    ->from('usuarios')
                    ->where('rut',$data["rut"])
                    ->limit(1);

        $query      = $this->db->get();

        $usuario    = $query->result();

        // Verifico Clave
        if (sizeof($usuario))
        {
	   
		//Si esta variable es verdadera, entonces significa que el usuario deberá completar sus datos.
		$redireccionarAlRegistro = false;
		
		//Verificar si el nombre es igual al rut
		if($usuario[0]->nombre == $usuario[0]->rut)
		{
			$redireccionarAlRegistro = true;
		}
		
		//Verificar que el correo no este vacio
		if($usuario[0]->correo == "" || strlen($usuario[0]->correo) == 0)
		{
			$redireccionarAlRegistro = true;
		}
		
		//Validación Registro VS login
		if($redireccionarAlRegistro)
		{
			setcookie("rutUsuarioRK", $usuario[0]->rut, time()+3600);		
			setcookie("idUsuarioRK", $usuario[0]->id_usuario, time()+3600);
			redirect('inicio/registro/','refresh');
		}
		else
		{
			$datausuario = array(
			'nombre'                    => $usuario[0]->nombre,
			'id_usuario'                => $usuario[0]->id_usuario,
			'logged_usuario_in'         => TRUE
			); 

			$this->session->set_userdata($datausuario);
			redirect('ranking');
		}
	   
	   
	   

            /*
            //if (md5($data["clave"])==$usuario[0]->clave)
            if ($data["clave"] == $usuario[0]->correo)
            {
                // Clave correcta
                $datausuario = array(
                    'nombre'                    => $usuario[0]->nombre,
                    'id_usuario'                => $usuario[0]->id_usuario,
                    'logged_usuario_in'         => TRUE
                ); 

                $this->session->set_userdata($datausuario);
                redirect('ranking');
            }
            else
            {
                $mensaje = "Datos de acceso incorrectos.";
            }*/
        }
        else
        {	   
            $mensaje ="El Rut no se encuentra ingresado.";
        }

        return $mensaje;
    }

    public function actualiza_usuario($data){
    
    
    			$data = array(
			'id_usuario'		=>	$this->input->post('idUsuarioRK'),
			'nombre'			=>	$this->input->post('nombre'),
			'correo'			=>	$this->input->post('email'),
			'telefono'		=>	$this->input->post('telefono')
			);
			
			$id_usuario = $data['id_usuario'];
			
			$update = array(
						'nombre' 		=> $data['nombre'], 
						'correo' 		=> $data['correo'],
						'telefono' 	=> $data['telefono']);
						

			//Actualiza info
			$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuarios', $update);
			
			//Hacer login automatico
			$this->validar_login(array('rut' => $_COOKIE["rutUsuarioRK"]));
			
			
    }


    // Obtengo el ranking
    public function listar_ranking()
    {
        $this->db->select('*')->from('ranking');
        $this->db->order_by('posicion','ASC');
        $this->db->limit(25); // agregado por normeno
        $query = $this->db->get();
        $ranking = $query->result();

        return $ranking;
    }

    /**
     * Obtener ranking según pista
     * 
     */
    public function ranking_by_racetrack($racetrack)
    {
        $this->db
            ->select('*')
            ->from('ranking')
            ->where('id_pista', $racetrack)
            ->order_by('posicion','ASC')
            ->limit(25);
        
        $query      =   $this->db->get();
        $ranking    =   $query->result();

        return $ranking;
    }

    // Obtengo el detalle de ranking
    public function detalle_ranking($id_usuario)
    {
        $this->db->select('*')
                    ->from('detalle_ranking')
                    ->where('id_usuario',$id_usuario)        
                    //->order_by('fecha','DESC')
                    ->order_by('mejor_tiempo','ASC')
                    ->limit(7);

        $query = $this->db->get();                    

        $detalle = $query->result(); 

        return $detalle;
    }

    /**
     * Información del usuario de la tabla detalle ranking según la pista
     * 
     * @author     Nicolas Ormeno <nicolas@youtouch.cl>
     * @param integer $id_usuario 
     * @return array
     */
    public function detalle_ranking_by_racetrack($user, $racetrack)
    {
        $this->db->select('*')
                    ->from('detalle_ranking')
                    ->where('id_usuario',$user)
                    ->where('id_pista', $racetrack)
                    ->order_by('mejor_tiempo','ASC')
                    ->limit(7);

        $query = $this->db->get();                    

        $detalle = $query->result(); 

        return $detalle;
    }



    // Obtengo el nombre de un usuario
    public function nombre($id_usuario)
    {
        $this->db->select('*')
                    ->from('usuarios')
                    ->where('id_usuario',$id_usuario);        

        $query = $this->db->get();
        $usuario = $query->result();

        return $usuario[0]->nombre;
    }



    // Recupero la clave
    public function recuperar_clave($data)
    {
        if (trim($data["rut"]=='')){$mensaje = "Debe ingresar su RUT.";return $mensaje;}

        $data["rut"] = str_replace("'","",$data["rut"]);

        $data["rut"] = str_replace(".","",$data["rut"]);

        $mensaje='';

        $this->db->select('*')

                 ->from('usuarios')

                 ->where('rut',$data["rut"])

                 ->limit(1);

        $query = $this->db->get();

        $usuario = $query->result();        



        if (sizeof($usuario))

        {

            $this->load->library('encrypt');

            $clave          = random_string('alnum', 8);

            $correo         = $usuario[0]->correo;

            $nombre         = $usuario[0]->nombre;

            $id_usuario     = $usuario[0]->id_usuario;

            $dataUpdate     = array('clave' => md5($clave));

            $this->db->where('id_usuario', $id_usuario);

            $this->db->update('usuarios', $dataUpdate); 



            // Envío el correo            

            $this->load->library('email');             

            $nombre_web = traer_config('Nombre Sitio Web');

            $correo_web = traer_config('Correo Contacto');

            $this->email->from($correo_web,$nombre_web);

            $this->email->to($correo);

            $this->email->subject("Nueva clave de acceso a $nombre_web");

            $this->email->set_mailtype('html');

            $texto ="<h4>Estimad@ $nombre.</h4>".

                    "Le informamos que su nueva clave de acceso es $clave<br>".

                    "<br>".

                    "<small>Atte. Equipo $nombre_web</small>";            

            $this->email->message($texto);

            $this->email->send();                

            $mensaje ="Una nueva clave ha sido enviada a su correo $correo";       



            //TODO: Validar en servidor

            //echo $this->email->print_debugger();



        } else 

        {

            $mensaje ="El rut no se encuentra ingresado.";

        }



        return $mensaje;

    }

}



?>