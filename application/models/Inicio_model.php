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

        if($datosBusqueda['modalidad'] == "") $modalidadCol = "modalidad !=''";
        else $modalidadCol = "modalidad";

        if($datosBusqueda['estado']=="") $estadoCol = "estado !=''";
        else $estadoCol = "estado";

        if($datosBusqueda['ciudad']=="") $ciudadCol = "ciudad !=''";
        else $ciudadCol = "ciudad";

        if($datosBusqueda['seccion']=="") $seccionCol = "seccion !=''";
        else $seccionCol = "seccion";

        if($datosBusqueda['apartado']=="") $apartadoCol = "apartado !=''";
        else $apartadoCol = "apartado";

        if($datosBusqueda['textoBuscar']=="") $tituloCol = "titulo !=''";
        else $tituloCol = "titulo=";

        if($datosBusqueda['textoBuscar']=="") $mensajeCol = "mensaje !=''";
        else $mensajeCol = "mensaje=";

        //$busquedaTexto ="({$tituloCol} '{$datosBusqueda['textoBuscar']}' OR {$mensajeCol} '{$datosBusqueda['textoBuscar']}')";



        $this->db->select("*")
        //->limit($datosBusqueda['numeroMostrar'])

        ->order_by('renovado', 'DESC')
        ->where($modalidadCol,$datosBusqueda['modalidad'])
        ->where($estadoCol,$datosBusqueda['estado'])
        ->where($ciudadCol,$datosBusqueda['ciudad'])
        ->where($seccionCol,$datosBusqueda['seccion'])
        ->where($apartadoCol,$datosBusqueda['apartado'])
        ->like('titulo', $datosBusqueda['textoBuscar'])
        ->or_like('mensaje', $datosBusqueda['textoBuscar'])      
        ->where("sta=0");
        
        if($query = $this->db->get('anuncios')){  

            $total_anuncios = $query->num_rows();
            $total_paginas= ceil($total_anuncios/$datosBusqueda['numeroMostrar']);

            if($total_anuncios>0){

                $misanuncios=[]; 
                $j=0;  
                foreach ($query->result() as $row){
                    $misanuncios[$j]['total_anuncios'] = $total_anuncios;
                    $misanuncios[$j]['total_paginas'] = $total_paginas;
                    $misanuncios[$j]['public_id'] = $row->public_id;
                    $misanuncios[$j]['titulo'] = $row->titulo;
                    $misanuncios[$j]['modalidad'] = $row->modalidad;
                    $misanuncios[$j]['estado'] = $this->validaciones->obtenerNombre($row->estado, 'estado');
                    $misanuncios[$j]['ciudad'] = $this->validaciones->obtenerNombre($row->ciudad, 'ciudad');
                    $misanuncios[$j]['seccion'] = $this->validaciones->obtenerNombre($row->seccion, 'seccion');
                    $misanuncios[$j]['apartado'] = $this->validaciones->obtenerNombre($row->apartado, 'apartado');
                    $misanuncios[$j]['renovado'] = $this->validaciones->creaFechaConFormatoCorto($row->renovado);
                    $j++;

                    if($j==($datosBusqueda['numeroMostrar'])) break;
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

    function buscarAnunciosTodoMexico($datosBusqueda){
        
        if($datosBusqueda['modalidad'] == "") {$modalidadCol = "modalidad !=";}
        else $modalidadCol = "modalidad";

        if($datosBusqueda['ciudad']=="") $ciudadCol = "ciudad !=";
        else $ciudadCol = "ciudad";

        if($datosBusqueda['apartado']=="") $apartadoCol = "apartado !=";
        else $apartadoCol = "apartado";

        $this->db->select("*")
        //->limit($datosBusqueda['numeroMostrar'])

        ->order_by('renovado', 'DESC')
        ->where($modalidadCol,$datosBusqueda['modalidad'])
        ->where("estado",$datosBusqueda['estado'])
        ->where($ciudadCol,$datosBusqueda['ciudad'])
        ->where("seccion",$datosBusqueda['seccion'])
        ->where($apartadoCol,$datosBusqueda['apartado'])
        ->where("sta=0");


        if($query = $this->db->get('anuncios')){  

            $total_anuncios = $query->num_rows();
            $total_paginas= ceil($total_anuncios/$datosBusqueda['numeroMostrar']);

            if($total_anuncios>0){

                $misanuncios=[]; 
                $j=0;  
                foreach ($query->result() as $row){
                    $misanuncios[$j]['total_anuncios'] = $total_anuncios;
                    $misanuncios[$j]['total_paginas'] = $total_paginas;
                    $misanuncios[$j]['public_id'] = $row->public_id;
                    $misanuncios[$j]['titulo'] = $row->titulo;
                    $misanuncios[$j]['modalidad'] = $row->modalidad;
                    $misanuncios[$j]['estado'] = $this->validaciones->obtenerNombre($row->estado, 'estado');
                    $misanuncios[$j]['ciudad'] = $this->validaciones->obtenerNombre($row->ciudad, 'ciudad');
                    $misanuncios[$j]['seccion'] = $this->validaciones->obtenerNombre($row->seccion, 'seccion');
                    $misanuncios[$j]['apartado'] = $this->validaciones->obtenerNombre($row->apartado, 'apartado');
                    $row->renovado == $row->creado ? $misanuncios[$j]['renovado']= 'NUNCA': $misanuncios[$j]['renovado'] = $this->validaciones->creaFechaConFormato($row->renovado);
                    $row->editado == '0000-00-00 00:00:00' ? $misanuncios[$j]['editado']= 'NUNCA': $misanuncios[$j]['editado'] = $this->validaciones->creaFechaConFormato($row->editado);
                    $misanuncios[$j]['creado'] = $this->validaciones->creaFechaConFormato($row->creado);
                    $misanuncios[$j]['estatus'] = $this->validaciones->estatusTexto($row->sta);
                    $j++;

                    if($j==($datosBusqueda['numeroMostrar'])) break;
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

    function buscarAnunciosGeneral(){      

        $this->db->select("*")
        ->limit(25)
        ->order_by('renovado', 'DESC')        
        ->where("sta=0");

        $mostrar = 4;

        if($query = $this->db->get('anuncios')){  

            $total_anuncios = $query->num_rows();
            $total_paginas= ceil($total_anuncios/$mostrar );

            if($total_anuncios>0){

                $misanuncios=[]; 
                $j=0;  
                foreach ($query->result() as $row){
                    $misanuncios[$j]['total_anuncios'] = $total_anuncios;
                    $misanuncios[$j]['total_paginas'] = $total_paginas;
                    $misanuncios[$j]['public_id'] = $row->public_id;
                    $misanuncios[$j]['titulo'] = $row->titulo;
                    $misanuncios[$j]['modalidad'] = $row->modalidad;
                    $misanuncios[$j]['estado'] = $this->validaciones->obtenerNombre($row->estado, 'estado');
                    $misanuncios[$j]['ciudad'] = $this->validaciones->obtenerNombre($row->ciudad, 'ciudad');
                    $misanuncios[$j]['seccion'] = $this->validaciones->obtenerNombre($row->seccion, 'seccion');
                    $misanuncios[$j]['apartado'] = $this->validaciones->obtenerNombre($row->apartado, 'apartado');
                    $row->renovado == $row->creado ? $misanuncios[$j]['renovado']= 'NUNCA': $misanuncios[$j]['renovado'] = $this->validaciones->creaFechaConFormato($row->renovado);
                    $row->editado == '0000-00-00 00:00:00' ? $misanuncios[$j]['editado']= 'NUNCA': $misanuncios[$j]['editado'] = $this->validaciones->creaFechaConFormato($row->editado);
                    $misanuncios[$j]['creado'] = $this->validaciones->creaFechaConFormato($row->creado);
                    $misanuncios[$j]['estatus'] = $this->validaciones->estatusTexto($row->sta);
                    $j++;

                    if($j==$mostrar ) break;
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