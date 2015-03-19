<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comment_Controller extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('comment_model');
    }

    function add_comment ($image_id){
        if ($this->input->post('name') && $this->input->post('comment')) {
           $this->comment_model->add($image_id, $this->input->post('name'), $this->input->post('comment'));
        }
    }

    function index ($image_id){
        /* sería para leer los comentarios */
        $comments= $this->comment_model->get_by_id($image_id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($comments));

    }

}