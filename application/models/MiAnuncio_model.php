<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MiAnuncio_model extends CI_Model {

    function __construct(){
        parent::__construct();

        $this->load->library('sesiones');
        $this->sesiones->usuarioEnSesion(); 

        $this->load->database(); //cargar base de datos
        $this->carpeta_final_anuncio = "imagenes_anuncios/"; 
        $this->carpeta_temporal_anuncio = "imagenes_temporales/anuncios/"; 
        $this->TABLAS = [
        'ciudad' => 'cat_municipios',
        'estado' => 'cat_estados',
        'modalidad' => 'cat_modalidades',
        'seccion' => 'cat_secciones',
        'apartado' => 'cat_apartados'];

        $this->USUARIO_EN_SESSION_ID = 111;

    }
                     
    function publicar($anuncio_datos){
        $data = array(  
            'public_id'=>$anuncio_datos['public_id'],
            'titulo'=> $anuncio_datos['titulo'],
            'mensaje'=> $anuncio_datos['mensaje'], 
            'modalidad'=> $anuncio_datos['modalidad'], 
            'estado'=> $anuncio_datos['estado'],
            'ciudad'=> $anuncio_datos['ciudad'],
            'seccion'=> $anuncio_datos['seccion'],
            'apartado'=> $anuncio_datos['apartado'], 
            'telefono'=> $anuncio_datos['telefono'], 
            'celular'=> $anuncio_datos['celular'],
            'correo'=> $anuncio_datos['correo'],            
            'creado'=> date("Y-m-d H:i:s"), 
            'usuario_id'=> $anuncio_datos['usuario'] ,               
            );

        $data_imagenes = array(                
            'img_1'=> $anuncio_datos['img_1'],
            'img_2'=> $anuncio_datos['img_2'],
            'img_3'=> $anuncio_datos['img_3'],
            'img_4'=> $anuncio_datos['img_4'],
            'img_5'=> $anuncio_datos['img_5'],
            'img_6'=> $anuncio_datos['img_6'],
            'img_7'=> $anuncio_datos['img_7'],
            'img_8'=> $anuncio_datos['img_8'],
            'img_9'=> $anuncio_datos['img_9'],
            'img_10'=> $anuncio_datos['img_10'],      
        );

        if($this->db->insert('anuncios',$data)){
            $id_bdd= $this->db->insert_id(); 
            $estaVacio = count(array_unique($data_imagenes))===1;

            if($estaVacio==FALSE){ //Si el array NO ESTA VACIO, procede a almacenar las imagenes que tiene
                $this->moverImagenes($data_imagenes,$id_bdd,$anuncio_datos['public_id']);
                $response['codigo']=0;
                $response['mensaje']='Tu anuncio ya se publicó. ¿A dónde quieres ir?';
                echo json_encode($response);
                die();
            }else{
                $response['codigo']=0;
                $response['mensaje']='Tu anuncio ya se publicó. ¿A dónde quieres ir?';
                echo json_encode($response);
                die();
            }
        }else{
            $response['codigo']=1;
            $response['mensaje']='Lo sentimos, hubo un problema al intentar publicar tu anuncio. Intenta más tarde.';
            echo json_encode($response);
            die();
        }         
    }

    function editar($anuncio_datos){
        $datos = array(  
            'titulo'=> $anuncio_datos['titulo'],
            'mensaje'=> $anuncio_datos['mensaje'], 
            'modalidad'=> $anuncio_datos['modalidad'], 
            'estado'=> $anuncio_datos['estado'],
            'ciudad'=> $anuncio_datos['ciudad'],
            'seccion'=> $anuncio_datos['seccion'],
            'apartado'=> $anuncio_datos['apartado'], 
            'telefono'=> $anuncio_datos['telefono'], 
            'celular'=> $anuncio_datos['celular'],
            'correo'=> $anuncio_datos['correo'],         
            'actualizado'=> date("Y-m-d H:i:s"), 
            );

        $this->db->where('public_id',$anuncio_datos['anuncio_public_id']);
        $this->db->where('usuario_id',$this->USUARIO_EN_SESSION_ID);
        $this->db->where('sta',0);
        $this->db->or_where('sta',1);
        
            if($this->db->update('anuncios', $datos)){
                $response['codigo']  = 0;
                $response['mensaje'] = 'Su anuncio se actualizó correctamente.';  
                echo json_encode($response);    
                die(); 
            }else{
                $response['codigo']  = 1;
                $response['mensaje'] = 'Lo sentimos, hubo un problema al intentar actualizar su anuncio. Intente más tarde o repórtelo por favor.';  
                echo json_encode($response);    
                die(); 
            }
    }

    function moverImagenes($data_imagenes,$id_bdd,$public_id){     
            /** Mueve imágenes de imagenes_temporales a imagenes_anuncios
             * Crea folder final
             * Actualiza el registro para ingresar el  nombre de las imágenes 
             * Elimina folder temporal
             * */       
                     
            for ($i=1; $i < (count($data_imagenes)+1) ; $i++) { 

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

            if(file_exists($path_folder_temporal)){
                //Remover folder temporal
                rmdir($path_folder_temporal); 
            }   
    }  

    function obtenerDatosAnuncioPublico($anuncio_id){
            $this->db->select('public_id, titulo, mensaje, estado,ciudad,modalidad,seccion,apartado,telefono,celular,correo,img_1,img_2,img_3,img_4,img_5,img_6,img_7,img_8,img_9,img_10');
            $query = $this->db->get_where('anuncios', array('public_id' => $anuncio_id));
                        
            if($query->num_rows() > 0){
                $datos_anuncio = $query->row_array();

                //Definir Estado
                $datos_anuncio['estado'] = $this->db->get_where('cat_estados', array('sigla' => $datos_anuncio['estado']))->row()->nombre;
               
                //Definir Ciudad
                $datos_anuncio['ciudad'] = $this->db->get_where('cat_municipios', array('sigla' => $datos_anuncio['ciudad']))->row()->nombre;

                //Definir Seccion
                $datos_anuncio['seccion'] = $this->db->get_where('cat_secciones', array('sigla' => $datos_anuncio['seccion']))->row()->nombre;

                //Definir Apartado
                $datos_anuncio['apartado'] = $this->db->get_where('cat_apartados', array('sigla' => $datos_anuncio['apartado']))->row()->nombre;



                //Definir nombre de imagen
                for ($i=1; $i < 11; $i++) { 
                    if($datos_anuncio["img_$i"]!=''){
                        $datos_anuncio["img_$i"] = $this->carpeta_final_anuncio.$datos_anuncio['public_id'].'/'.$datos_anuncio["img_$i"];
                    }
                }

                return $datos_anuncio;
            } else {
                return null;
            }
    
    }   
}
?>
