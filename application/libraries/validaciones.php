<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validaciones {
    protected $CI;

    public function __construct(){
        $this->CI =& get_instance();
        /**
         * LIBRARIES:
         * $this->CI->sanitize->sanitizeString($titulo);
         */
    }

    public function validaTitulo($titulo){   
        if(strlen($titulo)=='' ){  
            $response['codigo'] = 1;
            $response['mensaje']= 'Necesita ingresar un título para su anuncio.';           
            echo json_encode($response); 
            die();
          }else{
            if(strlen($titulo)<=5 ){ 
              $titulo = $this->CI->sanitize->sanitizeString($titulo);
              return $titulo;
            }else{
              $response['codigo']  = 1;
              $response['mensaje'] = 'Título demasiado largo. Edite.';  
              echo json_encode($response);  
              die();     
            } 
          }
    }    
    

        
}