<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('user');
    }

    public function login()
    {
        $context = [];

        if ($this->session->userdata('username'))
        {
            $context['logged_in'] = TRUE;
        }
        else
        {
            $validation_rules = array(
                array('field' => 'username',
                    'label' => '',
                    'rules' => 'required'),
                array('field' => 'password',
                    'label' => '',
                    'rules' => 'required'),
            );
            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() === TRUE)
            {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                if ($this->user->login($username, $password))
                {
                    $this->session->set_userdata(array('username' => $username));
                    $context['logged_in'] = TRUE;
                }
                else
                {
                    $context['wrong_credentials'] = TRUE;
                }
            }
        }

        $this->load->view('login', $context);
    }

    public function logout()
    {
        $context = [];
        if ($this->session->userdata('username'))
        {
            $this->session->sess_destroy();
            $context['logged_out'] = TRUE;
        }
        $this->load->view('login', $context);
    }
}