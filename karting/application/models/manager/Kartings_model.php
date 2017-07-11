<?php

class Kartings_model extends CI_Model {

    public function __construct()
    {                
            parent::__construct();
            
    }        

    /********* PRINCIPALES CRUD *****************/

    // Obtengo el listado de registros        
    public function listar_kartings($offset='',$cuantos='',$orden,$busqueda)
    {
        $this->db->select('*')
                 ->from('kartings');
        if ($orden){
            $orden = explode("-",$orden);
            $this->db->order_by($orden[0]." ".$orden[1]);
        }
        if ($cuantos){
            $this->db->limit($cuantos,$offset);
        }  
        if ($busqueda){
            $this->db->like('nombre',$busqueda);            
        }            
        $query = $this->db->get();            
        //echo $this->db->last_query();
        $kartings = $query->result(); 
        return $kartings;
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
            if (!Kartings_model::validar_existe($data["nombre"]))
            {
                $mensaje["texto"]   = "Error: El Karting Ingresado ya Existe.";
                $mensaje["tipo"]    = "Error";
                return $mensaje;
            }
            // Agrego la data
            $datakarting = array(    
                "nombre"    => $data["nombre"]
            );
            $this->db->insert('kartings', $datakarting);  
            $mensaje["texto"]   = "El Registro fue ingresado correctamente.";                        
            $mensaje["tipo"]    = "Aviso";                                    

            return $mensaje;
        }               
    }

    // Traer un registro        
    public function traer_registro($id)
    {
        $this->db->where('id_karting', $id)->from('kartings');                
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
        if (!Kartings_model::validar_existe($data["nombre"],$id))
        {
            $mensaje["texto"]   = "Error: El Karting Ingresado ya Existe.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }
        // Actualizo el registro
        $datakarting = array(
            "nombre"    => $data["nombre"]
        );                                
        $this->db->where('id_karting', $id);
        $this->db->update('kartings', $datakarting);
        
        $mensaje["texto"] = "El Registro fue Actualizado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }

    // Elimino un registro        
    public function eliminar($id)
    {
        // Elimino el registro               
        
        $this->db->where('id_karting', $id);
        $this->db->delete('kartings');
        $mensaje["texto"] = "El Registro fue eliminado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }  

    // Obtengo el nombre de una karting
    public function nombre_karting($id)
    {
        $data = Kartings_model::traer_registro($id);                        
        if (!(NULL==($data)))
        {
            $nombre = $data->nombre;
        } 
        return $nombre;
    }

    // Valido que no exista karting
    public function validar_existe($nombre,$id_excluir='')
    {
        $this->db->where('nombre', $nombre)->from('kartings');                   
        if ($id_excluir)
        {
            $this->db->where_not_in('id_karting',$id_excluir);
        }
        $query = $this->db->get();             
        $karting = $query->result(); 
        if (NULL==$karting)
        {
            return true;
        }
        return false;
    }

}

?>