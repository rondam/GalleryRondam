<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Exhibition_Controller extends CI_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('exhibition_model');
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
                array('field' => 'exhibition_name',
                    'label' => '',
                    'rules' => 'required'),
            );

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() === TRUE) {
                $exhibition_name = $this->input->post('exhibition_name');

                if($this->exhibition_model->add_exhibition($exhibition_name)) {
                    $context['exhibition_added'] = TRUE;
                }
            } else {
                $context['error_adding_exhibition'] = TRUE;
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
                if($this->exhibition_model->remove_exhibition($id)) {
                    $context['exhibition_removed'] = TRUE;
                }
            }else{
                $context['error_removing_exhibition'] = TRUE;
            }

        }

        $exhibition_names = $this->exhibition_model->select_all();
        $form_names = [];

        foreach ($exhibition_names as $item)
        {
            $form_names[$item->id] = $item->name;
        }
        $context['form_names'] = $form_names;

        $this->load->view('exhibition_view', $context);

    }

}