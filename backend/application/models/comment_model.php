<?php

class Comment_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    public function get_by_id ($image_id)
    {
        $this->db->order_by("date", "asc");
        $query = $this->db->get_where('comment',array('image'=>$image_id));

        return $query->result();

    }

    public function add ($image_id, $name, $text)
    {
        $this->load->helper('date');
        $this->db->set('name', $name);
        $this->db->set('text', $text);
        $this->db->set('image', $image_id);
        $this->db->set('date', date('Y-m-d H:i:s',now()));

        $this->db->insert('comment');
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}