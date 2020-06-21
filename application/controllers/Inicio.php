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
        var_dump($this->session->userdata()); 
        $this->load->view('headers/header-html-mis-anuncios');
        $this->load->view('scripts/script-js-general.php');  
        $this->load->view('modules/menu'); 
        $this->load->view('scripts/script-js-iniciar-sesion.php');      

      }

}
?>