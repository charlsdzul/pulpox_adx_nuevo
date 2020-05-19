<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->model('anuncio_model');
    }

    function nuevo($anuncio_id = null){
      if($anuncio_id==null){
        $id_aleatorio = rand(1000000000, 2000000000);
        redirect("index.php/anuncio/nuevo/$id_aleatorio");

      }else{
        $data = array('anuncio_id' => $anuncio_id);
        $this->load->view('modules/headers');
        //$this->load->view('modules/topbar');
        $this->load->view('modules/menu');
        $this->load->view('anuncio-nuevo',$data);
        $this->load->view('modules/scripts-anuncio-nuevo.php',$data);
      }           
    }

    function preview($anuncio_id=null){
      if($anuncio_id==null){
        redirect("index.php/anuncio/nuevo/");
      }else{
        $data = array('anuncio_id' => $anuncio_id);
        $this->load->view('modules/headers');
        //$this->load->view('modules/topbar');
        $this->load->view('modules/menu');
        $this->load->view('anuncio-nuevo-preview', $data);
        $this->load->view('modules/scripts-anuncio-nuevo-preview.php');
      }     
    } 

    function publicar(){
        $nuevo_anuncio = json_encode($this->input->post());
        $nuevo_anuncio=json_decode($nuevo_anuncio);
        $public_id = $this->anuncio_model->generarPublicId();
        $response['codigo'] = 0;
        $response['mensaje']= 'Anuncio publicado exitosamente.'; 


        //VALIDACIÓN TÍTULO
        if(strlen($nuevo_anuncio->titulo)=='' ){  
          $response['codigo'] = 1;
          $response['mensaje']= 'Necesita ingresar un título para su anuncio.';           
          echo json_encode($response); 
          die();
        }else{
          if(strlen($nuevo_anuncio->titulo)<=50 ){ 
          }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'Título demasiado largo. Edite.';  
            echo json_encode($response);  
            die();     
          } 
        }

        //VALIDACIÓN TÍTULO
        if(strlen($nuevo_anuncio->anuncio)=='' ){  
          $response['codigo'] = 1;
          $response['mensaje']= 'Necesita ingresar un mensaje su anuncio.';           
          echo json_encode($response); 
          die();
        }else{
          if(strlen($nuevo_anuncio->anuncio)<=1000 ){ 
          }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'Título demasiado largo. Edite.';  
            echo json_encode($response);    
            die();   
          } 
        }      

        echo json_encode($response); 
       
 
    

         
    } 
}

?>