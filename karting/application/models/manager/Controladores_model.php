<?php

class Controladores_model extends CI_Model {

    public function __construct()
    {                
            parent::__construct();
            
    }        

    /********* PRINCIPALES CRUD *****************/

    // Obtengo el listado de registros        
    public function listar_controladores($offset='',$cuantos='',$orden,$busqueda)
    {
        $this->db->select('*')
                 ->from('controladores');
        if ($orden){
            $orden = explode("-",$orden);
            $this->db->order_by($orden[0]." ".$orden[1]);
        }
        if ($cuantos){
            $this->db->limit($cuantos,$offset);
        }  
        if ($busqueda){
            $this->db->like('nombre',$busqueda);            
            $this->db->or_like('correo',$busqueda);            
        }            
        $query = $this->db->get();            
        //echo $this->db->last_query();
        $controladores = $query->result(); 
        return $controladores;
    }    
    
    
    //Agrego un registro
    public function agregar($data)
    {
        $mensaje = array();

        // Verifico que existan los campos principales
        if ( !$data["nombre"])
        {
            $mensaje["texto"]   = "Error: Ingrese todos los campos.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }  
        else
        {    

            // Verifico que no exista
            if (!Controladores_model::validar_existe($data["correo"]))
            {
                $mensaje["texto"]   = "Error: El Controlador Ingresado ya Existe.";
                $mensaje["tipo"]    = "Error";
                return $mensaje;
            }
            // Agrego la data
            $datacontrolador = array(    
                "nombre"    => $data["nombre"],
                "correo"    => $data["correo"],
                "clave"     => md5($data["clave"])
            );
            $this->db->insert('controladores', $datacontrolador);  

            $id_controlador = $this->db->insert_id();      

            // Agrego las pistas
            if (isset($data["pistas"]))
            {             
                for ($i=0; $i < sizeof($data["pistas"]); $i++) 
                { 
                    $datapistas = array(
                        'id_controlador' => $id_controlador,
                        'id_pista' => (int)$data["pistas"][$i]
                     );
                    $this->db->insert('rel_pistas_controladores',$datapistas);
                }
            }                           

            $mensaje["texto"]   = "El Registro fue ingresado correctamente.";                        
            $mensaje["tipo"]    = "Aviso";                                    

            return $mensaje;
        }               
    }

    // Traer un registro        
    public function traer_registro($id)
    {
        $this->db->where('id_controlador', $id)->from('controladores');                
        $query = $this->db->get();             
        $karting = $query->result(); 
        if ($karting){
            return $karting[0];    
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
        // Verifico que no exista
        if (!controladores_model::validar_existe($data["nombre"],$id))
        {
            $mensaje["texto"]   = "Error: El Karting Ingresado ya Existe.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }
        // Actualizo el registro
        $datacontrolador = array(
            "nombre"    => $data["nombre"],
            "correo"    => $data["correo"],
        ); 

        if (!$data["clave"]=='')
        {
           $this->db->where('id_controlador', $id);
           $this->db->update('controladores', array('clave' => md5($data["clave"])));      
        }  

        $this->db->where('id_controlador', $id);
        $this->db->update('controladores', $datacontrolador);

        // Actualizo las pistas  
        $this->db->where('id_controlador',$id);
        $this->db->delete('rel_pistas_controladores');      
        if (isset($data["pistas"]))
        {             
            
            for ($i=0; $i < sizeof($data["pistas"]); $i++) 
            { 
                $datapistas = array(
                    'id_controlador' => $id,
                    'id_pista' => (int)$data["pistas"][$i]
                 );
                $this->db->insert('rel_pistas_controladores',$datapistas);
            }
        }   
        
        $mensaje["texto"] = "El Registro fue Actualizado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }

    // Elimino un registro        
    public function eliminar($id)
    {
        // Elimino el registro               
        
        $this->db->where('id_controlador', $id);
        $this->db->delete('controladores');
        $mensaje["texto"] = "El Registro fue eliminado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }  

    // Obtengo el nombre de un controlador
    public function nombre_controlador($id)
    {
        $data = Controladores_model::traer_registro($id);                        
        if (!(NULL==($data)))
        {
            $nombre = $data->nombre;
        } 
        return $nombre;
    }

    // Valido que no exista controlador
    public function validar_existe($correo,$id_excluir='')
    {
        $this->db->where('correo', $correo)->from('controladores');                   
        if ($id_excluir)
        {
            $this->db->where_not_in('id_controlador',$id_excluir);
        }
        $query = $this->db->get();             
        $controlador = $query->result(); 
        if (NULL==$controlador)
        {
            return true;
        }
        return false;
    }   

    // Valido el acceso del controlador
    public function validar_login($data)
    {
       if (trim($data["correo"]==''))   {die();}
       if (trim($data["clave"]==''))    {die();}
       if (trim($data["pista"]==''))    {die();}

       $mensaje = '';
       $this->db->select('*')
                    ->from('controladores')
                    ->where('correo',$data["correo"])
                    ->limit(1);
        $query      = $this->db->get();
        $controlador    = $query->result();

        // Verifico Clave
        if (sizeof($controlador))
        {

            if (md5($data["clave"])==$controlador[0]->clave) 
            {
               // Clave correcta, valido pista            
                $this->db->select('*')
                         ->from('rel_pistas_controladores')
                         ->where('id_controlador',$controlador[0]->id_controlador)
                         ->where('id_pista',$data["pista"])
                         ->limit(1);
                $query = $this->db->get();
                $pista = $query->result();
                if (!sizeof($pista))
                {
                    $mensaje = "Controlador no tiene acceso a esta pista";
                }  
                else
                {
                   $datacontrolador = array(
                        'nombre'                    => $controlador[0]->nombre,                                        
                        'id_controlador'            => $controlador[0]->id_controlador,
                        'id_pista'                  => $data["pista"],
                        'logged_controlador_in'     => TRUE
                    ); 
                    $this->session->set_userdata($datacontrolador);                                
                    redirect('controlador/panel');                              
                }
            } 
            else 
            {
                $mensaje = "Datos de acceso incorrectos.";
            }
        } 
        else 
        {
            $mensaje ="El correo no se encuentra ingresado.";
        }
        
        return $mensaje ;
    }

    // Valido el acceso de usuarios y los asigno
    public function validar_asignar_usuario($data)
    {
        if (($data["rut"]=='null') || ($data["rut"]=='') )
        {
            redirect('controlador/asignacion');
        }

       $data["rut"] = str_replace(".","",$data["rut"]);
       $data["rut"] = str_replace("-","",$data["rut"]);
       $mensaje = '';
       
       $this->db->select('*')
                    ->from('usuarios')
                    ->where('rut',$data["rut"])
                    ->limit(1);
        $query      = $this->db->get();
        $usuario    = $query->result();
        
        // Si no existe el usuario, lo creamos
        if (!sizeof($usuario))
        {
            $newUser = array(
                'nombre'    =>  $data["rut"],
                'rut'       =>  $data["rut"]
            );
            
            $this->db->insert('usuarios', $newUser);

            $this->db->select('*')
                    ->from('usuarios')
                    ->where('rut', $data["rut"])
                    ->limit(1);

            $query      = $this->db->get();
            $usuario    = $query->result();
        }
        
        if (sizeof($usuario))
        {
            // Valido que no exista en la lista
            $this->db->select('*')
                    ->from('rel_usuarios_karting')
                    ->where('id_usuario', $usuario[0]->id_usuario)
                    ->where('id_carrera', $this->session->userdata('id_carrera_en_curso'))
                    ->limit(1);

            $query         = $this->db->get();
            $asignacion    = $query->result();

            if (!sizeof($asignacion) || count($asignacion) < 1)
            {                
                //Agrego a listado de jugadores en curso                
                $dataasginacion = array(
                    'id_usuario'     => $usuario[0]->id_usuario,
                    'id_carrera'     => $this->session->userdata('id_carrera_en_curso')
                );
                $this->db->insert('rel_usuarios_karting', $dataasginacion); 
            }

            redirect('controlador/asignacion');                                          
        } 
        else 
        {
            $mensaje ="El rut no se encuentra ingresado.";
        }
        
        return $mensaje ;
    }

    // Obtengo el listado de asignaciones        
    public function listar_asignaciones()
    {
        $this->db->select('*')
                 ->where('id_carrera',  $this->session->userdata('id_carrera_en_curso'))
                 ->from('rel_usuarios_karting');
        $query = $this->db->get();
        $asignaciones = $query->result();
        return $asignaciones;
    }    

    // Guardo las asignaciones
    public function guardar_asignaciones($data)
    {
        for ($i=0; $i < sizeof($data["id_karting"]); $i++) { 

            // valido que no exista la asignación
            if ($data["id_karting"][$i]>0)
            {
                $this->db->where('id_karting', $data["id_karting"][$i])
                         ->where('id_carrera',  $this->session->userdata('id_carrera_en_curso')) 
                         ->where_not_in('id_usuario',$data["id_usuario"][$i])                    
                         ->from('rel_usuarios_karting');
                $query = $this->db->get();             
                $existe = $query->result();                         
                if ($existe)
                {
                    $mensaje ="El Karting ya se encuentra asignado";
                    return $mensaje;
                }
            }
            $dataasginacion = array(
                "id_karting"    => $data["id_karting"][$i],
                "id_carrera"    => $this->session->userdata('id_carrera_en_curso')
            ); 
            $this->db->where('id_usuario', $data["id_usuario"][$i]);
            $this->db->update('rel_usuarios_karting', $dataasginacion); 
        }
    }

    // Verifico si una pista pertenece a un controlador
    public function controlador_pertenece_pista($id_controlador,$id_pista)
    {
        
        $this->db->where('id_controlador', $id_controlador)
                  ->where('id_pista', $id_pista)
                  ->from('rel_pistas_controladores');

        $query = $this->db->get();             
        $controlador = $query->result(); 
        //echo $this->db->last_query();  
        if (NULL==$controlador)
        {
            return false;
        }
        return true;
    }

    // creo una nueva carrera
    public function crear_carrera()
    {   
        if (!$this->session->userdata('id_carrera_en_curso'))
        { 
            // no existe carrera en curso
            $dataCarrera = array(
                'id_controlador'    => $this->session->userdata('logged_controlador_in'),
                'id_pista'          => $this->session->userdata('id_pista'),
                'en_curso'          => 1,
                'fecha'             => date("Y-m-d h:i:00")
            );            
            $this->db->insert('carreras', $dataCarrera);         
            $id = $this->db->insert_id();                    
            $datacarrera = array(
                'id_carrera_en_curso' => $id
            ); 
            $this->session->set_userdata($datacarrera);                      
            $q = $this->db->get_where('carreras', array('id_carrera' => $id));
            return $q->row();
        }         
    }

    // recupero la carrera en curso
    public function recuperar_carrera()
    {
        $this->db->where('id_controlador', $this->session->userdata('logged_controlador_in'))
                  ->where('id_pista', $this->session->userdata('id_pista'))
                  ->where('en_curso', 1)
                  ->from('carreras');
        $query = $this->db->get();             
        $carrera = $query->result();    
        if ($carrera){
            $datacarrera = array(
                'id_carrera_en_curso' => $carrera[0]->id_carrera
            ); 
            $this->session->set_userdata($datacarrera);      
            return $carrera;
        }
        else
        {
            return false;
        }        
    }

    // Finalizo una carrera
    public function finalizar_carrera()
    {
         $datacarrera = array(                
                "en_curso"      => 0
        ); 
        $this->db->where('id_carrera', $this->session->userdata('id_carrera_en_curso'));
        $this->db->update('carreras', $datacarrera); 

        $this->session->unset_userdata('id_carrera_en_curso');   
    }

}

?>