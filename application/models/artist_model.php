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
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_all ()
    {
        $this->db->from("author");
        $this->db->order_by("name", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    public function remove_artist($id)
    {
        $this->db->delete('Author', array('id' => $id)); 
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}