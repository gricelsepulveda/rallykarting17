<?php

class Racings_model extends CI_Model
{
	private $table	=	'carreras';

	public function __construct()
	{
		parent::__construct();
	}

	public function validate($date)
	{
		$this->db->from($this->table)->where('date', $date);
		return $this->db->count_all_results();
	}

	public function count_racing_by_driver($driver)
	{
		$query = $this->db
					->select('count(distinct(l.racing_id)) as total', false)
					->from('carreras c')
					->join('laps l', 'r.id = l.racing_id')
					->where('l.driver_id', $driver)
					->get();
		return (array_key_exists(0, $query->result())) ? $query->result()[0]->total : false;
	}

	public function get_id_by_xml($id_xml)
	{
		$query = $this->db->where('id_xml', $id_xml)->get($this->table);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   return $row->id_carrera;
		} else {
			return false;
		}
	}

	public function get_id_by_date($date)
	{
		$query = $this->db->where('date', $date)->get($this->table);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   return $row->id_carrera;
		} else {
			return false;
		}
	}

	/**
	 * Insertar nuevos registros
	 * 
	 * @param object $value 
	 * @param integener $racetrack 
	 * @return integer
	 */
	public function insert_data($value, $racetrack)
	{
		if(isset($value->Date) && !empty($value->Date)) {
			$date = $this->clear_time($value->Date);	
		} else {
			$date = null;
		}
		
		if(isset($value->registeredDate) && !empty($value->registeredDate)) {
			$registered = $this->clear_time($value->registeredDate);	
		} else {
			$registered = null;
		}

		if(isset($value->startedDate) && !empty($value->startedDate)) {
			$started = $this->clear_time($value->startedDate);	
		} else {
			$started = null;
		}

		if(isset($value->finishedDate) && !empty($value->finishedDate)) {
			$finished = $this->clear_time($value->finishedDate);	
		} else {
			$finished = null;
		}

		if(isset($value->firstPass) && !empty($value->firstPass)) {
			$first = $this->clear_time($value->firstPass);	
		} else {
			$first = null;
		}

		$insert	=	array(
			'id_xml'			=>	(isset($value->id) && !empty($value->id)) ? $value->id : null,
			'date'				=>	(isset($date) && !empty($date)) ? $date : null,
			'duration'			=>	(isset($value->Duration) && !empty($value->Duration)) ? $value->Duration : null,
			'length'			=>	(isset($value->Length) && !empty($value->Length)) ? $value->Length : null,
			'lengthunit'		=>	(isset($value->lengthUnit) && !empty($value->lengthUnit)) ? $value->lengthUnit : null,
			'mode'				=>	(isset($value->Mode) && !empty($value->Mode)) ? $value->Mode : null,
			'number'			=>	(isset($value->Number) && !empty($value->Number)) ? $value->Number : null,
			'registereddate'	=>	(isset($registered) && !empty($registered)) ? $registered : null,
			'starteddate'		=>	(isset($started) && !empty($started)) ? $started : null,
			'finisheddate'		=>	(isset($finished) && !empty($finished)) ? $finished : null,
			'firstpass'			=>	(isset($first) && !empty($first)) ? $first : null,
			'id_pista'			=>	(isset($racetrack) && !empty($racetrack)) ? $racetrack : null,
		);

		$this->db->insert($this->table, $insert);

		return $this->db->affected_rows();
	}

	public function clear_time($time)
	{
		if(isset($time) && !empty($time)) {
			$replace_T		=	str_replace('T', ' ', $time);
			$replace_str	=	str_replace('-03:00', '', $replace_T);

			return $replace_str;
		}
		else {
			return null;
		}
	}

	public function get_driver_races($driver)
	{
		$query = $this->db
					->from('carreras c')
					->join('laps l', 'c.id_carrera = l.id_carrera')
					->where('l.id_usuario', $driver)
					->order_by('l.time', 'asc')
					->get();

		return $query->result();
	}

	public function get_last_in_progress()
	{
		$query 	=	$this->db->where('en_curso', 1)->get($this->table);
		$result =	$query->result();

		if(count($result) > 0)
		{
			$end = end($result);
			return $end;
		}
		else
		{
			return false;
		}

		return false;		
	}
}