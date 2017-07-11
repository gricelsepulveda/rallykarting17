<?php

class Vehicles_model extends CI_Model
{
	private $table	=	'kartings';

	public function __construct()
	{
		parent::__construct();
	}

	public function validate($number)
	{
		$this->db->from($this->table)
					->where('nombre', $number);

		return $this->db->count_all_results();
	}

	public function get_id_by_name($name)
	{
		$query = $this->db->where('nombre', $name)->get($this->table);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   return $row->id_karting;
		} else {
			return false;
		}
	}

	public function get_id_by_xml($id_xml)
	{
		$query = $this->db->where('id_xml', $id_xml)->get($this->table);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   return $row->id_karting;
		} else {
			return false;
		}
	}

	public function insert_data($value)
	{
		$this->db
				->from($this->table)
				->where('nombre', $value->Number);

		if($this->db->count_all_results() == 0)
		{
			$insert	=	array(
					'id_xml'		=>	(isset($value->id) && !empty($value->id)) ? $value->id : null,
					'nombre'			=>	(isset($value->Number) && !empty($value->Number)) ? $value->Number : null,
					'transmitter'	=>	(isset($value->Transmitter) && !empty($value->Transmitter)) ? $value->Transmitter : null,
					'active'		=>	(isset($value->Active) && !empty($value->Active)) ? $value->Active : null
				);

			$this->db->insert($this->table, $insert);
		}

		return $this->db->affected_rows();
	}
}