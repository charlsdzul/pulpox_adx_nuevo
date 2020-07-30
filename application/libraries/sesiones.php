<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesiones {
  protected $CI;
    public function __construct(){  
      $this->CI =& get_instance(); 
      $this->CI->load->library('session');       
    }

    function usuarioEstaEnSesion(){     
        if(isset($_SESSION['usuario_id']) && is_numeric($_SESSION['usuario_id'])){          
        }else{
          header("Location: /pulpox_ads_nuevo/index.php/inicio");
          die();
        }
    }

    function usuarioEnSesion(){
     return  $this->CI->session->usuario_id;   
    }
        
}

?>