<?php

class Drivers_model extends CI_Model
{
 	private $table = 'usuarios';

	public function __construct()
	{
		parent::__construct();
	}

	public function get_all()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

	public function validate($card)
	{
		$this->db->from($this->table)->where('rut', $card);
		return $this->db->count_all_results();
	}

	public function get_by_card($card)
	{
		$query = $this->db->where('rut', $card)->get($this->table);

		return (array_key_exists(0, $query->result())) ? $query->result()[0] : false;
	}

	public function get_by_id($id)
	{
		$query = $this->db->where('id', $id)->get($this->table);

		return (array_key_exists(0, $query->result())) ? $query->result()[0] : false;
	}

	public function get_id_by_xml($id_xml)
	{
		$query = $this->db->where('id_xml', $id_xml)->get($this->table);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   return $row->id_usuario;
		} else {
			return false;
		}
	}

	public function insert_data($value)
	{
		$name 	=	$value->firstName . ' ' . $value->lastName;

		$insert	=	[
					'id_xml'		=>	(isset($value->id) && !empty($value->id)) ? $value->id : null,
					'correo'		=>	(isset($value->Email) && !empty($value->Email)) ? $value->Email : null,
					'nombre'		=>	$name,
					'postcode'		=>	(isset($value->postCode) && !empty($value->postCode)) ? $value->postCode : null,
					'city'			=>	(isset($value->City) && !empty($value->City)) ? $value->City : null,
					'dateofbirth'	=>	(isset($value->dateOfBirth) && !empty($value->dateOfBirth)) ? $value->dateOfBirth : null,
					'gender'		=>	(isset($value->Gender) && !empty($value->Gender)) ? $value->Gender : null,
					'newsletter'	=>	(isset($value->Newsletter) && !empty($value->Newsletter)) ? $value->Newsletter : null,
					'rut'			=>	(isset($value->firstName) && !empty($value->firstName)) ? $value->firstName : null,
				];

		$this->db->insert($this->table, $insert);

		return $this->db->affected_rows();
	}
}