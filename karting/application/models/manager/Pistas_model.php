<?php

class Pistas_model extends CI_Model {

    public function __construct()
    {                
            parent::__construct();
            
    }        

    /********* PRINCIPALES CRUD *****************/

    // Obtengo el listado de registros        
    public function listar_pistas($offset='',$cuantos='',$orden,$busqueda)
    {
        $this->db->select('*')
                 ->from('pistas');
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
        $pistas = $query->result(); 
        return $pistas;
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
            if (!Pistas_model::validar_existe($data["nombre"]))
            {
                $mensaje["texto"]   = "Error: El Registro Ingresado ya Existe.";
                $mensaje["tipo"]    = "Error";
                return $mensaje;
            }
            // Agrego la data
            $datapista = array(    
                "nombre"        => $data["nombre"],
                "descripcion"   => $data["descripcion"]
            );
            $this->db->insert('pistas', $datapista);  
            $mensaje["texto"]   = "El Registro fue ingresado correctamente.";                        
            $mensaje["tipo"]    = "Aviso";               
            return $mensaje;
        }               
    }

    // Traer un registro        
    public function traer_registro($id)
    {
        $this->db->where('id_pista', $id)->from('pistas');                
        $query = $this->db->get();             
        $pista = $query->result(); 
        if ($pista){
            return $pista[0];    
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
        if (!Pistas_model::validar_existe($data["nombre"],$id))
        {
            $mensaje["texto"]   = "Error: El pista Ingresado ya Existe.";
            $mensaje["tipo"]    = "Error";
            return $mensaje;
        }
        // Actualizo el registro
        $datapista = array(
            "nombre"        => $data["nombre"],
            "descripcion"   => $data["descripcion"]
        );                                
        $this->db->where('id_pista', $id);
        $this->db->update('pistas', $datapista);
        
        $mensaje["texto"] = "El Registro fue Actualizado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }

    // Elimino un registro        
    public function eliminar($id)
    {
        // Elimino el registro               
        
        $this->db->where('id_pista', $id);
        $this->db->delete('pistas');
        $mensaje["texto"] = "El Registro fue eliminado correctamente.";
        $mensaje["tipo"] = "Aviso";                

        return $mensaje;
    }  

    // Obtengo el nombre de una pista
    public function nombre_pista($id)
    {
        $data = pistas_model::traer_registro($id);                        
        if (!(NULL==($data)))
        {
            $nombre = $data->nombre;
        } 
        return $nombre;
    }

    // Valido que no exista pista
    public function validar_existe($nombre,$id_excluir='')
    {
        $this->db->where('nombre', $nombre)->from('pistas');                   
        if ($id_excluir)
        {
            $this->db->where_not_in('id_pista',$id_excluir);
        }
        $query = $this->db->get();             
        $pista = $query->result(); 
        if (NULL==$pista)
        {
            return true;
        }
        return false;
    }

}

?>