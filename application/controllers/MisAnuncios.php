<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->model('misanuncios_model');
        $this->load->model('anuncio_model');

    }

    function index(){
        $misanuncios = $this->misanuncios_model->obtenerMisAnuncios();
       $data = array('misanuncios' => $misanuncios);
        $this->load->view('modules/headers');
        $this->load->view('modules/menu');
        $this->load->view('mis-anuncios', $data);      
    }

    function ver($anuncio_id = null){


        if($anuncio_id==null){
            redirect("index.php/anuncio/nuevo/");
          }else{

            $data = $this->anuncio_model->obtenerDatosAnuncioPublico($anuncio_id);
            $datos_anuncio = array('datos_anuncio' => $data);
            $this->load->view('modules/headers');
            //$this->load->view('modules/topbar');
            $this->load->view('modules/menu');
            $this->load->view('anuncio-ver', $datos_anuncio);
            $this->load->view('modules/scripts-anuncio-nuevo-preview.php');
          }  

      
    }



}

?>