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

    public function add_artist()
    {
        $context = [];

        if ($this->session->userdata('username'))
        {
            $context['logged_in'] = TRUE;
        }
        else
        {
            $context['wrong_credentials'] = TRUE;
        }

        $validation_rules = array(
            array('field' => 'artist_name',
                'label' => '',
                'rules' => 'required'),
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run() === TRUE)
        {
            $artist_name = $this->input->post('artist_name');

            $this->artist_model->add_artist($artist_name);
            //$context['artist added'] = TRUE;
        }
        else
        {
            //$context['error adding artist'] = TRUE;
        }
		
            // Deberias llamar a form_validation antes de hacer nada, por temas de seguridad entre otras cosas.
            // Coge como ejemplo la vista. Ademas, no tiene sentido coger la lista de artistas ANTES DE eliminar a
            // uno porque entonces vas a seguir mostrando un artista que ya has eliminado.
            //
            //$id = $this->input->post('id');

            //$this->artist_model->remove_artist($id);

            $artist_names =  $this->artist_model->select_all();
            $form_names = [];
            foreach ($artist_names->result() as $item) {
                $form_names[$item->id] = $item->name;
            }
            $context['form_names'] = $form_names;
		
		
         $this->load->view('artist_view', $context);
           
    }
    
}