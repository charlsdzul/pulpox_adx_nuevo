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
        $this->load->view('headers/header-html-mis-anuncios');
        $this->load->view('modules/menu');       
        $this->load->view('pages/page-mis-anuncios');  
        $this->load->view('scripts/script-js-mis-anuncios.php');  
        $this->load->view('scripts/script-js-carrousel.php');     
        $this->load->view('scripts/script-js-asignar-valores.php');  
        $this->load->view('scripts/script-js-asignar-validaciones-inputs.php');
        $this->load->view('scripts/script-js-renovar-anuncio.php'); 
        $this->load->view('scripts/script-js-validar-imagen.php'); 
        $this->load->view('scripts/script-js-eliminar-imagen.php');  
        $this->load->view('scripts/script-js-guardar-imagen.php'); 
        $this->load->view('scripts/script-js-definir-selects-valores.php'); 
        $this->load->view('scripts/script-js-asignar-imagenes-editar.php'); 
        $this->load->view('scripts/script-js-validar-formulario.php'); 
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