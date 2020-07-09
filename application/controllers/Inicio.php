<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {    

     function __construct() {
        parent::__construct();        
        //$this->load->library('sesiones');
        //$this->sesiones->usuarioEstaEnSesion(); 
        $this->load->helper('url'); 
        //$this->load->model('misanuncios_model');
        $this->load->library('session'); 
    }

    function index(){              
        $this->load->view('headers/header-html-inicio');
        $this->load->view('scripts/script-js-general.php');  
        $this->load->view('modules/menu');        
        $this->load->view('pages/page-inicio.php');   
        $this->load->view('scripts/script-js-inicio.php');  
        $this->load->view('scripts/script-js-logout.php');  
        $this->load->view('scripts/script-js-iniciar-sesion.php'); 
      }

}
?>