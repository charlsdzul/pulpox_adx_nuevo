<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
    }

    function nuevo($anuncio_id = null){
      if($anuncio_id==null){
        $id_aleatorio = rand(1000000000, 2000000000);
        redirect("index.php/anuncio/nuevo/$id_aleatorio");

      }else{
        $data = array('anuncio_id' => $anuncio_id);
        $this->load->view('modules/headers');
        //$this->load->view('modules/topbar');
        $this->load->view('modules/menu');
        $this->load->view('anuncio-nuevo',$data);
        $this->load->view('modules/scripts-anuncio-nuevo.php',$data);
      }           
    }

    function preview($anuncio_id=null){
      if($anuncio_id==null){
        redirect("index.php/anuncio/nuevo/");
      }else{
        $data = array('anuncio_id' => $anuncio_id);
        $this->load->view('modules/headers');
        //$this->load->view('modules/topbar');
        $this->load->view('modules/menu');
        $this->load->view('anuncio-nuevo-preview', $data);
        $this->load->view('modules/scripts-anuncio-nuevo-preview.php');
      }     
    } 

    function publicar(){
        $nuevo_anuncio = json_encode($this->input->post());
       echo $nuevo_anuncio;



    
    } 
}

?>