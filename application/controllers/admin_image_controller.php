<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Image_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->model('admin_image_model');
    }



    function index(){

        $operation_type = $this->input->post('operation_type');

        $artist=$this->input->post('image_author');
        $image_name=$this->input->post('image_name');
        $image=$this->input->post('image_dir');

        /* Let's first create the folder where we should put the file in, if
		 * it exists. The folder is something like:
		 * application/uploads/artist/image
		 */
        echo $artist;
        echo $image_name;
        $paths = array('./application/uploads/' . $artist . '/');
        $paths [1] = $paths [0] . '/' ;

        foreach ($paths as $path)
        {
            if (!is_dir($path))
            {
                mkdir($path);
            }
        }
        //$this->admin_image_model->upload($artist,$paths,$image_name);


        /* The files will be stored with a timestamp for their name so we can
		 * know the ones that were uploaded first.
		 */
        date_default_timezone_set("UTC");
        $config['upload_path'] = $paths['1'];
        //$config['filename'] = $image;
        $config['allowed_types'] = 'jpg|png';
        $config['file_name'] = date("YmdHis");
        $config['max_size'] = 1024;

        $this->load->library('upload', $config);

        $context['$image_author'] = $artist;
        $context['image_name'] = $image_name;
        $this->load->view('admin_image_view',$context);

    }



}