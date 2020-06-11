<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios extends CI_Controller {    

     function __construct() {
        parent::__construct();        
        $this->load->library('sesiones');
        $this->sesiones->usuarioEnSesion(); 
        $this->load->helper('url'); 
        $this->load->model('misanuncios_model');
    }

    function index(){      
        $this->load->view('modules/headers-mis-anuncios');
        $this->load->view('modules/menu');       
        $this->load->view('mis-anuncios');  
        $this->load->view('modules/scripts-mis-anuncios.php');  
        $this->load->view('modules/scripts-carrousel.php');     
        $this->load->view('modules/scripts-asignar-valores.php');  
        $this->load->view('modules/scripts-asignar-validaciones.php');  
        $this->load->view('modules/scripts-validaciones-imagenes.php');    
    }

    function obtenerMisAnuncios(){
      if($response = $this->misanuncios_model->obtenerMisAnuncios()){
        echo json_encode($response);
        die(); 
      }else{
        $response['codigo']  = 1;
        $response['mensaje'] = 'Hubo un problema al intentar obtener tus anuncios. Intente más tarde o repórtelo.';  
        echo json_encode($response);    
        die(); 
      }
    }

}
?>