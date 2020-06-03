<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->database(); //cargar base de datos
    } 

    function obtenerEstados(){        
        $this->db->select("nombre");
        $this->db->order_by('nombre', 'ASC');
        $this->db->where("sta",0);
        $misanuncios = $this->db->get('cat_estados')->result();        
        return $misanuncios;    
    } 
    
    function obtenerModalidades(){        
        $this->db->select("nombre");
        $this->db->order_by('nombre', 'ASC');
        $this->db->where("sta",0);
        $result = $this->db->get('cat_modalidades')->result();        
        return $result;    
    } 

    function obtenerSecciones(){        
        $this->db->select("nombre");
        $this->db->select("sigla");
        $this->db->order_by('nombre', 'ASC');
        $this->db->where("sta",0);
        $result = $this->db->get('cat_secciones')->result();        
        return $result;    
    } 

    function obtenerApartados($seccion){ 
        $sigla_seccion = $this->db->get_where('cat_secciones', array('nombre' => $seccion))->row()->sigla;
        $this->db->select("nombre");
        $this->db->order_by('nombre', 'ASC');
        $this->db->where("seccion_sigla",$sigla_seccion);
        $this->db->where("sta",'0');
        $result = $this->db->get('cat_apartados')->result();   
        return $result;    
    } 
    
    function obtenerCiudades($estado){ 
        $sigla_estado = $this->db->get_where('cat_estados', array('nombre' => $estado))->row()->sigla;
        $this->db->select("nombre");
        $this->db->order_by('nombre', 'ASC');
        $this->db->where("estado_sigla",$sigla_estado);
        $this->db->where("sta",0);
        $result = $this->db->get('cat_municipios')->result();   
        return $result;    
    } 

}

?>
