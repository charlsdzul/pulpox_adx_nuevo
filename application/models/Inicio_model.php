<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio_model extends CI_Model {

    function __construct(){
        parent::__construct();

        $this->load->library('sesiones');
        //$this->sesiones->usuarioEstaEnSesion(); 

        //$this->ID_USUARIO_EN_SESSION = $this->sesiones->usuarioEnSesion();
        
        $this->load->library('validaciones');
        $this->load->database(); 
        $this->load->helper('url');    
             
    }  

    function buscarAnuncios($datosBusqueda){ 


        if($datosBusqueda['modalidad'] == ' ') $modalidadCol = "modalidad !=";
        else $modalidadCol = "modalidad";

        if($datosBusqueda['estado']==' ') $estadoCol = "estado !=";
        else $estadoCol = "estado";

        if($datosBusqueda['ciudad']==' ') $ciudadCol = "ciudad !=";
        else $ciudadCol = "ciudad";

        if($datosBusqueda['seccion']==' ') $seccionCol = "seccion !=";
        else $seccionCol = "seccion";

        if($datosBusqueda['apartado']==' ') $apartadoCol = "apartado !=";
        else $apartadoCol = "apartado";

        if($datosBusqueda['textoBuscar']==' ') $tituloCol = "titulo !=";
        else $tituloCol = "titulo=";

        if($datosBusqueda['textoBuscar']==' ') $mensajeCol = "mensaje !=";
        else $mensajeCol = "mensaje="; 

    
        $this->db->select("*")
        ->order_by('renovado', 'DESC')
        ->where($modalidadCol,$datosBusqueda['modalidad'])
        ->where($estadoCol,$datosBusqueda['estado'])
        ->where($ciudadCol,$datosBusqueda['ciudad'])
        ->where($seccionCol,$datosBusqueda['seccion'])
        ->where($apartadoCol,$datosBusqueda['apartado'])            
        ->where("sta='0'")
        ->where("(titulo LIKE '%".$datosBusqueda['textoBuscar']."%' OR mensaje LIKE '%".$datosBusqueda['textoBuscar']."%')", NULL, FALSE); 
        
        if($query = $this->db->get('anuncios')){           
         //print_r($this->db->last_query()); 
           
            $total_anuncios = $query->num_rows();
            $total_paginas= ceil($total_anuncios/$datosBusqueda['numeroMostrar']);

            $contarDesde = (($datosBusqueda['paginaSeleccionada']) * $datosBusqueda['numeroMostrar']) - ($datosBusqueda['numeroMostrar']-1);
            $contarHasta = $datosBusqueda['paginaSeleccionada'] * $datosBusqueda['numeroMostrar'];
    
            if($total_anuncios>0){

                $misanuncios=[]; 
                $j=1;  
                foreach ($query->result() as $row){

                    if($j>=$contarDesde && $j<=$contarHasta){
                        $misanuncios[$j]['numero'] = $j;
                        $misanuncios[$j]['total_anuncios'] = $total_anuncios;
                        $misanuncios[$j]['total_paginas'] = $total_paginas;
                        $misanuncios[$j]['public_id'] = $row->public_id;
                        $misanuncios[$j]['titulo'] = $j.$row->titulo;
                        $misanuncios[$j]['modalidad'] = $row->modalidad;
                        $misanuncios[$j]['estado'] = $this->validaciones->obtenerNombre($row->estado, 'estado');
                        $misanuncios[$j]['ciudad'] = $this->validaciones->obtenerNombre($row->ciudad, 'ciudad');
                        $misanuncios[$j]['seccion'] = $this->validaciones->obtenerNombre($row->seccion, 'seccion');
                        $misanuncios[$j]['apartado'] = $this->validaciones->obtenerNombre($row->apartado, 'apartado');
                        $misanuncios[$j]['renovado'] = $this->validaciones->creaFechaConFormatoCorto($row->renovado);  
                    }                   
                  
                    if($j==$contarHasta) break;
                    $j++; 

                }                  
      
                echo json_encode($misanuncios);
                die();
            }else{
                $response['codigo']  = 1;
                $response['mensaje'] = 'No hay resultados.';  
                echo json_encode($response);    
                die(); 
            }          
        }else{
            $response['codigo']  = 1;
            $response['mensaje'] = 'Hubo un problema al consultar los anuncios. Intente más tarde.';  
            echo json_encode($response);    
            die(); 
        }      
    } 

    function buscarAnunciosGeneral(){      

        $this->db->select("public_id,titulo,modalidad,estado,ciudad,seccion,apartado,renovado")       
        ->order_by('renovado', 'DESC')        
        ->where("sta=0");

        $mostrar = 25;

        if($query = $this->db->get('anuncios')){  

            $total_anuncios = $query->num_rows();
            $total_paginas= ceil($total_anuncios/$mostrar);

            if($total_anuncios>0){

                $misanuncios=[]; 
                $j=1;  
                foreach ($query->result() as $row){
                    $misanuncios[$j]['numero'] = $j;
                    $misanuncios[$j]['total_anuncios'] = $total_anuncios;
                    $misanuncios[$j]['total_paginas'] = $total_paginas;
                    $misanuncios[$j]['public_id'] = $row->public_id;
                    $misanuncios[$j]['titulo'] = $row->titulo;
                    $misanuncios[$j]['modalidad'] = $row->modalidad;
                    $misanuncios[$j]['estado'] = $this->validaciones->obtenerNombre($row->estado, 'estado');
                    $misanuncios[$j]['ciudad'] = $this->validaciones->obtenerNombre($row->ciudad, 'ciudad');
                    $misanuncios[$j]['seccion'] = $this->validaciones->obtenerNombre($row->seccion, 'seccion');
                    $misanuncios[$j]['apartado'] = $this->validaciones->obtenerNombre($row->apartado, 'apartado');
                    $misanuncios[$j]['renovado'] = $this->validaciones->creaFechaConFormato($row->renovado);
                   
                    if($j==$mostrar ) break;
                    $j++;

                }  
                echo json_encode($misanuncios);
                die();
            }else{
                $response['codigo']  = 1;
                $response['mensaje'] = 'No hay resultados.';  
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