<?php
if(!function_exists('update_durations'))
{
    function update_durations($driver_id)
    {
        $CI =& get_instance();

        $user_races = $CI->racings->get_driver_races($driver_id);        
        $times = array();

        // Sacar los tiempos
        foreach($user_races as $key => $value)
        {
            array_push($times, $value->time);
        }

        $t = 0;

        // Obtener diferencias de tiempos y si es necesario, guardarlos en db
        foreach($times as $key => $value)
        {
            if($key < 1) {
                $t = $value;
            }
            else {
                // Se hace query debido a que en PHP en ocasiones estaba generando problemas
                $query = $CI->db->query("SELECT TIMEDIFF('$value', '$t') as DIFF", false);

                $result = $query->result();
                $result = (array_key_exists(0, $result)) ? $result[0] : $result;

                $duration = $result->DIFF;
                $CI->laps->update_duration($value, $duration);
            }

            $t = $value;
        }
    }
}