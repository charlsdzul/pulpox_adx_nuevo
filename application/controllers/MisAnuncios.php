<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios extends CI_Controller {    

     function __construct() {
        parent::__construct();        
        $this->load->library('sesiones');
        $this->sesiones->usuarioEnSesion(); 
        $this->load->helper('url'); 
        $this->load->model('misanuncios_model');
        $this->load->model('mianuncio_model');
        $this->carpeta_final_anuncio = "imagenes_anuncios/"; 
        $this->carpeta_temporal_anuncio = "imagenes_temporales/anuncios/"; 
        $this->load->library('validaciones');        
    }

    function index(){      
        $this->load->view('modules/headers-mis-anuncios');
        $this->load->view('modules/menu');       
        $this->load->view('mis-anuncios');  
        $this->load->view('modules/scripts-mis-anuncios.php');  
        $this->load->view('modules/scripts-carrousel.php');     
        $this->load->view('modules/scripts-asignar-valores.php');  
        $this->load->view('modules/scripts-asignar-validaciones.php');    
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