<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Generate_Manifest extends CI_Controller
{
    public function __construct()
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

    public function index(){


        $result = ("CACHE MANIFEST\n");
        $result .= ("#rev 2\n");
        $result .= ("../../mystyle.css\n");
        $result .= ("../../js/angular/angular.js\n");
        $result .= ("../../js/GalleryController.js\n");
        $result .= ("image_gallery_controller\n");
        $result .= ("../../themes/curiosity_killed.min.css\n");
        $result .= ("../../themes/jquery.mobile.icons.min.css\n");
        $result .= ("../../themes/images/ajax-loader.gif\n");
        $result .= ("http://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css\n");
        $result .= ("http://code.jquery.com/jquery-1.11.1.min.js\n");
        $result .= ("http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js\n");

        $images = $this->image_model->select_all();
        foreach ($images as $image) {
            $result .= ("image_gallery_controller/thumbnail/" . $image->id . "\n");
        }

        $result .= ("NETWORK:\n");
        $result .= ("*\n");


        $this->output->set_content_type('text/cache-manifest')->set_output($result);
    }

}