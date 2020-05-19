<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->model('misanuncios_model');

    }

    function index(){
        $misanuncios = $this->misanuncios_model->obtenerMisAnuncios();
       $data = array('misanuncios' => $misanuncios);
        $this->load->view('modules/headers');
        $this->load->view('modules/menu');
        $this->load->view('mis-anuncios', $data);
      
    }
}

?>