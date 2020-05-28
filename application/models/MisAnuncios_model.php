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
           // $this->db->where("id",$evaluacion_id);
            $res = $this->db->get('anuncios');
            $j=0;
            foreach ($res->result() as $row){
                $misanuncios[$j]['public_id'] = $row->public_id;
                $misanuncios[$j]['titulo'] = $row->titulo;
                $misanuncios[$j]['estado'] = $row->estado;
                $misanuncios[$j]['ciudad'] = $row->ciudad;
                $misanuncios[$j]['seccion'] = $row->seccion;
                $misanuncios[$j]['apartado'] = $row->apartado;
                $misanuncios[$j]['creado'] = $row->creado;
                $misanuncios[$j]['estatus'] = $row->sta;
                $j++;
            } 
         
            return $misanuncios;      
          
        }

 

    }

?>
