<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Anuncio_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->library('sesiones');    
        $this->load->library('validaciones');
        $this->load->database(); 
        $this->load->helper('url');
        $this->carpeta_final_anuncio = "imagenes_anuncios/"; 
    }  

    function ver($anuncio_id){
        $this->db->select('sta, public_id, titulo, mensaje, estado,ciudad,modalidad,seccion,apartado,telefono,celular,correo,img_1,img_2,img_3,img_4,img_5,img_6,img_7,img_8,img_9,img_10,sta,creado,editado,renovado')
        ->where("sta=0")->where('public_id', $anuncio_id);
        
        if($query= $this->db->get('anuncios')){
            if($query->num_rows() > 0){
                $datos_anuncio = $query->row_array(); 
                $datos_anuncio['anuncio_id'] = htmlspecialchars($datos_anuncio['public_id']);
                $datos_anuncio['titulo'] = htmlspecialchars($datos_anuncio['titulo']);
                 $datos_anuncio['mensaje'] = htmlspecialchars($datos_anuncio['mensaje']);
               //var_dump($datos_anuncio['mensaje']);
               $datos_anuncio['modadalidad'] = $datos_anuncio['modalidad'];

                $datos_anuncio['creado'] = $this->validaciones->creaFechaConFormato($datos_anuncio['creado']);
                $datos_anuncio['estado'] = $this->validaciones->obtenerNombre($datos_anuncio['estado'], 'estado');
                $datos_anuncio['ciudad'] = $this->validaciones->obtenerNombre($datos_anuncio['ciudad'], 'ciudad');
                $datos_anuncio['seccion'] = $this->validaciones->obtenerNombre($datos_anuncio['seccion'], 'seccion');
                $datos_anuncio['apartado'] = $this->validaciones->obtenerNombre($datos_anuncio['apartado'], 'apartado');
                //$datos_anuncio['estatus'] = $this->validaciones->estatusTexto($datos_anuncio['sta']);                        
                $datos_anuncio['sta']==0 ? $datos_anuncio['renovar'] = $this->validaciones->disponibleParaRenovar($datos_anuncio['renovado']):$datos_anuncio['renovar'] = 1;                                        
                //$datos_anuncio['renovado'] == '0000-00-00 00:00:00' ? $datos_anuncio['renovado']= 'NUNCA' : $datos_anuncio['renovado'] = $this->validaciones->creaFechaConFormato($datos_anuncio['renovado']);   
                //$datos_anuncio['editado']== '0000-00-00 00:00:00' ? $datos_anuncio['editado']= 'NUNCA' : $datos_anuncio['editado'] = $this->validaciones->creaFechaConFormato($datos_anuncio['editado']);
                //$datos_anuncio['publicado'] ==  $this->validaciones->creaFechaConFormato($datos_anuncio['publicado']);
             
                //Definir path/nombre de imagen
                for ($i=1; $i < 11; $i++) { 
                    if($datos_anuncio["img_$i"]!=''){
                        $datos_anuncio["img_$i"] = $this->carpeta_final_anuncio.$datos_anuncio['public_id'].'/'.$datos_anuncio["img_$i"];
                    }
                }          
                return $datos_anuncio;
            } else {
                $response['codigo']=1;
                $public_link = $this->BASE_URL.'anuncio/'.$anuncio_id;
                $response['mensaje']="Lo sentimos, este anuncio no te pertenece o no existe.";
                return $response;
            }
        }else{
            $response['codigo']=1;
            $public_link = $this->BASE_URL.'anuncio/'.$anuncio_id;
            $response['mensaje']="Lo sentimos, no pudimos mostrarte tu anuncio. Intenta más tarde.";
            return $response;
        }                        
            
}





}