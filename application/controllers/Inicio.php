<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {    

     function __construct() {
        parent::__construct();   
        $this->load->helper('url'); 
        $this->load->model('inicio_model');
        $this->load->library('session'); 
        $this->load->library('validaciones');
    }

    function index(){              
        $data = array('paginaNombre' => 'Pulpox: Inicio');
        $this->load->view('headers/header-html', $data);
        $this->load->view('scripts/script-js-general.php');  
        $this->load->view('modules/menu');        
        $this->load->view('pages/page-inicio.php');   
        $this->load->view('scripts/script-js-inicio.php');  
        //$this->load->view('scripts/script-js-logout.php');  
        $this->load->view('scripts/script-js-iniciar-sesion.php'); 
    }

    function ui(){
      $data = array('paginaNombre' => 'Pulpox: UI');
      $this->load->view('headers/header-html', $data);
      $this->load->view('pages/page-ui.php');   
    }

    function buscarAnuncios(){
      $datosBusqueda = $this->input->get();     
   //var_dump($datosBusqueda);
      if($datosBusqueda){     
        
        //Validación Modalidad
        if($datosBusqueda['modalidad']=='Todas') $datosBusqueda['modalidad'] = " ";
        else {
        
          try{
          if($datosBusqueda['modalidad']= $this->validaciones->obtenerNombreDeFrase($datosBusqueda['modalidad'])); 
          else $datosBusqueda['modalidad'] = " ";
          }catch (Exception $e) {
            $datosBusqueda['modalidad'] = " ";
          }
        }

        //Validación Estado
        if($datosBusqueda['estado']=='Todo México') $datosBusqueda['estado'] = " ";
        else{
          try{
            if($datosBusqueda['estado']= $this->validaciones->obtenerSigla( $datosBusqueda['estado'], 'estado'));
            else $datosBusqueda['estado'] = " ";
          }catch (Exception $e) {
            $datosBusqueda['estado'] = " ";
          }
        }
          
        if($datosBusqueda['ciudad'] == 'Todas') $datosBusqueda['ciudad'] = " ";
        else{
          try{
            if($datosBusqueda['ciudad']= $this->validaciones->obtenerSigla( $datosBusqueda['ciudad'], 'ciudad'));
            else $datosBusqueda['ciudad'] = " ";
          }catch (Exception $e) {
            $datosBusqueda['ciudad'] = " ";
          }
        }       
        
        if($datosBusqueda['seccion'] == 'Todas') $datosBusqueda['seccion'] = " ";
        else{
          try{
            if($datosBusqueda['seccion']= $this->validaciones->obtenerSigla( $datosBusqueda['seccion'], 'seccion'));
            else $datosBusqueda['seccion'] = " ";
          }catch (Exception $e) {
            $datosBusqueda['seccion'] = " ";
          }
        }      

        if($datosBusqueda['apartado'] == 'Todos') $datosBusqueda['apartado'] = " ";
        else{
          try{
            if($datosBusqueda['apartado']= $this->validaciones->obtenerSigla( $datosBusqueda['apartado'], 'apartado'));
            else $datosBusqueda['apartado'] = " ";
          }catch (Exception $e) {
            $datosBusqueda['apartado'] = " ";
          }
        } 

        if($datosBusqueda['numeroMostrar'] > 100) $datosBusqueda['numeroMostrar'] = "25";           

        try{
          $this->inicio_model->buscarAnuncios($datosBusqueda);   
        }catch (Exception $e) {          
          $response['codigo']  = 1;
          $response['mensaje'] = 'Hubo un problema al consultar los anuncios. Intente más tarde.';  
          echo json_encode($response);    
          die(); 
        }

      }         

    }

    function buscarAnunciosGeneral(){   
      $this->inicio_model->buscarAnunciosGeneral();     

    } 

}
?>