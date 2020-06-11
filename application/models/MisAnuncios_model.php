<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
        $res =$this->db->select("*")->order_by('creado', 'DESC')->where("usuario_id",111)->get('anuncios');
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
}
?>