<?php

class Laps_model extends CI_Model
{
	private $table	=	'laps';

	public function __construct()
	{
		parent::__construct();
	}

	public function validate($time)
	{
		$this->db->from($this->table)->where('time', $time);
		return $this->db->count_all_results();
	}

	public function get_by_driver($driver)
	{
		$query = $this->db
			->select('distinct(l.racing_id)', false)
			->from('carreras c')
			->join('laps l', 'c.id_carrera = l.id_carrera')
			->where('l.driver_id', '2')
			->get();

		return ($query->result());
	}

	public function get_id_by_xml($id_xml)
	{
		$query = $this->db->where('id_xml', $id_xml)->get($this->table);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   return $row->id;
		} else {
			return false;
		}
	}

	public function insert_data($value)
	{
		$this->db->insert($this->table, $value);

		return $this->db->insert_id();
	}

	public function get_by_vehicle_and_racing($racing, $vehicle)
	{
		$query = $this->db
					->from($this->table)
					->where('racing_id', $racing)
					->where('vehicle_id', $vehicle)
					->order_by('id', 'ASC')
					->get();

		return $query->result();
	}

	public function update_duration($time, $duration)
	{
		$this->db
			->from($this->table)
			->where('time', $time)
			->where('duration IS NOT NULL', null, false);

		$count = $this->db->count_all_results();

		if($count < 1)
		{
			$data = array('duration' => $duration);

			$this->db->where('time', $time);
			$this->db->update($this->table, $data);
		}
	}

	public function get_bests_drivers($limit)
    {
        $query = $this->db
                    ->select('distinct(u.id_usuario), u.nombre')
                    ->join('usuarios u', "u.id_usuario = $this->table.id_usuario")
                    ->where('u.id_usuario IS NOT NULL', null, false)
                    ->order_by('duration', 'ASC')
                    ->limit($limit)
                    ->get($this->table);

        return $query->result();
    }
    
    public function get_bests_by_driver($driver, $limit)
    {
        $query = $this->db
            ->select("$this->table.*")
            ->select("u.nombre")
            ->join('usuarios u', "u.id_usuario = $this->table.id_usuario")
            ->where("$this->table.id_usuario", $driver)
            ->where("$this->table.duration IS NOT NULL", null, false)
            ->order_by("$this->table.duration", 'ASC', false)
            ->limit($limit)
            ->get($this->table);

        foreach($query->result() as $key => $value)
        {
            $value->total_laps = $this->all_laps_by_driver($value->racing_id, $driver);
            $value->total_time = $this->sum_times_by_driver($value->racing_id, $driver)->total;
        }

        return $query->result();
    }

    public function all_laps_by_driver($race, $driver)
    {
        $this->db->from($this->table)->where('racing_id', $race)->where('driver_id', $driver);
        return $this->db->count_all_results();
    }

    public function sum_times_by_driver($race, $driver)
    {
        $query = $this->db
                    ->select('sum(duration) as total', false)
                    ->from($this->table)
                    ->where('racing_id', $race)
                    ->where('driver_id', $driver)
                    ->get();

        $result = $query->result();

        return (array_key_exists(0, $result)) ? $result[0] : $result;
    }
}