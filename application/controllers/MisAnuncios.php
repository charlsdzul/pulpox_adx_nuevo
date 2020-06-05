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
        $this->load->library('validaciones');
    }

    function index(){
        $misanuncios = $this->misanuncios_model->obtenerMisAnuncios();
        $data = array('misanuncios' => $misanuncios);
        $this->load->view('modules/headers');
        $this->load->view('modules/menu');
        $this->load->view('mis-anuncios', $data);  
        $this->load->view('modules/scripts-mis-anuncios.php');    
    }

    function ver($anuncio_id = null){
        if($anuncio_id==null){
            redirect("index.php/anuncio/nuevo/");
          }else{
            $data = $this->anuncio_model->obtenerDatosAnuncioPublico($anuncio_id);
            $datos_anuncio = array('datos_anuncio' => $data);
            $this->load->view('modules/headers-mis-anuncios');
            $this->load->view('modules/menu');
            $this->load->view('anuncio-ver', $datos_anuncio);
            $this->load->view('modules/scripts-anuncio-ver.php');            
          }       
    }

    function obtenerDatosAnuncioMovil(){
      if(isset($_POST['id'])){
          $public_id = $_POST['id'];        
          $data = $this->misanuncios_model->obtenerDatosAnuncioMovil($public_id);
          echo json_encode($data);          
        }       
    }

    function obtenerDatosParaEdicionMovil(){
      $public_id = $_POST['id']; 
      $datosEdicion = $this->misanuncios_model->obtenerDatosParaEdicionMovil($public_id);
      echo json_encode($datosEdicion);
    }

    function cambiarEstatus(){
      if(isset($_POST['id']) && isset($_POST['estatus_actual'])){
        $anuncio_id = $_POST['id']; 
        $anuncio_estatus_actual = $_POST['estatus_actual']; 
        $response = $this->misanuncios_model->cambiarEstatus($anuncio_id,$anuncio_estatus_actual);
        echo json_encode($response);
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, el estatus no se pudo cambiar.';
        echo json_encode($response);
      }
    }

    function editarAnuncio(){
      if(isset($_POST['anuncio_editado'])){
       $anuncio_datos = $_POST['anuncio_editado']; 
       $anuncio_datos['titulo'] = $this->validaciones->validaTitulo($anuncio_datos['titulo']);  
     

       // $response = $this->misanuncios_model->editarAnuncio($anuncio_id,$anuncio_estatus_actual);
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, el anuncio no se pudo editar.';
        echo json_encode($response);
      }
    }

    function eliminarAnuncio(){
      if(isset($_POST['id']) ){
        $anuncio_id = $_POST['id'];         
        $response = $this->misanuncios_model->eliminarAnuncio($anuncio_id);
        echo json_encode($response);
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, el anuncio no se pudo eliminar.';
        echo json_encode($response);
      }
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