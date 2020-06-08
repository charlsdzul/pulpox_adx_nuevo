<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MiAnuncio extends CI_Controller {    

     function __construct() {
        parent::__construct();

        $this->load->library('sesiones');
        $this->sesiones->usuarioEnSesion(); 

        $this->load->helper('url'); 
        $this->load->model('mianuncio_model');
        $this->ruta_imagenes_temporales = "imagenes_temporales/anuncios/";   
        $this->load->library('validaciones');
    }

    function nuevo($anuncio_id = null){
      if($anuncio_id==null){
        $id_aleatorio = rand(1000000000, 2000000000);
        redirect("index.php/mianuncio/nuevo/$id_aleatorio");
      }else{
        $data = array('anuncio_id' => $anuncio_id);
        $this->load->view('modules/headers-mianuncio-nuevo.php');
        $this->load->view('modules/menu');
        $this->load->view('anuncio-nuevo',$data);
        $this->load->view('modules/scripts-mianuncio-nuevo.php',$data);
      }           
    }

    function preview($anuncio_id=null){
      if($anuncio_id==null){
        redirect("index.php/mianuncio/nuevo/");
      }else{
        $data = array('anuncio_id' => $anuncio_id);
        $this->load->view('modules/headers-mianuncio-nuevo-preview');
        $this->load->view('modules/menu');
        $this->load->view('anuncio-nuevo-preview', $data);
        $this->load->view('modules/scripts-mianuncio-nuevo-preview.php');
      }     
    }
    
    function publicar(){   
      /**
       * Recibe datos de un anuncio para guardarlo.
       */

      if(isset($_POST['nuevo_anuncio'])){  

        $anuncio_datos = $_POST['nuevo_anuncio'];

        if($anuncio_datos['public_id'] = $this->validaciones->generarPublicId()){   
          $anuncio_datos['titulo'] = $this->validaciones->validaTitulo($anuncio_datos['titulo'],'titulo');  
          $anuncio_datos['mensaje'] = $this->validaciones->validaTitulo($anuncio_datos['mensaje'],'mensaje'); 
          $this->validaciones->existeValor($anuncio_datos['modalidad'], 'modalidad'); 
          $this->validaciones->existeValor($anuncio_datos['estado'], 'estado');
            $anuncio_datos['estado'] = $this->validaciones->obtenerSigla($anuncio_datos['estado'], 'estado');
          $this->validaciones->existeValor($anuncio_datos['ciudad'], 'ciudad');
            $anuncio_datos['ciudad'] =$this->validaciones->obtenerSigla($anuncio_datos['ciudad'], 'ciudad');          
          $this->validaciones->existeValor($anuncio_datos['seccion'], 'seccion');
            $anuncio_datos['seccion'] =$this->validaciones->obtenerSigla($anuncio_datos['seccion'], 'seccion');
          $this->validaciones->existeValor($anuncio_datos['apartado'], 'apartado');
            $anuncio_datos['apartado'] =$this->validaciones->obtenerSigla($anuncio_datos['apartado'], 'apartado');
          $this->validaciones->validaTelefono($anuncio_datos['telefono'],'telefono');
          $this->validaciones->validaTelefono($anuncio_datos['celular'],'celular');
          $this->validaciones->validaCorreo($anuncio_datos['correo'],'correo');  
          $anuncio_datos['usuario'] = 111;
          $this->mianuncio_model->publicar($anuncio_datos);
          /**
           * NOTA:
           * En cada validación: en caso de no pasar la validación, enviará su propio $response y finaliza todo el script
           * En la actualización: envía su propio $response.
           */ 
        }else{
          $response['codigo']=1;
          $response['mensaje']='Lo sentimos, hubo un problema al intentar publicar tu anuncio. Intenta más tarde.';
          echo json_encode($response);
          die();
        }   
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, no recibimos datos de tu anuncio.';
        echo json_encode($response);
        die();
      }   
    } 

    function editar(){
      /**
       * Recibe datos de un anuncio para editarlo.
       */

      if(isset($_POST['anuncio_editado'])){
        $anuncio_datos = $_POST['anuncio_editado'];  
        $anuncio_datos['titulo'] = $this->validaciones->validaTitulo($anuncio_datos['titulo'],'titulo');  
        $anuncio_datos['mensaje'] = $this->validaciones->validaTitulo($anuncio_datos['mensaje'],'mensaje'); 
        $this->validaciones->existeValor($anuncio_datos['modalidad'], 'modalidad'); 
        $this->validaciones->existeValor($anuncio_datos['estado'], 'estado');
          $anuncio_datos['estado'] = $this->validaciones->obtenerSigla($anuncio_datos['estado'], 'estado');
        $this->validaciones->existeValor($anuncio_datos['ciudad'], 'ciudad');
          $anuncio_datos['ciudad'] =$this->validaciones->obtenerSigla($anuncio_datos['ciudad'], 'ciudad');          
        $this->validaciones->existeValor($anuncio_datos['seccion'], 'seccion');
          $anuncio_datos['seccion'] =$this->validaciones->obtenerSigla($anuncio_datos['seccion'], 'seccion');
        $this->validaciones->existeValor($anuncio_datos['apartado'], 'apartado');
          $anuncio_datos['apartado'] =$this->validaciones->obtenerSigla($anuncio_datos['apartado'], 'apartado');
        $this->validaciones->validaTelefono($anuncio_datos['telefono'],'telefono');
        $this->validaciones->validaTelefono($anuncio_datos['celular'],'celular');
        $this->validaciones->validaCorreo($anuncio_datos['correo'],'correo');  
        $this->mianuncio_model->editar($anuncio_datos);

        /**
         * NOTA:
         * En cada validación: en caso de no pasar la validación, enviará su propio $response y finaliza todo el script
         * En la actualización: envía su propio $response.
         */    

      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, no recibimos datos para la edición.';
        echo json_encode($response);
        die();
      }   
    }
    
    function ver($anuncio_id = null){
      if($anuncio_id==null){
          redirect("index.php/misanuncios/");
        }else{
          $data = $this->mianuncio_model->ver($anuncio_id);
          $datos_anuncio = array('datos_anuncio' => $data);
          $this->load->view('modules/headers-mianuncio-ver.php');
          $this->load->view('modules/menu');
          $this->load->view('anuncio-ver', $datos_anuncio);
          $this->load->view('modules/scripts-mianuncio-ver.php');    
          $this->load->view('modules/scripts-carrousel.php');  
          $this->load->view('modules/scripts-asignar-valores.php');   
        }       
  }

    function subirImagenTemporal(){

      if($this->input->post()){
        $datos_recibidos = $this->input->post();    
        $numero = $datos_recibidos['numero']; 
        $anuncio_id = $datos_recibidos['anuncio_id'];         

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
                  echo json_encode($response);
                  die();
      
              }else{
                  $response['codigo']= 3;
                  $response['mensaje']=  'Lo sentimos, hubo un problema al subir su imágen. Intente otra.';
                  echo json_encode($response);
                  die();
              }
           
          }else{
            $response['codigo']= 2;
            $response['mensaje']=  'La imágen es demasiado grande. Máximo 5 MB.';
            echo json_encode($response);
            die();
          }  
            
        }else{

          $response['codigo']= 1;
          $response['mensaje']= 'Elige una imágen con extensión JPG, JPEG, PNG, GIF.';
          echo json_encode($response);
          die();
        }  

      }else{
        $response['codigo']= 1;
        $response['mensaje']= 'No recibimos los datos de tu imágen.';    
        echo json_encode($response);
        die();
      }         
    }

    function eliminarImagenTemporal(){    

      if($this->input->post()){
        $numero = $_POST['numero']; 
        $path_imagen = $_POST['path_imagen']; 
        $response['codigo'] = 0;
        $response['mensaje'] = 'imagen_delete_ok'; 

        $img_explode =  explode( '/', $path_imagen ); 
        $img_explode_2 =  explode( '?', $img_explode[7] ); 

        $nuevo_path_imagen = $this->ruta_imagenes_temporales.$img_explode[6].'/'.$img_explode_2[0]; 

        if(file_exists($nuevo_path_imagen)){
            unlink($nuevo_path_imagen);  
            $response['codigo'] = 0;
            $response['mensaje'] = '';
            echo json_encode($response);
            die();               
        }else{
          $response['codigo'] = 1;
          $response['mensaje'] = 'Lo sentimos, la imágen no se pudo eliminar.';
          echo json_encode($response);
          die();
        }
      }else{
        $response['codigo']= 1;
        $response['mensaje']= 'No recibimos los datos de tu imágen.';    
        echo json_encode($response);
        die();
      }      
    }  

}

?>