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

    //获得最好（推荐）商品
    public function best_goods(){
    	
        $condition['is_best'] = 1;
        $query = $this->db->where($condition)->get(self::TBL);
        return $query->result_array();
    }

    //获得指定的商品信息
    public function find_goods($goods_id){
        
        $condition['goods_id'] = $goods_id;
        $query = $this->db->where($condition)->get(self::TBL);
        return $query->row_array();
    }


    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        
}