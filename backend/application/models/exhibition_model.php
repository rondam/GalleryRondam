<?php

class Exhibition_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_exhibition($exhibition_name)
    {
        $this->db->set('name',$exhibition_name);
        $this->db->insert('exhibition');
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_all ()
    {
        $this->db->from("exhibition");
        $this->db->order_by("name", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    public function remove_exhibition($id)
    {
        $this->db->delete('exhibition', array('id' => $id));
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}