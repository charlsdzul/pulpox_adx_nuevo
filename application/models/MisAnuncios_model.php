<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database(); //cargar base de datos
    }                 
                
    function obtenerMisAnuncios(){        
        $this->db->select("*");
        $this->db->order_by('creado', 'DESC');
        $this->db->where("usuario_id",111);
        $res = $this->db->get('anuncios');
        $j=0;
        foreach ($res->result() as $row){
            $misanuncios[$j]['public_id'] = $row->public_id;
            $misanuncios[$j]['titulo'] = $row->titulo;
            $misanuncios[$j]['modalidad'] = $row->modalidad;
            //Definir Estado
            $misanuncios[$j]['estado'] = $this->db->get_where('cat_estados', array('sigla' => $row->estado))->row()->nombre;        
            //Definir Ciudad
            $misanuncios[$j]['ciudad'] = $this->db->get_where('cat_municipios', array('sigla' => $row->ciudad))->row()->nombre;  
            //Definir Seccion
            $misanuncios[$j]['seccion'] = $this->db->get_where('cat_secciones', array('sigla' => $row->seccion))->row()->nombre;  
              //Definir Apartado
            $misanuncios[$j]['apartado'] = $this->db->get_where('cat_apartados', array('sigla' => $row->apartado))->row()->nombre;
            $misanuncios[$j]['creado'] = $row->creado;
            $row->sta==0 ? $misanuncios[$j]['estatus'] = 'ACTIVO' : '';
            $row->sta==1 ? $misanuncios[$j]['estatus'] = 'INACTIVO' : '';
            $row->sta==2 ? $misanuncios[$j]['estatus'] = 'ELIMINADO' : '';
            $j++;
        }          
        return $misanuncios;    
    } 

    function obtenerDatosParaEdicionMovil($publid_id){        
        $this->db->select("*");
        $this->db->where("public_id",$publid_id);
        $res = $this->db->get('anuncios');
        foreach ($res->result() as $row){
            $misanuncio['anuncio'] = $row->anuncio;
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
     
            $row->sta==0 ? $misanuncio['estatus'] = 'ACTIVO' : '';
            $row->sta==1 ? $misanuncio['estatus'] = 'INACTIVO' : '';
            $row->sta==2 ? $misanuncio['estatus'] = 'ELIMINADO' : '';
            
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

}

?>
