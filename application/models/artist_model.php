<?php

class Artist_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_artist($artist_name)
    {
        $this->db->set('name',$artist_name);
        $this->db->insert('Author');
    }

    public function select_all ()
    {
        $query = $this->db->get('author');
        return $query;
    }
    public function remove_artist($id)
    {
        $this->db->delete('Author', array('id' => $id)); 
        /*if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }*/


    }
}