<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database(); //cargar base de datos
        $this->carpeta_final_anuncio = "imagenes_anuncios/"; 
        $this->carpeta_temporal_anuncio = "imagenes_temporales/anuncios/"; 
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
            );

        $data_imagenes = array(                
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
            $id_bdd= $this->db->insert_id();    
            $response = $this->moverImagenes($data_imagenes,$id_bdd,$public_id);
            return  'publicado_OK';

        }else{
                return 'publicado_ERROR';
        }         
    }

    function moverImagenes($data_imagenes,$id_bdd,$public_id){     
            /** Mueve imágenes de imagenes_temporales a imagenes_anuncios
             * Crea folder final
             * Actualiza el registro para ingresar el  nombre de las imágenes 
             * Elimina folder temporal
             * */       
                     
            for ($i=1; $i < 11 ; $i++) { 

                if($data_imagenes["img_$i"]!=''){   

                    /*Ejemplo:
                    *Se recibe $nuevo_anuncio->img_1
                    *Contiene: http://[::1]/pulpox_ads_nuevo/imagenes_temporales/anuncios/1326999116/img_1_1326999116_2020-05-28.jpg?timestamp=1590630012411
                    */

                    //Quitar ?timestamp=1590630012411
                    //Ahora contiene: http://[::1]/pulpox_ads_nuevo/imagenes_temporales/anuncios/1326999116/img_1_1326999116_2020-05-28.jpg
                    $img_explode_timestamp= explode('?',$data_imagenes["img_$i"]);
                    $data_imagenes["img_$i"] = $img_explode_timestamp[0];    

                    //Quitar http://[::1]/pulpox_ads_nuevo
                    //Ahora contiene: imagenes_temporales/anuncios/1326999116/img_1_1326999116_2020-05-28.jpg
                    $img_explode= explode('/',$data_imagenes["img_$i"]);   
                    $path_folder_imagen_temporal = $this->carpeta_temporal_anuncio.$img_explode[6].'/'.$img_explode[7];                  

                    //Obtener path de imagen temporal
                    //Contiene: imagenes_temporales/anuncios/1326999116/
                    $path_folder_temporal = $this->carpeta_temporal_anuncio.$img_explode[6].'/';             

                    //Obtener nombre de imagen temporal
                    //Contiene: img_1_1326999116_2020-05-28.jpg
                    $nombre_imagen = $img_explode[7]; 

                    //Crear path de imagen nuevo (usa el $public_id)
                    //Contiene: imagenes_anuncios/w#hLjU2SOboqtGnxuVFcJRrYMT9KB0/
                    $path_folder_nuevo = $this->carpeta_final_anuncio.$public_id.'/';  

                    //Crear path de folder con imágen (usa el $public_id)
                    //Contiene: imagenes_anuncios/anuncios/w#hLjU2SOboqtGnxuVFcJRrYMT9KB0/img_1_1058551293_2020-05-28.jpg
                    $path_folder_imagen_nuevo = $path_folder_nuevo.$nombre_imagen;   
               
                        //Si no existe el path_folder_nuevo, lo crea.
                        if(!(file_exists($path_folder_nuevo))){
                            mkdir($path_folder_nuevo, 0700);
                        }

                        //Si existe imagen previa en path_temporal
                        if(file_exists($path_folder_imagen_temporal)){

                            //Mover a carpeta imagenes_anuncios. 
                            if(rename($path_folder_imagen_temporal, $path_folder_imagen_nuevo)){
                                //En caso de moverse exitosamente...                                

                                //Actualizar registro y guardar el nombre de imágen
                                $this->db->set("img_$i", $nombre_imagen);
                                $this->db->where('id', $id_bdd);

                                if( $this->db->update('anuncios')){

                                }else{

                                }

                            }
                            else{
                            }
                        }
                }
            }  

            //Remover folder temporal
            rmdir($path_folder_temporal); 

        }

        function generarPublicId(){            
            $str_result = '#$0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';             
            return substr(str_shuffle($str_result), 0, 30); 
        }


        function obtenerDatosAnuncioPublico($anuncio_id){
            $this->db->select('titulo, anuncio, estado,ciudad,seccion,apartado,telefono,celular,correo,img_1,img_2,img_3,img_4,img_5,img_6,img_7,img_8,img_9,img_10');
            $query = $this->db->get_where('anuncios', array('public_id' => $anuncio_id));
            
            if($query->num_rows() > 0){
                return $query->row_array();
            } else {
                return null;
            }
    
        }


    }




?>
