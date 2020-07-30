<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    function __construct(){
        parent::__construct();     
        $this->load->database();  
        $this->load->library('session'); 
    }

    function verificarUsuario($usuario,$contrasena){

      $query = $this->db->select('id,usuario,correo,nombre,apellido,tipo')->where('contrasena',$contrasena)->where('sta',0)->where('usuario',$usuario)->or_where('correo',$usuario)->get('usuarios');
      if ($query->num_rows() == 1){
        $usuario = $query->result_array();  
        $this->session->set_userdata('usuario_id', $usuario[0]['id']);
        $this->session->set_userdata('usuario_usuario', $usuario[0]['usuario']);
        $this->session->set_userdata('usuario_correo', $usuario[0]['correo']);
        $this->session->set_userdata('usuario_nombre', $usuario[0]['nombre']);
        $this->session->set_userdata('usuario_apellido', $usuario[0]['apellido']);
        $this->session->set_userdata('usuario_tipo', $usuario[0]['tipo']);
        $this->session->set_userdata('usuario_csrf', md5(uniqid(mt_rand(), true)));
        
        $response['codigo']=0;
        $response['mensaje']='Bienvenido';
        $response['redirect']='misanuncios';
        echo json_encode($response);
        die();
      }
      else{
        $response['codigo']=1;
        $response['mensaje']='Usuario y/o contraseña incorrecta.';
        echo json_encode($response);
        die();
      }

   }





}
?>
