<?php

class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function login($username, $password)
    {
        $this->db->where('user', $username);
        $query = $this->db->get('users');
        if ($query->num_rows() === 1) {
            $row = $query->row();
            if (password_verify($password, $row->password)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return false;
    }
}