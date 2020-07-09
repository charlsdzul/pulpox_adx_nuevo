<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database(); //cargar base de datos
    } 

    function obtenerEstados(){   
        $misanuncios = $this->db->select("nombre")->where("sta",0)->order_by('nombre', 'ASC')->get('cat_estados')->result();        
        return $misanuncios;    
    } 
    
    function obtenerModalidades(){   
        $result =   $this->db->select("nombre")->where("sta",0)->order_by('nombre', 'ASC')->get('cat_modalidades')->result();   
        return $result;    
    } 

    function obtenerSecciones(){        
        $result = $this->db->select("nombre")->select("sigla")->where("sta",0)->order_by('nombre', 'ASC')->get('cat_secciones')->result();       
        return $result;    
    } 

    function obtenerApartados($seccion){ 
        $sigla_seccion = $this->db->get_where('cat_secciones', array('nombre' => $seccion))->row()->sigla;
        $result = $this->db->select("nombre")->where("sta",'0')->where("seccion_sigla",$sigla_seccion)->order_by('nombre', 'ASC')->get('cat_apartados')->result(); 
        return $result;    
    } 
    
    function obtenerCiudades($estado){ 
        $sigla_estado = $this->db->get_where('cat_estados', array('nombre' => $estado))->row()->sigla;
        $result = $this->db->select("nombre")->where("sta",0)->where("estado_sigla",$sigla_estado)->order_by('nombre', 'ASC')->get('cat_municipios')->result();  
        return $result;    
    } 

    function obtenerAnunciosCantidad(){        
        $result = $this->db->select("cantidad")->where("sta",0)->get('cat_anuncios_cantidad')->result();       
        return $result;    
    } 

}

?>
