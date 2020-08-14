<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validaciones_model extends CI_Model {

    function __construct(){
        parent::__construct();

        //$this->load->library('sesiones');
        //$this->sesiones->usuarioEstaEnSesion(); 
        $this->USUARIO_EN_SESSION_ID = $this->sesiones->usuarioEnSesion();
        $this->load->database(); 
        $this->TABLAS = [
            'ciudad' => 'cat_municipios',
            'estado' => 'cat_estados',
            'modalidad' => 'cat_modalidades',
            'seccion' => 'cat_secciones',
            'apartado' => 'cat_apartados'];
    }
   
    function existeValorModel($valor,$objeto){   
       /**
       * Verifica si existe un valor en la base de datos.
       * P.ej.: Si el Estado ingresado existe en la lista de estados de la bdd
       */       

      $TABLAS = [
        'ciudad' => 'cat_municipios',
        'estado' => 'cat_estados',
        'modalidad' => 'cat_modalidades',
        'seccion' => 'cat_secciones',
        'apartado' => 'cat_apartados'
      ];

      $query = $this->db->where('nombre',$valor)->get($TABLAS["$objeto"]);
      if ($query->num_rows() > 0){
          return true;
      }
      else{
        return false;
      }
     
    }

    function obtenerNombre($valor,$objeto){
        if($nombre = $this->db->get_where($this->TABLAS["$objeto"], array('sigla' =>  $valor))->row()->nombre){ 
            return $nombre;     
        }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'No se pudo obtener el nombre de la sigla.';  
            echo json_encode($response);    
            die(); 
        }
    }

    function obtenerSigla($valor,$objeto){
        if($nombre = $this->db->get_where($this->TABLAS["$objeto"], array('nombre' =>  $valor))->row()->sigla){ 
            return $nombre;     
        }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'No se pudo obtener la sigla.';  
            echo json_encode($response);    
            die(); 
        }
    }

    function obtenerNombreDeFrase($valor){
        if($nombre = $this->db->get_where($this->TABLAS["modalidad"], array('frase' =>  $valor))->row()->nombre){ 
            return $nombre;     
        }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'No se pudo obtener el nombre de la frase.2';  
            echo json_encode($response);    
            die(); 
        }
    }

    function anuncioPerteneceAUsuario($anuncio_id){
        if($query = $this->db->where('public_id',$anuncio_id)->where('usuario_id',$this->USUARIO_EN_SESSION_ID)->get('anuncios')){ 
            if($query->num_rows() > 0){
                return TRUE;
            }else{
                return FALSE;
            }               
        }else{
            $response['codigo']  = 1;
            $response['mensaje']  = 'No se pudo validar anuncio/usuario.';
            echo json_encode($response);    
            die(); 
        }
    }
}
?>
