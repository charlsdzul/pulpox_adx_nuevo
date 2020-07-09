<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->model('general_model');
    }

    function obtenerEstados(){
      $response = $this->general_model->obtenerEstados();
      echo json_encode($response);           
    }

    function obtenerModalidades(){
      $response = $this->general_model->obtenerModalidades();
      echo json_encode($response);           
    }

    function obtenerSecciones(){
      $response = $this->general_model->obtenerSecciones();
      echo json_encode($response);           
    }

    function obtenerApartados(){
      $seccion = $_GET['seccion'];
      $response = $this->general_model->obtenerApartados($seccion);
      echo json_encode($response);           
    }

    function obtenerCiudades(){
      $estado = $_GET['estado'];
      $response = $this->general_model->obtenerCiudades($estado);
      echo json_encode($response);           
    }

    function obtenerAnunciosCantidad(){
      $response = $this->general_model->obtenerAnunciosCantidad();
      echo json_encode($response);           
    }


      
}

?>