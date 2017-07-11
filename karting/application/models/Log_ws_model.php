<?php

class Log_ws_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert_data($estado, $descripcion)
	{
		$insert	=	array(
					'estado'		=>	$estado,
					'descripcion'	=>	$descripcion
				);

		$this->db->insert('log_ws', $insert);

		return $this->db->affected_rows();
	}
}