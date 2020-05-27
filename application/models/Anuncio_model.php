<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database(); //cargar base de datos
        $this->ruta_imagenes_anuncios = "imagenes_anuncios/"; 
    }
                 
                
    function publicar($nuevo_anuncio, $public_id){        

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
            'creado'=> date("Y-m-d H:i:s"), 
            'usuario_id'=> 111, 
            'img_1'=> $nuevo_anuncio->img_1,
            'img_2'=> $nuevo_anuncio->img_2,
            'img_3'=> $nuevo_anuncio->img_3,
            'img_4'=> $nuevo_anuncio->img_4,
            'img_5'=> $nuevo_anuncio->img_5,
            'img_6'=> $nuevo_anuncio->img_6,
            'img_7'=> $nuevo_anuncio->img_7,
            'img_8'=> $nuevo_anuncio->img_8,
            'img_9'=> $nuevo_anuncio->img_9,
            'img_10'=> $nuevo_anuncio->img_10,      
            );

            if($this->db->insert('anuncios',$data)){
             $insert_id = $this->db->insert_id();             
             $this->moverImagenes($nuevo_anuncio,$insert_id,$public_id);

                return  'publicado_OK';

            }else{
                return 'publicado_ERROR';
            }         
        }

        function moverImagenes($nuevo_anuncio,$insert_id,$public_id){     
            /**Mueve imágenes de imagenes_temporales a imagenes_anuncios
             * También cambia el nombre de las imagenes
             * Y actualiza el registro para ingresar el nuevo nombre de las imágenes */       
         
            $imagen_folder_path=$this->ruta_imagenes_anuncios.$public_id.'/'; 

              //Si no existe el folder, lo crea
                if(!(file_exists($imagen_folder_path))){
                    mkdir($imagen_folder_path, 0700);
                }

                  //Si existe imagen previa...
                if(file_exists($nuevo_anuncio->img_1)){

                    //Cambiar nombre
                    $actual_path_imagen = explode("/", $nuevo_anuncio->img_1);
                    $nombre_imagen = $actual_path_imagen[7];                    
                    $nuevo_nombre_imagen = $imagen_folder_path. $nombre_imagen;
                    rename($nuevo_anuncio->img_1, $nuevo_nombre_imagen);
                    
                    
                    //Mover a nueva carpeta


                }




      


        }

        function generarPublicId(){            
            $str_result = '#$0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';             
            return substr(str_shuffle($str_result), 0, 30); 
        }




    }

?>
