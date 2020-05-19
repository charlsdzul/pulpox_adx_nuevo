<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database(); //cargar base de datos
    }
                 
                
    function publicar($nuevo_anuncio, $public_id){ 

         //Recibe un objeto como string

        //var_dump($nuevo_anuncio);

        $data = array(  
            'public_id'=>$public_id,
            'titulo'=> $nuevo_anuncio->titulo,
            'anuncio'=> $nuevo_anuncio->anuncio, 
            'estado'=> $nuevo_anuncio->estado,
            'ciudad'=> $nuevo_anuncio->ciudad,
            'seccion'=> $nuevo_anuncio->seccion,
            'apartado'=> $nuevo_anuncio->apartado, 
            'telefono'=> $nuevo_anuncio->telefono, 
            'celular'=> $nuevo_anuncio->celular,
            'correo'=> $nuevo_anuncio->correo,
            'creado'=> date("Y-m-d"), 
            'usuario_id'=> 111, 
            );

            if($this->db->insert('anuncios',$data)){
            // $insert_id = $this->db->insert_id();
                return  'publicado_OK';
            }else{
                return 'publicado_ERROR';
            }         
        }

        function generarPublicId(){            
            $str_result = '#$0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';             
            return substr(str_shuffle($str_result), 0, 30); 
        }

    }

?>
