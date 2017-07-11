<?php

class Configuraciones_model extends CI_Model {

    /**
     * Nombre de la tabla principal a trabajar en el modelo
     * 
     * @var string
     */
    private $tableName = 'configuraciones';

    public function __construct()
    {                
            parent::__construct();                
    }

    /********* PRINCIPALES CRUD *****************/
    
    // Listado de registros
    public function listar_configuraciones($flag)
    {
        $this->db->select('*')
                 ->from('configuraciones')
                 ->where('privado',$flag);                       
        $query = $this->db->get();
        $configuraciones = $query->result(); 
        return $configuraciones;
    }
    

    // Obtengo un registro
    public function traer_registro($id)
    {
        $this->db->where('id_configuracion', $id);
        $this->db->from('configuraciones');
        $query      = $this->db->get();             
        $parametro  = $query->result(); 
        return $parametro[0];
    }

    /**
     * Obtener registro según el nombre del item
     * 
     * @author Nicolas Ormeno nicolas@youtouch.cl
     * @param string $item 
     * @return mixed
     */
    public function by_item($item)
    {
        $query = $this->db
                    ->where('item', $item)
                    ->get($this->tableName);             
        
        $item  = $query->result();
        
        return array_key_exists(0, $item) ? $item[0] : false;
    }

    // Actualizo un registro
    public function actualizar($id,$data)
    {
        if (!$data["valor"]){die();}
        // Actualizo el registro
        $dataUsuario = array(
                'valor'  => $data["valor"]
        );                                
        $this->db->where('id_configuracion', $id);
        $this->db->update('configuraciones', $dataUsuario);            
       
        $mensaje["texto"]   = "El Registro fue Actualizado correctamente.";
        $mensaje["tipo"]    = "Aviso";                

        return $mensaje;
    }
}

?>