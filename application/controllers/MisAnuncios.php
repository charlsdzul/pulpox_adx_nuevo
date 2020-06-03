<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->model('misanuncios_model');
        $this->load->model('anuncio_model');
        $this->carpeta_final_anuncio = "imagenes_anuncios/"; 
        $this->carpeta_temporal_anuncio = "imagenes_temporales/anuncios/"; 

    }

    function index(){
        $misanuncios = $this->misanuncios_model->obtenerMisAnuncios();
        $data = array('misanuncios' => $misanuncios);
        $this->load->view('modules/headers');
        $this->load->view('modules/menu');
        $this->load->view('mis-anuncios', $data);      
    }

    function ver($anuncio_id = null){

        if($anuncio_id==null){
            redirect("index.php/anuncio/nuevo/");
          }else{
            $data = $this->anuncio_model->obtenerDatosAnuncioPublico($anuncio_id);
            $datos_anuncio = array('datos_anuncio' => $data);
            $this->load->view('modules/headers');
            //$this->load->view('modules/topbar');
            $this->load->view('modules/menu');
            $this->load->view('anuncio-ver', $datos_anuncio);
            $this->load->view('modules/scripts-anuncio-ver.php');
            
          }  

      
    }

    function obtenerDatosParaEdicionMovil(){
      $publid_id = $_POST['id']; 
      $datosEdicion = $this->misanuncios_model->obtenerDatosParaEdicionMovil($publid_id);
      echo json_encode($datosEdicion);

    }

    function eliminarImagenActual(){  
      
      $response['codigo'] = 1;
      $response['mensaje'] = 'Lo sentimos, la imágen no se pudo eliminar.';


      if(isset($_POST['numero']) && isset($_POST['path_imagen'])){

        $numero_imagen = $_POST['numero'];  
        $path_imagen = $_POST['path_imagen']; 

        $path_imagen_explode =  explode( '?', $path_imagen); //explode con '?'
        $path_imagen = $path_imagen_explode[0];
       
        $path_imagen_explode =  explode( '/', $path_imagen); //explode con '/'
        $nombre_imagen = $path_imagen_explode[6];
        $public_id = $path_imagen_explode[5];
        $path_imagen = $path_imagen_explode[4]."/".$path_imagen_explode[5]."/".$path_imagen_explode[6];
       
        if(file_exists($path_imagen)){          
            $response = $this->misanuncios_model->eliminarImagen($nombre_imagen,$numero_imagen,$public_id);
            if($response['codigo']==0){
              unlink($path_imagen);
               
            }else{
               
            }                                         
        }else{
          $response['codigo'] = 1;
          $response['mensaje'] = 'Lo sentimos, la imágen no se pudo eliminar.';
           
        }    
      
    }else{
       
    }

    echo json_encode($response);


  }

}

?>