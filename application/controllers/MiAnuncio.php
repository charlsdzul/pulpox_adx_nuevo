<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MiAnuncio extends CI_Controller {    

     function __construct() {
        parent::__construct();
        $this->load->library('sesiones');
        $this->sesiones->usuarioEstaEnSesion(); 
        $this->load->model('mianuncio_model');
        $this->ruta_imagenes_temporales = "imagenes_temporales/anuncios/";   
        $this->carpeta_final_anuncio = "imagenes_anuncios/"; 
        $this->carpeta_temporal_anuncio = "imagenes_temporales/anuncios/"; 
        $this->load->library('validaciones');
        $this->load->helper('url'); 
        $this->NUMERO_IMAGENES = [1,2,3,4,5,6,7,8,9,10];
        $this->EXTENSIONES_ARCHIVOS_VALIDAS = ['png', 'jpg', 'jpeg'];        
    }

    function nuevo($anuncio_id = null){
      if($anuncio_id==null){
        $id_aleatorio = rand(1000000000, 2000000000);
        redirect("index.php/mianuncio/nuevo/$id_aleatorio");
      }else{
        if(strlen($anuncio_id)==10){
          $data = array('anuncio_id' => $anuncio_id);
          $this->load->view('headers/header-html-mianuncio-nuevo.php');
          $this->load->view('scripts/script-js-general.php');
          $this->load->view('modules/menu');
          $this->load->view('pages/page-anuncio-nuevo',$data);
          $this->load->view('scripts/script-js-mianuncio-nuevo.php',$data);
          $this->load->view('scripts/script-js-asignar-validaciones-inputs.php');
          $this->load->view('scripts/script-js-validar-imagen.php'); 
        }else{
          $id_aleatorio = rand(1000000000, 2000000000);
          redirect("index.php/mianuncio/nuevo/$id_aleatorio");
        }        
      }           
    }

    function preview($anuncio_id=null){
      if($anuncio_id==null){
        redirect("index.php/mianuncio/nuevo/");
      }else{
        if(strlen($anuncio_id)==10){
          $data = array('anuncio_id' => $anuncio_id);
          $this->load->view('headers/header-html-mianuncio-nuevo-preview');
          $this->load->view('scripts/script-js-general.php');
          $this->load->view('modules/menu');
          $this->load->view('pages/page-anuncio-nuevo-preview', $data);
          $this->load->view('scripts/script-js-mianuncio-nuevo-preview.php');
        }else{
          $id_aleatorio = rand(1000000000, 2000000000);
          redirect("index.php/mianuncio/nuevo/$id_aleatorio");
        }      
      }     
    }

    function editar($anuncio_id=null){
      /**
       * Recibe datos de un anuncio para editarlo.
       */      
      if($anuncio_id==null){
        redirect("index.php/misanuncios/");         
      }else{    
        if($this->validaciones->validarIdAnuncio($anuncio_id)){
          $response = $this->mianuncio_model->ver($anuncio_id);
          $data = array('datos_anuncio' => $response);
          $this->load->view('headers/header-html-mianuncio-editar.php');
          $this->load->view('scripts/script-js-general.php');
          $this->load->view('modules/menu');
          $this->load->view('pages/page-anuncio-editar',$data);
          $this->load->view('scripts/script-js-mianuncio-editar.php');
          $this->load->view('scripts/script-js-asignar-validaciones-inputs.php');             
          $this->load->view('scripts/script-js-definir-selects-valores.php'); 
          $this->load->view('scripts/script-js-asignar-imagenes-editar.php'); 
          $this->load->view('scripts/script-js-validar-imagen.php'); 
          $this->load->view('scripts/script-js-eliminar-imagen.php');
          $this->load->view('scripts/script-js-guardar-edicion.php'); 
          $this->load->view('scripts/script-js-validar-formulario.php');           
          $this->load->view('scripts/script-js-guardar-imagen.php');   
        }else{
          $respuesta['respuesta'] = 'El ID ingresado en la URL debe ser de 30 caracteres alfanumúmericos.';
          $this->load->view('headers/header-html-mianuncio-ver.php');
          $this->load->view('modules/menu');
          $this->load->view('pages/page-pagina-no-existe', $respuesta);     
        }        
      }    
    }

    function ver($anuncio_id = null){
      if($anuncio_id==null){
          redirect("index.php/misanuncios/");
      }else{
        if($this->validaciones->validarIdAnuncio($anuncio_id)){
          if($this->validaciones->anuncioPerteneceAUsuario($anuncio_id)){
            $data = $this->mianuncio_model->ver($anuncio_id);
              if(isset($data['codigo'])){
                $respuesta['respuesta'] = $data['mensaje'];
                $this->load->view('headers/header-html-mianuncio-ver.php');
                $this->load->view('scripts/script-js-general.php');
                $this->load->view('modules/menu');
                $this->load->view('pages/page-pagina-no-existe', $respuesta);
              }else{              
                $datos_anuncio = array('datos_anuncio' => $data);
                $this->load->view('headers/header-html-mianuncio-ver.php');
                $this->load->view('scripts/script-js-general.php');
                $this->load->view('modules/menu');
                $this->load->view('pages/page-anuncio-ver', $datos_anuncio);
                $this->load->view('scripts/script-js-mianuncio-ver.php');    
                $this->load->view('scripts/script-js-carrousel.php');     
                $this->load->view('scripts/script-js-asignar-valores.php'); 
                $this->load->view('scripts/script-js-renovar-anuncio.php');    
                $this->load->view('scripts/script-js-eliminar-anuncio.php');  
                $this->load->view('scripts/script-js-cambiar-estatus-anuncio.php');
              }                
          }else{              
           $respuesta['respuesta'] = 'Este anuncio no te pertenece. Elije uno de la sección Mis Anuncios.';
           $this->load->view('headers/header-html-mianuncio-ver.php');
           $this->load->view('modules/menu');
           $this->load->view('pages/page-pagina-no-existe', $respuesta);
          }            
        }else{
          $respuesta['respuesta'] = 'El ID ingresado en la URL debe ser de 30 caracteres alfanumúmericos.';
          $this->load->view('headers/header-html-mianuncio-ver.php');
          $this->load->view('modules/menu');
          $this->load->view('pages/page-pagina-no-existe', $respuesta);
        }      
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

    function editarAnuncio(){
      /**
       * Recibe datos de un anuncio para editarlo.
       */
      if(isset($_POST['anuncio_editado'])){
        $anuncio_datos = $_POST['anuncio_editado'];  
        if($this->validaciones->anuncioPerteneceAUsuario($anuncio_datos['anuncio_public_id'])){           
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
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, no recibimos datos para la edición.';
        echo json_encode($response);
        die();
      }   
    }

    function obtenerDatosComplementariosEdicionMovil(){
      if(isset($_GET['id']) 
      && $this->validaciones->validarIdAnuncio($_GET['id'])
      && $this->validaciones->anuncioPerteneceAUsuario($_GET['id'])       
      ){  
        $this->mianuncio_model->obtenerDatosComplementariosEdicionMovil($_GET['id']);       
      }else{
        $response['codigo']  = 1;
        $response['mensaje'] = 'Hubo un problema. Intente más tarde';  
        echo json_encode($response);    
        die();        
      }       
    }  

    function verMovil(){
      if(isset($_GET['id'])
       && $this->validaciones->validarIdAnuncio($_GET['id'])
       && $this->validaciones->anuncioPerteneceAUsuario($_GET['id'])       
       ){
          $this->mianuncio_model->verMovil($_GET['id']);
      }else{
        $response['codigo']=1;
        $response['mensaje']="Lo sentimos, no puedes ver esta anuncio. VM953";
        echo json_encode($response);        
        die();
      }       
    }

    function eliminar(){
      if(isset($_POST['id']) && strlen($_POST['id'])==30){
        if($this->validaciones->anuncioPerteneceAUsuario($_POST['id'])){
          $this->mianuncio_model->eliminar($_POST['id']);
         }else{
          $response['codigo']=1;
          $response['mensaje']='Lo sentimos, el anuncio no se pudo eliminar.';
          echo json_encode($response);
          die();
         }        
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, el anuncio no se pudo eliminar.';
        echo json_encode($response);
        die();
      }
    }

    function renovar(){
      if(isset($_POST['anuncio_id']) 
        && $this->validaciones->validarIdAnuncio($_POST['anuncio_id'])
        && $this->validaciones->anuncioPerteneceAUsuario($_POST['anuncio_id'])
        ){         
        $this->mianuncio_model->renovar($_POST['anuncio_id']);          
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, no pudimos renovar tu anuncio. Intenta más tarde.';
        echo json_encode($response);
        die();
      }
    }

    function cambiarEstatus(){
      if(isset($_POST['id']) 
        && $this->validaciones->validarIdAnuncio($_POST['id']) 
        && isset($_POST['estatus_actual'])
      ){         
        if($_POST['estatus_actual']=='ACTIVO' || $_POST['estatus_actual']=='SUSPENDIDO'){
          if($this->validaciones->anuncioPerteneceAUsuario($_POST['id'])){ 
            $this->mianuncio_model->cambiarEstatus($_POST['id'],$_POST['estatus_actual']);
          }else{
            $response['codigo']=1;
            $response['mensaje']='Lo sentimos, el estatus no se pudo cambiar.';
            echo json_encode($response);
            die();
          } 
        }else{
          $response['codigo']=1;
          $response['mensaje']='Lo sentimos, el estatus no pudo cambiarse.';
          echo json_encode($response);
          die();
        } 
      }else{
        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, el estatus no se pudo cambiar.';
        echo json_encode($response);
        die();
      }
    }

    function subirImagenTemporal(){
      /**Guarda imágen subida temporalment, de un anuncio nuevo. */  
      if(isset($_POST['numero_imagen'])
          && in_array($_POST['numero_imagen'], $this->NUMERO_IMAGENES)
          && is_numeric($_POST['numero_imagen'])
          && isset($_POST['anuncio_id'])
          && is_numeric($_POST['anuncio_id'])
          && strlen($_POST['anuncio_id'])==10
          && isset($_FILES["imagen"])
      ){ 
        $anuncio_id = $_POST['anuncio_id']; 
        $numero_imagen = $_POST['numero_imagen']; 
        $imagen_tipo=$_FILES["imagen"]["type"];
        $imagen_tamano = $_FILES['imagen']['size']; 
        $imagen_nombre_temporal = $_FILES['imagen']['name'];           
        
        $imagen_extension = pathinfo($imagen_nombre_temporal, PATHINFO_EXTENSION);

        $imagen_nombre = 'img_'.$numero_imagen.'_'.$anuncio_id."_".date("Y-m-d").'.'.$imagen_extension;

        $imagen_folder_path=$this->ruta_imagenes_temporales.$anuncio_id; 
        $imagen_path       =$this->ruta_imagenes_temporales.$anuncio_id.'/'.$imagen_nombre;  

        //Valida extensión del archivo
        if (in_array($imagen_extension, $this->EXTENSIONES_ARCHIVOS_VALIDAS)) {

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
        var_dump($_POST['numero_imagen'])."<br>";
        var_dump($_POST['anuncio_id'])."<br>";
        var_dump($_FILES["imagen"]);
     
        $response['codigo']= 1;
        $response['mensaje']= 'No recibimos los datos de tu imágen.';    
        echo json_encode($response);
        die();
      }         
    }

    function eliminarImagenTemporal(){ 
      /**Elimina imágen subida temporalment, de un anuncio nuevo. */  

      if($_POST['path_imagen'] && $_POST['path_imagen']!=''){
        $path_imagen = $_POST['path_imagen'];     
        $img_explode =  explode( '/', $path_imagen ); 
        $img_explode_2 =  explode( '?', $img_explode[7]); 
        $nuevo_path_imagen = $this->ruta_imagenes_temporales.$img_explode[6].'/'.$img_explode_2[0]; 
        // $img_explode[6]  es el ID TEMPORAL DE 10 dígitos
        // $img_explode_2[0] es el nombre de la imágen 

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

    function eliminarImagen(){     
      /** Eliminar la imágen de un anuncio que se está editando. */ 

      if(isset($_POST['anuncio_id']) 
        && isset($_POST['numero']) 
        && isset($_POST['path_imagen'])){
        if($this->validaciones->anuncioPerteneceAUsuario($_POST['anuncio_id']) 
          && $this->validaciones->validarIdAnuncio($_POST['anuncio_id'])
          && is_numeric($_POST['numero'])
          && in_array($_POST['numero'], $this->NUMERO_IMAGENES)){
          $numero_imagen = $_POST['numero'];  
          $path_imagen = $_POST['path_imagen'];   
          $path_imagen_explode =  explode( '?', $path_imagen); //explode con '?'
          $path_imagen = $path_imagen_explode[0];         
          $path_imagen_explode =  explode( '/', $path_imagen); //explode con '/'
          $nombre_imagen = $path_imagen_explode[6];
          $public_id = $path_imagen_explode[5];
          $path_imagen = $path_imagen_explode[4]."/".$path_imagen_explode[5]."/".$path_imagen_explode[6];
         
          if(file_exists($path_imagen)){          
              $response = $this->mianuncio_model->eliminarImagen($nombre_imagen,$numero_imagen,$public_id);
              if($response['codigo']==0){
                if(unlink($path_imagen)){
                  $response['codigo']=0;
                  $response['mensaje']='La imágen se eliminó exitosamente.CÓDIGO IM856';
                  echo json_encode($response);
                  die();
                }else{
                  $response['codigo']=1;
                  $response['mensaje']='La imágen no se pudo eliminar. CÓDIGO IM361';
                  echo json_encode($response);
                  die();              }              
              }else{
                $response['codigo']=1;
                $response['mensaje']='La imágen no se pudo eliminar. CÓDIGO IM1553';
                echo json_encode($response);
                die();     
              }                                         
          }else{
            $response['codigo'] = 1;
            $response['mensaje']='La imágen no se pudo eliminar. CÓDIGO IM972';
            echo json_encode($response);
            die();
          }  

        }else{
            $response['codigo'] = 1;
            $response['mensaje']='La imágen no se pudo eliminar. CÓDIGO IM568';
            echo json_encode($response);
            die();
        }
      }else{
        $response['codigo'] = 1;
        $response['mensaje']='La imágen no se pudo eliminar. CÓDIGO IM135';
        echo json_encode($response);
        die();        
      }      
    }

    function guardarImagen(){
      /**Guarda imágen subida, de un anuncio que se está editando. */

      if($this->input->post()){
        $datos_recibidos = $this->input->post();    
        $numero = $datos_recibidos['numero']; 
        $anuncio_id = $datos_recibidos['anuncio_id'];   
        
        if($this->validaciones->anuncioPerteneceAUsuario($anuncio_id) 
          &&  $this->validaciones->validarIdAnuncio($anuncio_id) 
          && is_numeric($numero)
          && in_array($numero, $this->NUMERO_IMAGENES)){
          $imagen_tipo=$_FILES["imagen"]["type"];
          $imagen_tamano = $_FILES['imagen']['size']; 
          $imagen_nombre_temporal = $_FILES['imagen']['name'];  
          $imagen_extension = pathinfo($imagen_nombre_temporal, PATHINFO_EXTENSION);  
          $imagen_nombre = 'img_'.$numero.'_'.$anuncio_id."_".date("Y-m-d").'.'.$imagen_extension;  
          $imagen_folder_path=$this->carpeta_final_anuncio.$anuncio_id; 
          $imagen_path       =$this->carpeta_final_anuncio.$anuncio_id.'/'.$imagen_nombre;    

          //Valida extensión del archivo
          if (in_array($imagen_extension, $this->EXTENSIONES_ARCHIVOS_VALIDAS)) {

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
                $this->mianuncio_model->guardarImagen($numero,$anuncio_id,$imagen_nombre,$imagen_path);
              }else{
                $response['codigo']= 3;
                $response['mensaje']='hubo un problema al subir su imágen. Intente otra. CÓDIGO 975';
                echo json_encode($response);
                die();
              }           
            }else{
              $response['codigo']= 2;
              $response['mensaje']=  'La imágen es demasiado grande. Máximo 5 MB. CÓDIGO 933';
              echo json_encode($response);
              die();
            }              
          }else{

            $response['codigo']= 1;
            $response['mensaje']= 'Elige una imágen con extensión JPG, JPEG, PNG. CÓDIGO 998';
            echo json_encode($response);
            die();
          } 

        }else{
          $response['codigo']= 1;
          $response['mensaje']= 'No recibimos los datos de tu imágen. CÓDIGO 912';    
          echo json_encode($response);
          die();
        } 
      }else{
        $response['codigo']= 1;
        $response['mensaje']= 'No recibimos los datos de tu imágen. CÓDIGO 952';    
        echo json_encode($response);
        die();
      }         
    }
}
?>