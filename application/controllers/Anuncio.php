<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio extends CI_Controller {    

    function __construct() {
        parent::__construct();   
        $this->load->helper('url'); 
        $this->load->model('anuncio_model');
        $this->load->library('session'); 
        $this->load->library('validaciones');
    }

    function index(){    
        $data = array('paginaNombre' => 'Pulpox: Anuncio');
        $this->load->view('headers/header-html', $data);
        $this->load->view('scripts/script-js-general.php');  
        $this->load->view('modules/menu');        
        $this->load->view('pages/page-inicio.php');   
        $this->load->view('scripts/script-js-inicio.php');  
        $this->load->view('scripts/script-js-logout.php');  
        $this->load->view('scripts/script-js-iniciar-sesion.php'); 
    }

    function ver($anuncio_id){    

        $response = $this->anuncio_model->ver($anuncio_id);

        $data = array('datos_anuncio' => $response);      
        //$data = array('paginaNombre' => 'Pulpox: Anuncio');

        $this->load->view('headers/header-html', $data);
        $this->load->view('modules/menu'); 
        $this->load->view('pages/page-anuncio.php',$data);
         

        //
      
        
/*        $this->load->view('scripts/script-js-general.php');  
        $this->load->view('modules/menu');   

             

        $this->load->view('scripts/script-js-inicio.php');  
        $this->load->view('scripts/script-js-logout.php');  
        $this->load->view('scripts/script-js-iniciar-sesion.php'); 
        */
    }


}