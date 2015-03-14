<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Artist_Controller extends CI_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('artist_model');
    }

    public function index()
    {
        $context = [];
        $operation_type = $this->input->post('operation_type');

        if ($this->session->userdata('username'))
        {
            $context['logged_in'] = TRUE;
        }
        else
        {
            $context['wrong_credentials'] = TRUE;
        }


        if ($operation_type === 'add')
        {
            $validation_rules = array(
                array('field' => 'artist_name',
                'label' => '',
                'rules' => 'required'),
            );

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() === TRUE) {
                $artist_name = $this->input->post('artist_name');

                if($this->artist_model->add_artist($artist_name)) {
                    $context['artist_added'] = TRUE;
                }
            } else {
                $context['error_adding_artist'] = TRUE;
            }
        }

        if ($operation_type === 'remove')
        {
            $validation_rules = array(
                array('field' => 'id',
                    'label' => '',
                    'rules' => 'required'),
            );

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() === TRUE) {
                $id = $this->input->post('id');
                if($this->artist_model->remove_artist($id)) {
                    $context['artist_removed'] = TRUE;
                }
            }else{
                $context['error_removing_artist'] = TRUE;
            }

        }

        $artist_names = $this->artist_model->select_all();
        $form_names = [];

        foreach ($artist_names->result() as $item)
        {
            $form_names[$item->id] = $item->name;
        }
        $context['form_names'] = $form_names;

        $this->load->view('artist_view', $context);
           
    }
    
}