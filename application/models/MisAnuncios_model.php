<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->library('sesiones');
        $this->sesiones->usuarioEnSesion(); 
        $this->load->library('validaciones');
        $this->load->database(); //cargar base de datos
        $this->load->helper('url'); 
    }  

    function obtenerMisAnuncios(){        
        $this->db->select("*");
        $this->db->order_by('creado', 'DESC');
        $this->db->where("usuario_id",111);
        $res = $this->db->get('anuncios');
        $misanuncios=[]; 
        $j=0;
       
        foreach ($res->result() as $row){
            $misanuncios[$j]['public_id'] = $row->public_id;
            $misanuncios[$j]['titulo'] = $row->titulo;
            $misanuncios[$j]['modalidad'] = $row->modalidad;
            $misanuncios[$j]['estado'] = $this->validaciones->obtenerNombre($row->estado, 'estado');
            $misanuncios[$j]['ciudad'] = $this->validaciones->obtenerNombre($row->ciudad, 'ciudad');
            $misanuncios[$j]['seccion'] = $this->validaciones->obtenerNombre($row->seccion, 'seccion');
            $misanuncios[$j]['apartado'] = $this->validaciones->obtenerNombre($row->apartado, 'apartado');
            $misanuncios[$j]['creado'] = $this->validaciones->creaFechaConFormato($row->creado);
            $misanuncios[$j]['estatus'] = $this->validaciones->estatusTexto($row->sta);
            $j++;
        }          

        return $misanuncios;          
    } 
      

    function obtenerDatosParaEdicionMovil($publid_id){        
        $this->db->select("*");
        $this->db->where("public_id",$publid_id);
        $res = $this->db->get('anuncios');
        foreach ($res->result() as $row){
            $misanuncio['mensaje'] = $row->mensaje;
            $misanuncio['telefono'] = $row->telefono;
            $misanuncio['celular'] = $row->celular;
            $misanuncio['correo'] = $row->correo;
            $misanuncio['celular'] = $row->celular;
            $misanuncio['img_1'] = $row->img_1;
            $misanuncio['img_2'] = $row->img_2;
            $misanuncio['img_3'] = $row->img_3;
            $misanuncio['img_4'] = $row->img_4;
            $misanuncio['img_5'] = $row->img_5;
            $misanuncio['img_6'] = $row->img_6;
            $misanuncio['img_7'] = $row->img_7;
            $misanuncio['img_8'] = $row->img_8;
            $misanuncio['img_9'] = $row->img_9;
            $misanuncio['img_10'] = $row->img_10;

            $misanuncio['estatus'] = $this->validaciones->estatusTexto($row->sta);
        }          

        return $misanuncio;    
    } 

    function eliminarImagen($nombre_imagen,$numero_imagen,$public_id){  

        $response['codigo']=1;
        $response['mensaje']='Lo sentimos, la imágen no se pudo eliminar.';


        $campo = "img_".$numero_imagen;
        $data = array(
            $campo => '',
         );
        $this->db->where('usuario_id', 111);
        $this->db->where('public_id', $public_id);
        
            if($this->db->update('anuncios', $data)){
                $response['codigo']=0;
                $response['mensaje']='Se ha eliminado a imágen.';
            } 
        return $response;    
    } 

    function obtenerDatosAnuncioMovil($public_id){
        $this->db->select('public_id, titulo, mensaje, estado,ciudad,modalidad,seccion,apartado,telefono,celular,correo,img_1,img_2,img_3,img_4,img_5,img_6,img_7,img_8,img_9,img_10');
        $query = $this->db->get_where('anuncios', array('public_id' => $public_id));
                    
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

            $datos_anuncio['apartado'] = $this->validaciones->creaFechaConFormato($row->creado);



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
