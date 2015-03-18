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
        $this->load->model('image_model');
        $this->load->model('artist_model');
        $this->load->model('exhibition_model');
    }

    function exhibition ($image_id)
    {
        $context = [];
        $context ['id'] = $image_id;
        $operation_type = $this->input->post('operation_type');

        /* Credentials test */

        if ($this->session->userdata('username'))
        {
            $context['logged_in'] = TRUE;
        }
        else
        {
            return;
        }


        /* check if image exists on database */
    if ( $this->image_model->get_image_by_id($image_id) === null){
        return;

    }
        $image_name = $this->image_model->get_image_by_id($image_id);
        $context['image_name'] = $image_name->name;

        /* Get exhibitions where a image is displayed */

        $exhibitions = $this->image_model->exhibitions_by_image($image_id);

        /* Add image to exhibitions */

        if ($operation_type === 'select') {
            $validation_rules = array(
                array('field' => 'exhibitions[]',
                    'label' => '',
                    'rules' => 'required'),
            );

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() === TRUE) {
                $exhibitions = $this->input->post('exhibitions[]');

                /* check that the db is not empty with exhibitions_by_image */
                if ($this->image_model->exhibitions_by_image($image_id) != null) {

                    if ($this->image_model->remove_exhibitions($image_id)) {
                        foreach ($exhibitions as $exhibition) {
                            $this->image_model->add_image_to_exhibition($image_id, $exhibition);
                        }
                        $exhibitions = $this->image_model->exhibitions_by_image($image_id);
                    }
                } else {
                    foreach ($exhibitions as $exhibition) {
                        $this->image_model->add_image_to_exhibition($image_id, $exhibition);
                    }
                    $exhibitions = $this->image_model->exhibitions_by_image($image_id);
                }
            }
        }
        $form_ids = [];

        foreach ($exhibitions as $item)
        {
            $form_ids[$item->id] = $item->id;
        }

        $context['selected_exhibitions'] = $form_ids;


        /**/


        /* options of the multiselect dropdown */


        $exhibition_name = $this->exhibition_model->select_all();
        $form_exhibitions = [];

        foreach ($exhibition_name as $item)
        {
            $form_exhibitions[$item->id] = $item->name;
        }

        $context['exhibitions'] = $form_exhibitions;



        $this->load->view('image_exhibition_view', $context);


    }

    function index()
    {
        $context = [];
        $operation_type = $this->input->post('operation_type');

        /* Credentials test */

        if ($this->session->userdata('username'))
        {
            $context['logged_in'] = TRUE;
        }
        else
        {
            //$context['wrong_credentials'] = TRUE;
            return;
        }

        if ($operation_type === 'upload') {
            $validation_rules = array(
                array('field' => 'image_author',
                    'label' => '',
                    'rules' => 'required'),
                array('field' => 'image_name',
                    'label' => '',
                    'rules' => 'required'),

            );

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() === TRUE) {

                $artist = $this->input->post('image_author');
                //$image_name = $this->input->post('image_name');

                /* Let's first create the folder where we should put the file in, if
                 * it exists. The folder is something like:
                 * application/uploads/artist/image
                 */

                $path = './application/uploads/' . $artist . '/';
                if (!is_dir($path)) {
                    mkdir($path);
                }



                /* The files will be stored with a timestamp for their name so we can
                 * know the ones that were uploaded first.
                 */

                $filename = str_replace(' ', '-', $this->input->post('image_name')); // Replaces all spaces with hyphens.
                $filename = preg_replace('/[^A-Za-z0-9\-]/', '', $filename); // Removes special chars.

                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png';
                $config['file_name'] = $filename ;
                $config['max_size'] = 1024;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload())
                {

                    /* get extension and add it to the file */
                    $extension = $this->upload->data()['file_ext'];

                    $full_path = $path . $filename . $extension;

                    /* Save the image into the db */
                    $this->image_model->upload($artist, $full_path, $this->input->post('image_name'));

                    echo "file upload success";

                } else {
                    echo $this->upload->display_errors();
                }
            }
        }

        /* remove image from db and storage */

        if ($operation_type === 'remove')
        {

            $validation_rules = array(
                array('field' => 'show_image_name',
                    'label' => '',
                    'rules' => 'required'),
            );

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() === TRUE)
            {
                $id = $this->input->post('show_image_name');

                /*removing from local*/

                $image = $this->image_model->get_image_by_id($id);
                //\var_dump($image);
                unlink($image->url);

                /*removing from db */

                if($this->image_model->remove($id)) {
                    //$context['image_removed'] = TRUE;
                    echo ('success');
                }
            }else{
                //$context['error_removing_image'] = TRUE;
                echo ('fail');
            }

            echo validation_errors();
        }



        /* dropdown of upload */

        $artist_names = $this->artist_model->select_all();
        $form_names = [];

        foreach ($artist_names as $item)
        {
            $form_names[$item->id] = $item->name;
        }

        $context['form_names'] = $form_names;

        /* dropdown of delete and for select image and exhibition */

        $images_name = $this->image_model->select_all();
        $form_images = [];

        foreach ($images_name as $item)
        {
            $form_images[$item->id] = $item->author_name . ': ' . $item->name  ;
        }

        $context['form_images'] = $form_images;

        //\var_dump($form_images);
        $this->load->view('image_view',$context);

    }
}