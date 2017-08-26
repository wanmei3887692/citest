<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Privilege extends CI_Controller {
	
    public function __construct(){
    	
        parent::__construct();
        $this->load->helper('captcha');
        
    }
    
    
    public function login(){
        
        // $vals = array(
            // 'img_path' => ,
            // 'img_url' => ,
        
        // );
        
    	
        $this->load->view('login.html');
    }
    
    
    
}









