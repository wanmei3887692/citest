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
    
    
    
    //--------------------------------------------------------------
    
    //获得组合好的多维数组
    public function front_cate(){
        
        $query = $this->db->get(self::TBL);
        
        $arr = $query->result_array();
        
    	return $this->make_cate($arr, $pid = 0);
    }
    
    //根据PID获得子分类
    public function children($arr, $pid =0){
        
        $child = array();
        foreach($arr as $k => $v){
            
            if($v['parent_id'] == $pid){
            	$child[] = $v;
            }
        }
        return $child;
    }
    
    public function make_cate($arr, $pid = 0){
    	
        $children = $this->children($arr, $pid);
        
        if(empty($children)){
        	
            return null;            
        }
        
        foreach($children as $k => $v){
            
            $current_child = $this->make_cate($arr, $v['cat_id']);
            if($current_child != null){
            	//说明，该分类节点还有子分类节点，将子节点作为该节点的一个元素来保存
                $children[$k]['child'] = $current_child;
            }
        }
        
        return $children;
    }
    
    
    
    
    
    
}















