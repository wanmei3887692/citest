<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Loader extends CI_Loader{
	
    protected $_theme = 'default/';
    
    #����Ƥ������
    public function switch_themes_on(){
    	$this->_ci_view_paths = array(FCPATH . THEMES_DIR . $this->_theme => TRUE);
    }
    
    #�ر�Ƥ������
    public function switch_themes_off(){
    	
    }
    
}













