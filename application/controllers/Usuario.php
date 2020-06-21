<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {    

    function __construct() {
        parent::__construct();            
        $this->load->helper('url'); 
        $this->load->model('usuario_model');    
    }

    function login(){   

        if( isset($_POST['usuario']) && isset($_POST['contrasena']) ){
            $usuario = addslashes($_POST['usuario']);
            $contrasena =  addslashes($_POST['contrasena']); 
            $this->usuario_model->verificarUsuario($usuario, $contrasena);  
        }else{
            $response['codigo']=1;
            $response['mensaje']='Ingresa tus datos de acceso.';
            echo json_encode($response);
            die();
        }
      
       /* var_dump($this->session->userdata()); 
        
          $this->load->view('headers/header-html-usuario-login');
          $this->load->view('modules/menu');       
          $this->load->view('pages/page-usuario-login');  */
      }

}
?>