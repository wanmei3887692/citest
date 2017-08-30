<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//商品模型
class Goods_model extends CI_Model{
    
    const TBL = 'goods';
    
    public function __construct(){
    	
        parent::__construct();
        
        $this->load->database();      
    }

    //添加商品
    public function add_goods($data){
        
        $query = $this->db->insert(self::TBL, $data);
        
        return $query ? $this->db->insert_id() : false;
    	
    }









    
    
    
}