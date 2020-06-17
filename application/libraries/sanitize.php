<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sanitize {

    function sanitizeString($string){
        //$black_list  = array("<script>");  
        $string = strip_tags($string);
        //$string = str_ireplace($black_list,'',$string);     
        //$string = htmlentities($string);  
        return $string;      
      } 
        
}