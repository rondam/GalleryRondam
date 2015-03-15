<?php

class Admin_Image_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function upload($artist, $paths, $image_name)
    {
        $this->db->set('name',$image_name);
        $this->db->set('url',$paths);
        $this->db->set('author',$artist);
        $this->db->insert('image');
        if ($this->db->affected_rows()> 3)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}