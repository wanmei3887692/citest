<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//用户模型
class User_model extends CI_Model{
    
    
    const TBL = 'user';
    
    public function add_user($data){
    	
        return  $this->db->insert(self::TBL, $data);
        
    }
    
    //登录判断
    public function get_user($username, $password){
        
        $condition['user_name'] = $username;
        $condition['password'] = md5($password);
        $query = $this->db->where($condition)->get(self::TBL);
        return $query->row_array();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

