<?php

class Vueltas_model extends CI_Model
{
    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->setTable();
    }

    private function setTable()
    {
        $this->table = 'laps l';
    }

    /********* PRINCIPALES CRUD *****************/

    /**
     * Obtener listado de registro
     * 
     * @param string $offset 
     * @param string $cuantos 
     * @param string $orden 
     * @param string $busqueda 
     * @return object
     */
    public function listar($offset='', $cuantos='', $orden, $busqueda)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $this->db->select('SUBSTRING(l.time, 1, 12) as time', null, false);
        $this->db->select('SUBSTRING(l.duration, 1, 12) as duration', null, false);
        $this->db->select('l.id as id_vuelta, u.nombre as usuario, p.nombre as pista');
        $this->db->from('laps l');
        $this->db->join('usuarios u', 'u.id_usuario = l.id_usuario');
        $this->db->join('pistas p', 'p.id_pista = l.id_pista');
        $this->db->where('l.time IS NOT NULL', null, false);
        $this->db->where('l.duration IS NOT NULL', null, false);
        $this->db->where('l.id_carrera IS NOT NULL', null, false);
        $this->db->where('l.id_karting IS NOT NULL', null, false);
        $this->db->where('l.id_usuario IS NOT NULL', null, false);
        $this->db->where('l.id_pista IS NOT NULL', null, false);

        if(!empty($orden)) {
            $orden = explode("-", $orden);
            $this->db->order_by($orden[0]." ".$orden[1]);
        }

        if ($cuantos){
            $this->db->limit($cuantos, $offset);
        }

        if ($busqueda) {
            $this->db->like('time', $busqueda);
            $this->db->or_like('duration', $busqueda);
            $this->db->or_like('u.nombre', $busqueda);
            $this->db->or_like('p.nombre', $busqueda);
        }

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    /**
     * Obtener un registro en particular
     * 
     * @param integer $id
     * 
     * @return integer
     */
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

    /**
     * Eliminar registro
     * 
     * @param integer $id 
     * @return array
     */
    public function eliminar($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('laps');

        $mensaje["texto"] = "El Registro fue eliminado correctamente.";
        $mensaje["tipo"] = "Aviso";

        return $mensaje;
    }
}



?>