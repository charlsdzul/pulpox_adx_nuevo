<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios extends CI_Controller {    

     function __construct() {
        parent::__construct();        
        $this->load->library('sesiones');
        $this->sesiones->usuarioEstaEnSesion(); 
        $this->load->helper('url'); 
        $this->load->model('misanuncios_model');
    }

    function index(){      
        $this->load->view('headers/header-html-mis-anuncios');
        $this->load->view('scripts/script-js-general.php');  
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
        $this->load->view('scripts/script-js-carrousel.php');     
        $this->load->view('scripts/script-js-eliminar-anuncio.php');
        $this->load->view('scripts/script-js-cambiar-estatus-anuncio.php');
        $this->load->view('scripts/script-js-guardar-edicion.php'); 
        $this->load->view('scripts/script-js-boton-guardar-edicion.php'); 

      }

    function obtenerMisAnuncios(){
      $this->misanuncios_model->obtenerMisAnuncios();
    }

}
?>