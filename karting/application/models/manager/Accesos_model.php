<?php

class Accesos_model extends CI_Model {

    public function __construct()
    {                
        parent::__construct();                
    }

    /********* PRINCIPALES CRUD *****************/    
    
    // Listado de menus
    public function listar_menus()
    {
        $this->db->select('*')
                 ->from('menus')
                 ->where('activo',1)      
                 ->where('padre',0)
                 ->order_by('orden','ASC');             
        $query = $this->db->get();
        $menus = $query->result(); 
        return $menus;
    }

    // Listado de Registros
    public function listar_accesos($offset='',$cuantos='',$orden,$busqueda)
    {
        $this->db->select('*')
                 ->from('accesos');
        if ($orden){
            $orden = explode("-",$orden);
            $this->db->order_by($orden[0]." ".$orden[1]);
        }
        if ($cuantos){
            $this->db->limit($cuantos,$offset);
        }  
        if ($busqueda){
            $this->db->like('nombre',$busqueda)
                     ->or_like('apellidos',$busqueda)
                     ->or_like('correo',$busqueda);
        }
        $query = $this->db->get();
        $accesos = $query->result(); 
        return $accesos;
    }

    // Agrego un registro
    public function agregar($data)
    {
        $mensaje = array(); 

        if ( (!$data["nombre"]) || (!$data["apellidos"]) || (!$data["correo"]) || (!$data["clave"]) )
        {
            $mensaje["texto"]   = "Error: Ingrese todos los campos.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }  
        $this->db->select('*')
                 ->from('accesos')
                 ->where('correo',$data["correo"]);
        $query = $this->db->get(); 

        if (sizeof($query->result())>0)
        {
            $mensaje["texto"]   = "El registro ingresado ya existe.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }            
        else 
        {               
            if (isset($data["administrador"]))
            {
               unset($data["menu"]);  
            }               
            if (isset($data["menu"]))
            {
                $permisos = $data["menu"];
                unset($data["menu"]);                                            
            }                                
            $data["clave"] = md5($data["clave"]);
            $this->db->insert('accesos', $data);
            $id_acceso = $this->db->insert_id();                
            if (isset($permisos))
            {
               for ($i=0; $i < sizeof($permisos); $i++) 
                { 
                    $dataPermisos = array(
                       'id_menu'    =>$permisos[$i],
                       'id_acceso'  => $id_acceso
                    );
                    $this->db->insert('rel_menus_accesos', $dataPermisos);
                }
            }               

            $mensaje["texto"]   = "El Registro fue ingresado correctamente.";
            $mensaje["tipo"]    = "Aviso";            
            return $mensaje;
        }
        
    }

    // Edito un registro
    public function traer_registro($id)
    {
        $this->db->where('id_acceso', $id);
        $this->db->from('accesos');
        $query  = $this->db->get();             
        $acceso = $query->result(); 
        return $acceso[0];
    }

    // Elimino un registro
    public function eliminar($id)
    {
        // Valido que no sea el único administrador general
        $this->db->where('id_acceso', $id);
        $this->db->from('accesos');
        $query = $this->db->get(); 
        if (sizeof($query->result())>0)
        {
            $usuario = $query->result();                           
            if ($usuario[0]->administrador==1)
            {                    
                $this->db->where('administrador', '1')
                         ->where_not_in('id_acceso',$id)
                         ->from('accesos');
                $total = $this->db->count_all_results();                    
                if ($total==0)
                {
                    $mensaje["texto"] = "Debe existir al menos un administrador general.";
                    $mensaje["tipo"] = "Error";                
                    return $mensaje;
                }
            }
        }           
                 
        $this->db->where('id_acceso', $id);
        $this->db->delete('rel_menus_accesos');
        $this->db->where('id_acceso', $id);
        $this->db->delete('accesos');
        $mensaje["texto"] = "El Registro fue eliminado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }       

    // Actualizo el registro
    public function actualizar($id,$data)
    {
        // Valido que no sea el único administrador general            
        if (!isset($data["administrador"]))
        {
            $this->db->where('id_acceso', $id);
            $this->db->from('accesos');
            $query = $this->db->get(); 
            if (sizeof($query->result())>0)
            {
                $usuario = $query->result();                           
                if ($usuario[0]->administrador==1)
                {                    
                    $this->db->where('administrador', '1')
                                ->where_not_in('id_acceso',$id)
                                ->from('accesos');
                    $total = $this->db->count_all_results();                    
                    if ($total==0)
                    {
                        $mensaje["texto"] = "Debe existir al menos un administrador general.";
                        $mensaje["tipo"] = "Error";                
                        return $mensaje;
                    }
                }
            }    
        } 
   
        $this->db->where('correo', $data["correo"])->where_not_in('id_acceso',$id);
        $this->db->from('accesos');
        $query = $this->db->get(); 
        if (sizeof($query->result())>0)
        {
            $mensaje["texto"]   = "El registro ingresado ya existe.";
            $mensaje["tipo"]    = "Error";                
            return $mensaje;
        }                
        
        if ( (!$data["nombre"]) || (!$data["apellidos"]) || (!$data["correo"]) )
        {
            $mensaje["texto"]   = "Error: Ingrese todos los campos.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }                
        
        $dataUsuario = array(
                'nombre'        => $data["nombre"],                                        
                'apellidos'     => $data["apellidos"],                                        
                'correo'        => $data["correo"],                                        
                'observaciones' => $data["observaciones"]                    
        );                                
        $this->db->where('id_acceso', $id);
        $this->db->update('accesos', $dataUsuario);            

        $this->db->where('id_acceso', $id);
        $this->db->delete('rel_menus_accesos');

        if (isset($data["administrador"]))
        {
           $this->db->where('id_acceso', $id);
           $this->db->update('accesos', array('administrador' => $data["administrador"]));      
        }
        else 
        {
            $this->db->where('id_acceso', $id);
            $this->db->update('accesos', array('administrador' => 0));         
            if (isset($data["menu"]))
            {
                $permisos = $data["menu"];
                if (isset($permisos))
                {
                   for ($i=0; $i < sizeof($permisos); $i++) 
                    { 
                        $dataPermisos = array(
                           'id_menu'    =>$permisos[$i],
                           'id_acceso'  => $id
                        );
                        $this->db->insert('rel_menus_accesos', $dataPermisos);
                    }
                }               
            }

        }
        
        if (!$data["clave"]=='')
        {
           $this->db->where('id_acceso', $id);
           $this->db->update('accesos', array('clave' => md5($data["clave"])));      
        }
       
        $mensaje["texto"] = "El Registro fue Actualizado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }

    /********* METODOS ESPECIALES *****************/    

    // Login de accesos
    public function validar_login($data)
    {           
       if (trim($data["correo"]==''))   {die();}
       if (trim($data["clave"]==''))    {die();}

       $mensaje = '';
       $this->db->select('*')
                    ->from('accesos')
                    ->where('correo',$data["correo"])
                    ->limit(1);
        $query      = $this->db->get();
        $usuario    = $query->result();

        // Verifico Clave
        if (sizeof($usuario))
        {
            if (md5($data["clave"])==$usuario[0]->clave) 
            {
               $dataUsuario = array(
                        'nombre'        => $usuario[0]->nombre." ".$usuario[0]->apellidos,                                        
                        'id_acceso'     => $usuario[0]->id_acceso,                                      
                        'administrador' => $usuario[0]->administrador,                                      
                        'logged_in'     => TRUE
                );                                
                $this->db->set('ultimo_acceso', date('Y-m-d H:i:s'))
                         ->where('id_acceso',$usuario[0]->id_acceso)
                         ->update('accesos');
                $this->session->set_userdata($dataUsuario);                                
                redirect('manager/panel');                              
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

    // Envio Clave
    public function enviar_clave($data)
    {
        if (trim($data["correo"]=='')){die();}
        $mensaje='';
        $this->db->select('*')
                 ->from('accesos')
                 ->where('correo',$data["correo"])
                 ->limit(1);
        $query = $this->db->get();
        $usuario = $query->result();

        if (sizeof($usuario))
        {
            $this->load->library('encrypt');
            $clave          = random_string('alnum', 8);
            $correo         = $usuario[0]->correo;
            $nombre         = $usuario[0]->nombre." ".$usuario[0]->apellidos;
            $id_acceso      = $usuario[0]->id_acceso;
            $dataUpdate     = array('clave' => md5($clave));
            $this->db->where('id_acceso', $id_acceso);
            $this->db->update('accesos', $dataUpdate); 

            // Envío el correo            
            $this->load->library('email');             
            $nombre_web = traer_config('Nombre Sitio Web');
            $correo_web = traer_config('Correo Contacto');
            $this->email->from($correo_web,$nombre_web);
            $this->email->to($correo);
            $this->email->subject("Nueva clave de acceso a $nombre_web");
            $this->email->set_mailtype('html');
            $texto ="<h4>Estimad@ $nombre.</h4>".
                    "Le informamos que su nueva clave de acceso a su centro de control es $clave<br>".
                    "<br>".
                    "<small>Atte. Equipo $nombre_web</small>";            
            $this->email->message($texto);
            $this->email->send();                
            $mensaje ="Una nueva clave ha sido enviada a su correo $correo";       

            //TODO: Validar en servidor
            //echo $this->email->print_debugger();

        } else 
        {
            $mensaje ="El correo no se encuentra ingresado.";
        }

        return $mensaje;
    }

    // Listos menu de usuario
    public function listar_menus_usuario($id_acceso)
    {   
        // Verifico el nivel del usuario
        $this->db->select('*')
                ->from('accesos')                     
                ->where('id_acceso',$id_acceso);                     
        $query  = $this->db->get();
        $acceso = $query->result();  

        if ($acceso[0]->administrador)
        {
            // Administrador
            // Obtengo los menús padres
            $this->db->select('*')
                    ->from('menus')                     
                    ->where('activo',1)                     
                    ->where('id_padre',0)                     
                    ->order_by('orden','ASC');                     
            $query  = $this->db->get();
            $padres = $query->result();             

            // Creo un array con los menus
            for ($i=0; $i < sizeof($padres); $i++) 
            { 
                // Agrego al Padre
                $menus[] = array(
                    'nombre'    => $padres[$i]->nombre, 
                    'metodo'    => $padres[$i]->metodo,
                    'id_padre'  => $padres[$i]->id_padre
                );
                // Busco los hijos
                 $this->db->select('*')
                        ->from('menus')                     
                        ->where('activo',1)                     
                        ->where('id_padre',$padres[$i]->id_menu)                     
                        ->order_by('orden','ASC');                     
                $query  = $this->db->get();
                $hijos  = $query->result();  
                //echo $this->db->last_query();
                for ($j=0; $j < sizeof($hijos); $j++) 
                { 
                    $menus[] = array(
                       'nombre'     => $hijos[$j]->nombre, 
                       'metodo'     => $hijos[$j]->metodo,
                       'id_padre'   => $hijos[$i]->id_padre
                    );
                }
                
            }
        } 
        else 
        {
            // Usuario Perfilado
            $this->db->select('*')
                     ->from('rel_menus_accesos')
                     ->join('menus','menus.id_menu = rel_menus_accesos.id_menu')
                     ->where('menus.activo',1)
                     ->where('rel_menus_accesos.id_acceso',$id_acceso)                     
                     ->order_by('menus.orden','ASC');                     
            $query = $this->db->get();
            $hijos = $query->result(); 
            for ($j=0; $j < sizeof($hijos); $j++) 
            { 
                    // Creo un array con los menus
                   $menus[] = array(
                      'nombre'      => $hijos[$j]->nombre, 
                      'metodo'      => $hijos[$j]->metodo,
                      'id_padre'    => $hijos[$j]->id_padre
                   );
            }  
        } 
        return $menus;
       
    }

    // Verifico acceso a un usuario / menu
    public function tiene_acceso($id_acceso,$id_menu)
    {
        $this->db->where('id_acceso', $id_acceso);
        $this->db->where('id_menu', $id_menu);
        $this->db->from('rel_menus_accesos');
        $query = $this->db->get();             
        $acceso = $query->result(); 
        if (isset($acceso[0]->id_rel_menu_acceso))
        {
            return true;
        }
        return false;
    }  
}

?>