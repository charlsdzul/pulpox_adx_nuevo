<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MisAnuncios_model extends CI_Model {

    function __construct(){
        parent::__construct();

        $this->load->library('sesiones');
        $this->sesiones->usuarioEstaEnSesion(); 

        $this->ID_USUARIO_EN_SESSION = $this->sesiones->usuarioEnSesion();
        
        $this->load->library('validaciones');
        $this->load->database(); 
        $this->load->helper('url');    
             
    }  

    function obtenerMisAnuncios(){ 
        $this->db->select("*")->order_by('creado', 'DESC')->where("usuario_id",$this->ID_USUARIO_EN_SESSION)->where("(sta=0 OR sta=1 OR sta=2)");
        if($query = $this->db->get('anuncios')){  
            if($query->num_rows()>0){
                $misanuncios=[]; 
                $j=0;  
                foreach ($query->result() as $row){
                    $misanuncios[$j]['public_id'] = $row->public_id;
                    $misanuncios[$j]['titulo'] = $row->titulo;
                    $misanuncios[$j]['modalidad'] = $row->modalidad;
                    $misanuncios[$j]['estado'] = $this->validaciones->obtenerNombre($row->estado, 'estado');
                    $misanuncios[$j]['ciudad'] = $this->validaciones->obtenerNombre($row->ciudad, 'ciudad');
                    $misanuncios[$j]['seccion'] = $this->validaciones->obtenerNombre($row->seccion, 'seccion');
                    $misanuncios[$j]['apartado'] = $this->validaciones->obtenerNombre($row->apartado, 'apartado');
                    $row->renovado == $row->creado ? $misanuncios[$j]['renovado']= 'NUNCA': $misanuncios[$j]['renovado'] = $this->validaciones->creaFechaConFormato($row->renovado);
                    $row->editado == '0000-00-00 00:00:00' ? $misanuncios[$j]['editado']= 'NUNCA': $misanuncios[$j]['editado'] = $this->validaciones->creaFechaConFormato($row->editado);
                    $row->sta==0 ? $misanuncios[$j]['renovar'] = $this->validaciones->disponibleParaRenovar($row->renovado):$misanuncios[$j]['renovar'] = 1;
                    $misanuncios[$j]['creado'] = $this->validaciones->creaFechaConFormato($row->creado);
                    $misanuncios[$j]['estatus'] = $this->validaciones->estatusTexto($row->sta);
                    $j++;
                }              
                echo json_encode($misanuncios);
                die();
            }else{
                $response['codigo']  = 1;
                $response['mensaje'] = '¡Aún no tiene anuncios!';  
                echo json_encode($response);    
                die(); 
            }          
        }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'Hubo un problema al intentar obtener tus anuncios. Intente más tarde.';  
            echo json_encode($response);    
            die(); 
        }      
    } 
}
?>