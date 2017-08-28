<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Brand_model extends CI_Model {
	
    const TBL = 'brand';
    
    public function __construct(){
    	
        parent::__construct();

        $this->load->database();
    }

    //新增品牌
    public function brand_insert($data){
    	
        return $this->db->insert(self::TBL, $data);
    }
   
    //品牌展示
    public function brand_list(){
    	
        $query = $this->db->get(self::TBL);
        return $query->result_array();
    }
    
    
    
    
    
    

    
    
}