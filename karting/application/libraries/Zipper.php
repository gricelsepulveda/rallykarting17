<?php
/**
 * Class Zipper
 * @author Nicolas Ormeno <ni.ormeno@gmail.com>
 * @version 1.0
 */
class Zipper
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->library('zipper');
        $this->ci->load->helper('file');
    }
    
    /**
     * Create zip and add files
     *
     * If zip not exist, then create zip and add files
     *
     * @param $path string
     * @param $files array
     * @return bool
     */
    public function create($path, $files)
    {
        if(!file_exists($path) && !empty($files)) {
            $zip = \Comodojo\Zip\Zip::create($path);
            $zip->add($files);
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * Add files to zip
     *
     * @param $path string
     * @param $files array
     * @throws \Comodojo\Exception\ZipException
     */
    public function add($path, $files)
    {
        $zip = \Comodojo\Zip\Zip::open($path);
        $zip->add($files);
    }

    public function unzip_all($zip_path, $unzip_path, $delete_zip = false, $delete_files = false)
    {
        if(!file_exists($zip_path) || !file_exists($unzip_path))
        {
            return array('status' => 0, 'message' => 'Error in file path');
        }
        
        $zip = \Comodojo\Zip\Zip::open($zip_path);
        
        if($zip->extract($unzip_path))
        {
            return array('status' => 1, 'message' => 'Success');
        }
        else
        {
            return array('status' => 0, 'message' => 'Failed to uncompress file');
        }
    }
}