<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->model('anuncio_model');
        $this->ruta_imagenes_temporales = "imagenes_temporales/anuncios/";   
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

        if($this->anuncio_model->publicar($nuevo_anuncio, $public_id)){
          $response['codigo'] = 0;
          $response['mensaje']= 'Anuncio publicado exitosamente.'; 

        }else{
          $response['codigo']  = 2;
          $response['mensaje'] = 'Ha ocurrido un error. Intenta más tarde.';  
        }

        echo json_encode($response); 
       
 
    

         
    } 

    function subirImagenTemporal($anuncio_id=null){

      if($anuncio_id==null){
        redirect("index.php/anuncio/nuevo/");
      }else{
        $filename = $_FILES['imagen']['name']; 
        $numero = $_POST['numero']; 
        $response['codigo'] = 0;
        $response['mensaje'] = 'imagen_ok';


        $imagen_tipo=$_FILES["imagen"]["type"];
        $imagen_nombre_temporal = $_FILES['imagen']['name'];    
        $imagen_extension = explode(".",$imagen_nombre_temporal);   
        $imagen_nombre = 'img_'.$numero.'_'.$anuncio_id."_".date("Y-m-d").'.'.$imagen_extension[1];

        $imagen_folder_path=$this->ruta_imagenes_temporales.$anuncio_id; 
        $imagen_path       =$this->ruta_imagenes_temporales.$anuncio_id.'/'.$imagen_nombre;         
        
        if ($imagen_tipo == "image/jpeg" || $imagen_tipo == "image/jpg" || $imagen_tipo == "image/png" || $imagen_tipo == "image/gif"){

          //Si no existe el folder, lo crea
          if(file_exists($imagen_folder_path)){
          }else{
            mkdir($imagen_folder_path, 0700);
          }

          //Si existe imagen previa, segun el numero de la imagen la elimina y almacena la nueva
          if(file_exists($imagen_path)){
              unlink($imagen_path);                 
          }

          //Mueve la imagen temporal al servidor
              if(move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_path)){
                $response['codigo'] = 0;
                $response['mensaje'] = $imagen_path;

              }else{
                $response['codigo']= 2;
                $response['mensaje']=  'Lo sentimos, hubo un problema al subir su imágen. Intente otra.';
              }
            

      }else{
        $response['codigo']= 1;
        $response['mensaje']= 'Lo sentimos, el tipo de imágen es inválido. Intenta con JPG, JPEG, PNG o GIF.';
      }

        echo json_encode($response);
      }  


     
      
    }

    function eliminarImagenTemporal($anuncio_id=null){

      if($anuncio_id==null){
        redirect("index.php/anuncio/nuevo/");
      }else{

        $numero = $_POST['numero']; 
        $path_imagen = $_POST['path_imagen']; 
        $response['codigo'] = 0;
        $response['mensaje'] = 'imagen_delete_ok';

       // echo $path_imagen;

        $img_explode =  explode( '/', $path_imagen );
        $nuevo_path_imagen = $this->ruta_imagenes_temporales.$img_explode[6].'/'.$img_explode[7]; 
      
        if(file_exists($nuevo_path_imagen)){
            unlink($nuevo_path_imagen);                 
        }else{
          $response['codigo'] = 1;
          $response['mensaje'] = 'Lo sentimos, la imágen no se pudo eliminar.';
        }
        echo json_encode($response);  
      }
    }
      
}

?>