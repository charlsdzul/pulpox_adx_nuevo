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
        $this->load->view('modules/headers-anuncio-nuevo');
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

      if($this->input->post()!=null){
        $nuevo_anuncio = json_encode($this->input->post());
        $nuevo_anuncio=json_decode($nuevo_anuncio);
        $public_id = $this->anuncio_model->generarPublicId(); 
        $response['codigo'] = 0;
        $response['mensaje']= '';        

          //VALIDACIÓN TÍTULO
          if(strlen($nuevo_anuncio->titulo)=='' ){  
            $response['codigo'] = 1;
            $response['mensaje']= 'Necesita ingresar un título para su anuncio.';           
            echo json_encode($response); 
            die();
          }else{
            if(strlen($nuevo_anuncio->titulo)<=50 ){ 
              $nuevo_anuncio->titulo = $this->sanitize($nuevo_anuncio->titulo);
            }else{
              $response['codigo']  = 1;
              $response['mensaje'] = 'Título demasiado largo. Edite.';  
              echo json_encode($response);  
              die();     
            } 
          }

          //VALIDACIÓN ANUNCIO
          if(strlen($nuevo_anuncio->anuncio)=='' ){  
            $response['codigo'] = 1;
            $response['mensaje']= 'Necesita ingresar un mensaje su anuncio.';           
            echo json_encode($response); 
            die();
          }else{
            if(strlen($nuevo_anuncio->anuncio)<=1200){ 
              $nuevo_anuncio->anuncio = $this->sanitize($nuevo_anuncio->anuncio);
            }else{
              $response['codigo']  = 1;
              $response['mensaje'] = 'Anuncio demasiado largo. Edite.';  
              echo json_encode($response);    
              die();   
            } 
          }   

          //VALIDACIÓN ESTADO
          if($this->anuncio_model->existeValor($nuevo_anuncio->estado, 'estado')){
          }else{
             $response['codigo']  = 1;
             $response['mensaje'] = 'Ingresa un estado válido. Edite.';  
             echo json_encode($response);    
            die();   
          }          
        
          //VALIDACION CIUDAD
         if($this->anuncio_model->existeValor($nuevo_anuncio->ciudad, 'ciudad')){
         }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'Ingresa una ciudad válida. Edite.';  
            echo json_encode($response);    
            die();   
         }

          //VALIDACION MODALIDAD
          if($this->anuncio_model->existeValor($nuevo_anuncio->modalidad, 'modalidad')){
          }else{
             $response['codigo']  = 1;
             $response['mensaje'] = 'Ingresa una modalidad válida. Edite.';  
          }

          //VALIDACION SECCION
          if($this->anuncio_model->existeValor($nuevo_anuncio->seccion, 'seccion')){
          }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'Ingresa una sección válida. Edite.';  
            echo json_encode($response);    
            die();  
          }

          //VALIDACION APARTADO
          if($this->anuncio_model->existeValor($nuevo_anuncio->apartado, 'apartado')){
          }else{
             $response['codigo']  = 1;
             $response['mensaje'] = 'Ingresa un apartado válido. Edite.';
             echo json_encode($response);    
            die();   
          }

          //VALIDACION TELEFONO
          if(strlen($nuevo_anuncio->telefono)!=0){ 
            if(strlen($nuevo_anuncio->telefono)==10){
              if(is_numeric($nuevo_anuncio->telefono)){
              }else{
                $response['codigo']  = 1;
                $response['mensaje'] = 'Ingresa un teléfono fijo válido. Edite.';  
                echo json_encode($response);    
                die(); 
              }
            }else{
              $response['codigo']  = 1;
              $response['mensaje'] = 'Ingresa un teléfono fijo válido a 10 dígitos. Edite.';  
              echo json_encode($response);    
              die(); 
            }
          }
          
          //VALIDACION CELULAR
          if(strlen($nuevo_anuncio->celular)!=0){ 
            if(strlen($nuevo_anuncio->celular)==10){
              if(is_numeric($nuevo_anuncio->celular)){
              }else{
                $response['codigo']  = 1;
                $response['mensaje'] = 'Ingresa un teléfono celular válido. Edite.';  
                echo json_encode($response);    
                die(); 
              }
            }else{
              $response['codigo']  = 1;
              $response['mensaje'] = 'Ingresa un teléfono celular válido a 10 dígitos. Edite.';  
              echo json_encode($response);    
              die(); 
            }
          }     
          
          //VALIDACION CORREO
          if(strlen($nuevo_anuncio->correo)!=0){            
            if(filter_var($nuevo_anuncio->correo, FILTER_VALIDATE_EMAIL)){
            }else{
              $response['codigo']  = 1;
              $response['mensaje'] = 'Ingresa un correo válido. Edite.';  
              echo json_encode($response);    
              die(); 
            }
          }


        //GUARDA ANUNCIO
        if($this->anuncio_model->publicar($nuevo_anuncio, $public_id)){
          $response['codigo'] = 0;
          $response['mensaje']= 'Anuncio publicado exitosamente.'; 
          echo json_encode($response);

        }else{
          $response['codigo']  = 2;
          $response['mensaje'] = 'Ha ocurrido un error. Intenta más tarde.';  
          echo json_encode($response);
        }
       
      }else{
        redirect("index.php/anuncio/nuevo/");
      }   
         
    } 

    function subirImagenTemporal($anuncio_id=null){

      if($anuncio_id==null){

        redirect("index.php/anuncio/nuevo/");

      }else{           

        $numero = $_POST['numero']; 
        $response['codigo'] = 0;
        $response['mensaje'] = 'imagen_ok';

        $imagen_tipo=$_FILES["imagen"]["type"];
        $imagen_tamano = $_FILES['imagen']['size']; 
        $imagen_nombre_temporal = $_FILES['imagen']['name'];           
        
        $imagen_extension = pathinfo($imagen_nombre_temporal, PATHINFO_EXTENSION);

        $imagen_nombre = 'img_'.$numero.'_'.$anuncio_id."_".date("Y-m-d").'.'.$imagen_extension;

        $imagen_folder_path=$this->ruta_imagenes_temporales.$anuncio_id; 
        $imagen_path       =$this->ruta_imagenes_temporales.$anuncio_id.'/'.$imagen_nombre;         

        $extensiones_validas = array('gif', 'png', 'jpg', 'jpeg');

        //Valida extensión del archivo
        if (in_array($imagen_extension, $extensiones_validas)) {

          if($imagen_tamano<=5000000){
              
            //Si no existe el folder, lo crea
            if(!(file_exists($imagen_folder_path))){
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
                  $response['codigo']= 3;
                  $response['mensaje']=  'Lo sentimos, hubo un problema al subir su imágen. Intente otra.';
              }

           
          }else{
            $response['codigo']= 2;
            $response['mensaje']=  'La imágen es demasiado grande. Máximo 5 MB.';
          }  
            
        }else{

          $response['codigo']= 1;
          $response['mensaje']= 'Elige una imágen con extensión JPG, JPEG, PNG, GIF.';

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

        $img_explode =  explode( '/', $path_imagen ); //explode con '/'
        $img_explode_2 =  explode( '?', $img_explode[7] ); //explode con '?'

        $nuevo_path_imagen = $this->ruta_imagenes_temporales.$img_explode[6].'/'.$img_explode_2[0]; 

        if(file_exists($nuevo_path_imagen)){
            unlink($nuevo_path_imagen);                 
        }else{
          $response['codigo'] = 1;
          $response['mensaje'] = 'Lo sentimos, la imágen no se pudo eliminar.';
        }
        echo json_encode($response);  
      }
    }  

    function sanitize($string){
      //$black_list  = array("<script>");  
      $string = strip_tags($string);
      //$string = str_ireplace($black_list,'',$string);     
      $string = htmlentities($string);  
      return $string;      
    }
      
}

?>