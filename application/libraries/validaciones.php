<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Validaciones {

    protected $CI;

    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->library('sesiones');
        $this->CI->sesiones->usuarioEstaEnSesion();         
        $this->CI->load->library('sanitize');
        $this->CI->load->database(); //cargar base de datos
        $this->CI->load->model('validaciones_model');
        $this->CI->MENSAJES = [
          'ciudad' => 'Selecciona una ciudad válida.',
          'estado' => 'Selecciona un estado válido.',
          'modalidad' => 'Selecciona una modalidad válida.',
          'seccion' => 'Selecciona una sección válida.',
          'apartado' => 'Selecciona un apartado válido.',
          'titulo_vacio' => 'Necesitas ingresar un título para tu anuncio.',
          'titulo_largo' => 'El título de tu anuncio es demasiado largo. Edítalo.',
          'mensaje_vacio' => 'Necesitas ingresar un mensaje para tu anuncio.',
          'mensaje_largo' => 'El mensaje de tu anuncio es demasiado largo. Edítalo.',          
          'telefono' => 'Ingresa un número de teléfono fijo válido. Edítalo.',
          'telefono_digitos' => 'El número de teléfono fijo debe ser de 10 dígitos. Edítalo.',
          'celular' => 'Ingresa un número de celular válido. Edítalo.',
          'celular_digitos' => 'El número de celular debe ser de 10 dígitos. Edítalo.',
          'correo' => 'Ingresa un correo/email válído. Edítalo.',
        ];

    }

    function validarIdAnuncio($id_anuncio){
      if(strlen($id_anuncio)==30){
        return true;
      }else{
        return false;
      }      
    }

    public function validaTitulo($titulo,$objeto){   
      //Valida y sanitiza el título del anuncio
      if($titulo==''){  
        $response['codigo'] = 1;
        $response['mensaje']= $this->CI->MENSAJES['titulo_vacio'];    
        $response['objeto'] = $objeto;          
        echo json_encode($response); 
        die();
      }else{
        if(strlen($titulo)<100){          
          return $this->CI->sanitize->sanitizeString($titulo);
        }else{
       
          $response['codigo']  = 1;
          $response['mensaje'] = $this->CI->MENSAJES['titulo_largo'];
          $response['objeto'] = $objeto;   
          echo json_encode($response);  
          die();     
        } 
      }
    }    
    
     function validaMensaje($mensaje,$objeto){   
      //Valida y sanitiza el mensaje del anuncio
      if($mensaje==''){  
        $response['codigo'] = 1;
        $response['mensaje']= $this->CI->MENSAJES['mensaje_vacio']; 
        $response['objeto'] = $objeto;             
        echo json_encode($response); 
        die();
      }else{
        if(strlen($mensaje)<=1200){ 
          $mensaje = $this->sanitizeString($mensaje);
          return $mensaje;
        }else{
          $response['codigo']  = 1;
          $response['mensaje'] = $this->CI->MENSAJES['mensaje_largo'];  
          $response['objeto'] = $objeto;   
          echo json_encode($response);    
          die();   
        } 
      }  
    }  
    
    function existeValor($valor,$objeto){
      /**
       * Verifica si existe un valor en la base de datos.
       * P.ej.: Si el Estado ingresado existe en la lista de estados de la bdd
       */   

      if($this->CI->validaciones_model->existeValorModel($valor, $objeto)){
      }else{
        $response['codigo']  = 1;
        $response['mensaje'] = $this->CI->MENSAJES["$objeto"];  
        echo json_encode($response);    
        die(); 
      }
    }

    function obtenerSigla($valor,$objeto){
      /**
       * Obtiene la sigla de una CIUDAD, ESTADO, SECCION, APARTADO
       * Requiere el nombre. 
       * P.eje.: 'Chihuahua'. Devuelve 'CHH'
       */   

      if($sigla = $this->CI->validaciones_model->obtenerSigla($valor,$objeto)){
        if($sigla!=''){
          return $sigla;
        }else{
          return 'INDEF';
        }    
      }else{
        $response['codigo']  = 1;
        $response['mensaje'] = 'No se pudo obtener una sigla.';  
        echo json_encode($response);    
        die(); 
      }
    }

    function obtenerNombre($valor,$objeto){
      /**
       * Obtiene la sigla de una CIUDAD, ESTADO, SECCION, APARTADO
       * Requiere el nombre. 
       * P.eje.: 'Chihuahua'. Devuelve 'CHH'
       */   

      if($sigla = $this->CI->validaciones_model->obtenerNombre($valor,$objeto)){
        if($sigla!=''){
          return $sigla;
        }else{
          return 'INDEF';
        }    
      }else{
        $response['codigo']  = 1;
        $response['mensaje'] = 'No se pudo obtener el nombre de la sigla.';
        echo json_encode($response);    
        die(); 
      }
    }

    function anuncioPerteneceAUsuario($anuncio_id){
        /**
       * Valida si un anuncio pertenece a un usuario
       * Recibe ID de anuncio y ID de usuario
       * Devuelve TRUE o FALSE
       */   
      if($pertenece = $this->CI->validaciones_model->anuncioPerteneceAUsuario($anuncio_id)){
        return $pertenece;
      }else{
        return FALSE;
      }
    }

    function validaTelefono($telefono,$objeto){
      /**
       * Valida un número de teléfono a 10 dígitos.
       * No es obligatorio. Si está vació el string, será exitoso.
       */

      if(strlen($telefono)!=0){ 
        if(strlen($telefono)==10){
          if(is_numeric($telefono)){
          }else{
            $response['codigo']  = 1;
            $response['mensaje'] = $this->CI->MENSAJES["$objeto"];  
            $response['objeto'] = $objeto;  
            echo json_encode($response);    
            die(); 
          }
        }else{
          $response['codigo']  = 1;
          $response['mensaje'] = $this->CI->MENSAJES["$objeto"."_digitos"];
          $response['objeto'] = $objeto;    
          echo json_encode($response);    
          die(); 
        }
      }

    }

    function validaCorreo($correo,$objeto){
      /**
       * Valida un email.
       * No es obligatorio. Si está vació el string, será exitoso.
       */

      if(strlen($correo)!=0){            
        if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
        }else{
          $response['codigo']  = 1;
          $response['mensaje'] = $this->CI->MENSAJES["$objeto"];  
          $response['objeto'] = $objeto;   
          echo json_encode($response);    
          die(); 
        }
      }
    }

    function generarPublicId(){            
      $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';   
      if($public_id = substr(str_shuffle($str_result), 0, 30)){
          return $public_id;
      }else{
          $response['codigo']  = 1;
          $response['mensaje'] = 'Lo sentimos, hubo un problema al intentar publicar tu anuncio. Intenta más tarde.';  
          echo json_encode($response);    
          die();    
      }           
    }        

    function estatusTexto($estatus_numero){
      $estatus_numero==0 ? $estatus_texto = 'ACTIVO' : '';
      $estatus_numero==1 ? $estatus_texto = 'SUSPENDIDO' : '';
      $estatus_numero==2 ? $estatus_texto = 'ELIMINADO' : '';
      return $estatus_texto;

    }

    function creaFechaConFormato($fech_sin_formato){
      //Crea una fecha con hora, con formato.
      //Recibe '2020-06-07 03:29:44'
      
      $fecha = substr($fech_sin_formato, 0, 10);
      $hora = explode(" ", $fech_sin_formato);      
      $numeroDia = date('d', strtotime($fecha));
      $dia = date('l', strtotime($fecha));
      $mes = date('F', strtotime($fecha));
      $anio = date('Y', strtotime($fecha));
      $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
      $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
      $nombredia = str_replace($dias_EN, $dias_ES, $dia);
      $meses_ES = array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
      $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
      $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
      //return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
      return $numeroDia."/".$nombreMes."/".$anio.' '.$hora[1];

    }

    function disponibleParaRenovar($renovado){
      /**
       * Recibe datetime CREADO y RENOVADO
       * Tiene que haber diferencia de 24 horas para poder renovar otra vez
       */
      
      $segundos_renovado = StrToTime($renovado);
      $segundos_actual = StrToTime(date("Y-m-d H:i:s"));   
      
      $diferencia = $segundos_actual - $segundos_renovado;
      $horas = $diferencia / ( 60 * 60 );
      if($horas>24){
        return 0;
      }else{
        return 1;
      } 
    }
}

?>