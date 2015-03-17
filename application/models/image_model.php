<?php

class Image_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function upload($artist, $path, $image_name)
    {
        $this->db->set('name',$image_name);
        $this->db->set('url',$path);
        $this->db->set('author',$artist);
        $this->db->insert('image');
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_all ()
    {
        $this->db->select('image.id, image.url, image.name, image.author, author.name as author_name');
        $this->db->from('image');
        $this->db->join('author', 'image.author = author.id');

        $this->db->order_by("author.name", "asc");
        $this->db->order_by("image.name", "asc");

        $query = $this->db->get();


        return $query->result();
    }

    public function get_image_by_id ($id)
    {

        $this->db->order_by("author", "desc");
        $query = $this->db->get_where('image',array('id'=>$id));
        $row = $query->row();

        return $row;
    }


    public function remove ($id)
    {
        $this->db->delete('image', array('id' => $id));
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function exhibitions_by_image($id_image)
    {
        $this->db->select('exhibition.id, exhibition.name' );
        $this->db->from('exhibition');
        $this->db->join('imageexhibition', 'exhibition.id = imageexhibition.exhibition');

        $this->db->where('image', $id_image);

        $query = $this->db->get();

        return $query->result();
    }

    public function add_image_to_exhibition($image,$exhibition)
    {
        $this->db->set('image',$image);
        $this->db->set('exhibition',$exhibition);

        $this->db->insert('imageexhibition');

        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function remove_exhibitions($image_id)
    {
        $this->db->delete('imageexhibition', array('image' => $image_id));
        if ($this->db->affected_rows()> 0)
        {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function select_all_from_imageexhibition()
    {
        $this->db->from("imageexhibition");
        $this->db->order_by("image", "asc");
        $query = $this->db->get();
        return $query->result();
    }

}