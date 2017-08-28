<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//商品类型模型
class Goodstype_model extends CI_Model{
    
    const TBL = 'goods_type';
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->database();
        
    }
    
    //添加商品类型
    public function add_goodstype($data){
        
        return $this->db->insert(self::TBL, $data);
    	
    }
    
    //显示商品类型
    public function list_goodstype($limit, $offset){
    	
        $query = $this->db->limit($limit, $offset)->get(self::TBL);
        return $query->result_array();
        
    }
    
    //显示商品类型总数
    public function count_goodstype(){
    	
        return $this->db->count_all(self::TBL);
    }
    
    
    
}