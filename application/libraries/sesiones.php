<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sesiones {
  protected $CI;
    public function __construct(){  
      $this->CI =& get_instance();       
    }

    function usuarioEstaEnSesion(){
        $user = true;
        if($user){
        }else{
          header("Location: /pulpox_ads_nuevo/index.php/inicio");
          die();
        }
    }

    function usuarioEnSesion(){
      return 111;   
    }
        
}

?>