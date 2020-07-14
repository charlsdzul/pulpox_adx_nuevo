<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {    

     function __construct() {
        parent::__construct();        
        //$this->load->library('sesiones');
        //$this->sesiones->usuarioEstaEnSesion(); 
       $this->load->helper('url'); 
       $this->load->model('inicio_model');
       // $this->load->library('session'); 
        $this->load->library('validaciones');

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

    function buscarAnuncios(){
      //var_dump($datosBusqueda);
      $datosBusqueda = $this->input->get();     

      if($datosBusqueda){

        if($datosBusqueda['modalidad']=='Todas') $datosBusqueda['modalidad'] = "";
        else $datosBusqueda['modalidad']= $this->validaciones->obtenerNombreDeFrase($datosBusqueda['modalidad']);

        $datosBusqueda['estado']= $this->validaciones->obtenerSigla( $datosBusqueda['estado'], 'estado');

        if($datosBusqueda['ciudad'] == 'Todas') $datosBusqueda['ciudad'] = "";
        else $datosBusqueda['ciudad']= $this->validaciones->obtenerSigla( $datosBusqueda['ciudad'], 'ciudad');

        $datosBusqueda['seccion']= $this->validaciones->obtenerSigla( $datosBusqueda['seccion'], 'seccion');

        if($datosBusqueda['apartado'] =='Todos') $datosBusqueda['apartado']="";
        else $datosBusqueda['apartado']= $this->validaciones->obtenerSigla( $datosBusqueda['apartado'], 'apartado');
  
        $this->inicio_model->buscarAnuncios($datosBusqueda);

      }   
      

    }



}
?>