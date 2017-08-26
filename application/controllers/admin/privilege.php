<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Privilege extends CI_Controller {
	
    public function __construct(){
    	
        parent::__construct();
        $this->load->helper('captcha');
        
    }
    
    
    public function login(){
        
        // $vals = array(
            // 'word' => rand(1000,9999),
            // 'img_path' => './data/captcha/',
            // 'img_url' => base_url() . 'data/captcha/'
        // );
        
        
        // $data = create_captcha($vals);
    	
        // var_dump($data);
        
        
        $this->load->view('login.html');
    }
    
    // 生成验证码
    public function code(){
        
        $vals = array(
            'word_length' => 6,
        );
        
    	create_captcha($vals);
    }
    
}









