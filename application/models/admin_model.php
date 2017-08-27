<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_model extends CI_Model {
	
    const TBL = 'admin';
    
    public function __construct(){
    	
        parent::__construct();

        $this->load->database();
    }

    public function find_pwd($username){
        
        $query = $this->db->get_where(self::TBL, array('admin_name' => $username));
        
        return $query->row_array();
    	
    }

    
    
}