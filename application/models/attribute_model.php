<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//商品属性模型
class attribute_model extends CI_Model {
	
    const TBL = "attribute";
    public function __construct(){
    	
        parent::__construct();
        $this->load->database();
    }
    
    //增加属性
    public function add_attr($data){

        return $this->db->insert(self::TBL, $data);
    }
    
    //展示属性
    public function list_attr(){
    	
        $query = $this->db->get(self::TBL);
        return $query->result_array();
    }
    
    
}

