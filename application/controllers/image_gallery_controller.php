<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Image_Gallery_Controller extends CI_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('image_model');
        $this->load->model('exhibition_model');
        $this->load->model('artist_model');
    }

    function gallery ($id_image)
    {
        /* Get image from directory */

        /* first we get the URL */
        $image = $this->image_model->get_image_by_id($id_image);

        /* OJO AQUÍ, en principio parece que no hace falta comprobar la extensión del fichero
         * pero CUIDADO
         */

        $this->output
            ->set_content_type('jpg|png') // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
            ->set_output(file_get_contents( $image->url));
    }

    public function index()
    {
        // we are going to store data from the database in this array
        // image, exhibition, author and imageexhibition


        /*
         * BORRAR ESTO
         *
         * $images = $this->image_model->select_all();

        $form_image = [];

        foreach ($images->result() as $item)
        {
            $form_image[$item->id] = $item->name;
        }

        echo \var_dump($form_image);*/

        $data = array(
            'images' => $this->image_model->select_all(),
            'authors' => $this->artist_model->select_all(),
            'expositions' => $this->exhibition_model->select_all(),
            'image_expositions' => $this->image_model->select_all_from_imageexhibition()
        );


        echo \var_dump($data);

        /* Make $data be able to be understand by javascript */

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));

    }


}