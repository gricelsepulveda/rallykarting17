<?php

class Ranking_model extends CI_Model
{

	protected $table_ranking	=	'ranking';
	protected $table_detalle	=	'detalle_ranking';
	
	public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene las mejores puntuaciones de los usuarios y vuelca la información en la tabla de ranking
     *
     * @return     boolean
     */
    public function nuevo_ranking()
    {
    	$query = $this->db
		    			->select('laps.id_usuario, MIN(laps.time) as time, laps.id_pista', false)
		    			->where('laps.time IS NOT NULL', null, false)
		    			->where('laps.duration IS NOT NULL', null, false)
		    			->where('laps.id_usuario IS NOT NULL', null, false)
		    			->where('laps.laps IS NOT NULL', null, false)
		    			->where('laps.id_pista IS NOT NULL', null, false)
		    			->group_by(array('laps.id_usuario', 'laps.id_pista'))
		    			->order_by('id_pista ASC, time ASC')
		    			->get('laps');

		$result	=	$query->result();

		if(sizeof($result))
		{
			// Vaciar tabla de ranking
			$this->db->truncate($this->table_ranking);

			$counter = 1;
			$used	 = 1;

			foreach($result as $k => $v)
			{
				if( $used != $v->id_pista ) {
					$used 	 = $v->id_pista;
					$counter = 1;
				}

				$insert = array(
					'id_usuario'	=>	$v->id_usuario,
					'posicion'		=>	$counter,
					'id_pista'		=>	$v->id_pista
				);

				$this->db->insert($this->table_ranking, $insert);

				$counter++;
			}

			return true;
		}
		else
		{
			return false;
		}
    }

    public function nuevo_detalle_ranking()
    {
    	/*$query = $this->db
		    			->select('laps.id_usuario as usuario, laps.duration as duration, laps.id_carrera as carrera', false)
		    			->select('(SELECT COUNT(*) FROM laps as l1 WHERE l1.id_carrera = carrera AND l1.id_usuario = usuario) as total_vueltas', false)
		    			->select('(SELECT sec_to_time(sum(time_to_sec(l2.duration)) + sum(microsecond(l2.duration))/1000000) FROM laps as l2 WHERE l2.id_carrera = carrera AND l2.id_usuario = usuario) as tiempo_total', false)
		    			->where('laps.duration IS NOT NULL', null, false)
		    			//->group_by('laps.id_usuario')
		    			->order_by('duration', 'ASC')
		    			->get('laps');*/
		$query = $this->db
		    			->select('laps.id_usuario as usuario, laps.time as duration, laps.id_carrera as carrera, id_pista', false)
		    			->select('laps as total_vueltas')
		    			->select('duration as tiempo_total', false)
		    			->where('laps.duration IS NOT NULL', null, false)
		    			->where('laps.id_usuario IS NOT NULL', null, false)
		    			->where('laps.laps IS NOT NULL', null, false)
		    			->where('laps.id_pista IS NOT NULL', null, false)
		    			//->group_by('laps.id_usuario')
		    			->order_by('id_pista ASC, time ASC')
		    			->get('laps');

		$result	=	$query->result();

		if(sizeof($result))
		{
			
			// Proceso con validacion de duplicidad
			$this->db->truncate($this->table_detalle);

			foreach($result as $k => $v)
			{
				// Por seguridad, validamos que ningun dato a insertar este vacio
				// La tabla de detalle no admite campos nulos
				if(!empty($v->usuario)
					&& !empty($v->duration)
					&& !empty($v->total_vueltas)
					&& !empty($v->tiempo_total) )
				{
					// Validar si existe registro en tabla detalle
					$this->db
						->from($this->table_detalle)
						->where('id_usuario',$v->usuario)
						->where('mejor_tiempo', $v->duration)
						->where('total_vueltas', $v->total_vueltas)
						->where('tiempo_total', $v->tiempo_total);

					// Si no se encuentra registro, se inserta
					if($this->db->count_all_results() == 0)
					{
						$insert = array(
								'id_usuario'	=>	$v->usuario,
								'mejor_tiempo'	=>	$v->duration,
								'total_vueltas'	=>	$v->total_vueltas,
								'tiempo_total'	=>	$v->tiempo_total,
								'id_pista'		=>	$v->id_pista
							);

						$this->db->insert($this->table_detalle, $insert);
					}
				}
			}

			return true;
			
			/*
			// Proceso sin validacion de duplicidad
			$this->db->truncate($this->table_detalle);

			$counter = 1;
			foreach($result as $k => $v)
			{
				if(!empty($v->usuario)
					&& !empty($v->duration)
					&& !empty($v->total_vueltas)
					&& !empty($v->tiempo_total) )
				{
					$insert = array(
							'id_usuario'	=>	$v->usuario,
							'mejor_tiempo'	=>	$v->duration,
							'total_vueltas'	=>	$v->total_vueltas,
							'tiempo_total'	=>	$v->tiempo_total,
						);

					$this->db->insert($this->table_detalle, $insert);

					$counter++;
				}
			}

			return true;*/
		}
		else
		{
			return false;
		}
    }


    /**
     * Obtener posición del usuario en el ranking
     *
     * @param      integer  $id_usuario  ID de usuario
     *
     * @return     mixed
     */
    public function posicion($id_usuario)
    {
        $this->db->select('*')
                    ->from($this->table_ranking)
                    ->where('id_usuario', $id_usuario);        

        $query = $this->db->get();
        $usuario = $query->result();

        return (array_key_exists(0, $usuario)) ? $usuario[0]->posicion : false;
    }

}