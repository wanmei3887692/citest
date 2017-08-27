<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model {
    
    const TBL = 'category';
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->database();
        
    }
    
    public function list_cate($pid = 0){
    	
        $query = $this->db->get(self::TBL);
        $cates = $query->result_array();
       
        //把得到的数据进行排列重组
        return $this->_tree($cates, $pid);
        
    }
    
    private function _tree($arr, $pid = 0, $level = 0 ){
        
        static $tree = array();
        
        foreach($arr as $value){
            
            if($value['parent_id'] == $pid){
                
                $value['level'] = $level;
            	
                $tree[] = $value;
                
                $this->_tree($arr, $value['cat_id'], $level + 1);
                
            }
        }
        
        return $tree;
    }
    
    //增加分类
    public function insert($data){
        
        return $this->db->insert(self::TBL, $data);
    }
    
    //编辑分类
    public function edit($data, $cat_id){
        
        $condition['cat_id'] = $cat_id;
        return $this->db->where($condition)->update(self::TBL,$data);
    }
    
    //获得分类节点
    public function get_one_cate($cat_id){

        $condition['cat_id'] = $cat_id;
        
        $query = $this->db->where($condition)->get(self::TBL);
        
        return $query->row_array();
    }

    //获得子分类
    public function child($cat_id){
        
        $query = $this->db->get(self::TBL);
        $cates = $query->result_array();
        
        // echo "<pre>";
        // var_dump($cates);die;
        
        //把得到的数据进行排列重组
        return $this->get_child($cates, $cat_id);
    }
    
    private function get_child($cates, $cat_id){
    	static $tree = array();
        
        foreach($cates as $value){
            
            if($value['parent_id'] == $cat_id){
            	
                $tree[] = $value['cat_id'];
                $this->get_child($cates, $value['cat_id']);
            }
        }
        return $tree;
    }
    
    public function del_cat($cat_id){
        
        $condition['cat_id'] = $cat_id;
        return $this->db->where($condition)->delete(self::TBL);
    }
    
	
    public function find_child($cat_id){
        
        $condition['parent_id'] = $cat_id;
        $res = $this->db->where($condition)->get(self::TBL);
    	return $res->result_array();
    }
    
    
    
    
}















