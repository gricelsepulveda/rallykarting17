<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('g'))
{
    // Obtengo valores de la tabla de parametros
    function traer_config($item)
    {   
        $ci =& get_instance();        
        $ci->db->select('valor')
                 ->from('configuraciones')
                 ->where('item',$item)
                 ->limit(1);
        $query = $ci->db->get();
        $param = $query->result();
        $valor= $param[0]->valor;

        return $valor;
    }

    
    // Muestra el contenido de un array formateado     
    function dump($var = '')
    {
        echo "<pre>";
        echo var_dump($var);
        echo "</pre>";
    }   

    // Busco un elemento en un array multidimensional    
    function in_multiarray($elem, $array)
    {
        foreach ($array as $key => $value) {
            
            foreach ($value as $key2 => $value2) {
                if ($value[$key2]==$elem)
                {
                    return true;
                }
            }
                
        }                  
        return false;
    }


    // Retorna el mimetype de un archivo
    function mimetype($fname) 
    {
        $fh=fopen($fname,'rb');
        if ($fh) { 
            $bytes6=fread($fh,6);
            fclose($fh); 
            if ($bytes6===false) return false;
            if (substr($bytes6,0,3)=="\xff\xd8\xff") return 'image/jpeg';
            if ($bytes6=="\x89PNG\x0d\x0a") return 'image/png';
            if ($bytes6=="GIF87a" || $bytes6=="GIF89a") return 'image/gif';
            return 'application/octet-stream';
        }
        return false;
    }

    // Sube archivos en base64
    function upload_base64($archivo)
    {
        // Elimino el tag de información 
        $file = str_replace('data:image/png;base64,', '', $archivo);
        $file = str_replace('data:image/jpeg;base64,', '', $file);
        $file = str_replace('data:application/pdf;base64,', '', $file);

        // Extraigo el nombre de archivo
        $dataUpload = base64_decode($file);

        // Valido las extensiones
        $ext ='';        
        $file = uniqid() . '.' . $ext;        
        $file_path = getcwd().DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR .$file;
        file_put_contents($file_path, $dataUpload); 
        $mime_type = mimetype($file_path);
       
        if ($mime_type=='image/png') $ext =  'png';
        if ($mime_type=='image/jpeg') $ext =  'jpg';                        
        if ($mime_type=='application/pdf') $ext =  'pdf'; 
        if ($mime_type=='application/octet-stream') $ext =  'pdf';         

        if (!$ext=='')
        {
            rename($file_path,$file_path.$ext);
            return $file.$ext;
        } 
        else
        {
            // Si no es es las extencions permitidas elimino el archivo
            unlink($file_path);
            return false;
        }         
    }  


    // Convierte una fecha en español a formato mysql     
     function date_to_mysql($fecha)
    {
        
        $fecha = explode("/",$fecha);
        $fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];
        return $fecha;
    }
    // Convierte una fecha en formato mysql aespañol      
     function mysql_to_date($fecha)
    {
        
        $fecha = explode("-",$fecha);
        $fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];
        return $fecha;
    }

    // Convierte una fecha completa en formato mysql aespañol      
     function mysql_to_date_complete($fecha)
    {
        $fecha_ = explode(" ",$fecha);
        $hora = $fecha_[1];
        $fecha = $fecha_[0];
        $fecha = explode("-",$fecha);
        $fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];
        return $fecha." ".$hora;;
    }

    // Creo el html para los metodos de ordenamiento del manager    
    function create_link_orden($campo,$base_path,$comienzo,$cuantos,$busqueda)
    {      
      echo "<a href='$base_path/listado/$comienzo/$cuantos/$campo-desc/$busqueda'>".
           "<span class='glyphicon glyphicon-chevron-down pull-right'></span></a>".
           "<a href='$base_path/listado/$comienzo/$cuantos/$campo-asc/$busqueda'>".
           "<span class='glyphicon glyphicon-chevron-up pull-right'></span></a>";
    }

    // Formateo el RUT
    function format_rut($rut)
    {
        if(is_numeric($rut))
            return number_format( substr ( $rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $rut, strlen($rut) -1 , 1 );
        else
            $rut;
    }
   
    
}