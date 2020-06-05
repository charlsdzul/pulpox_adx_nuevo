<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validaciones {

    public function validaTitulo($titulo){
        if(strlen($titulo)=='' ){  
            $response['codigo'] = 1;
            $response['mensaje']= 'Necesita ingresar un título para su anuncio.';           
            echo json_encode($response); 
            die();
          }else{
            if(strlen($titulo)<=50 ){ 
              $titulo = $this->sanitize($titulo);
              return $titulo;
            }else{
              $response['codigo']  = 1;
              $response['mensaje'] = 'Título demasiado largo. Edite.';  
              echo json_encode($response);  
              die();     
            } 
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