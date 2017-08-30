<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods extends Home_Controller{
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('goods_model');
        // $this->load->model('category_model');
    }
    
    
    public function index($goods_id){
        
        
        $data['goods'] = $this->goods_model->find_goods($goods_id);
        
        
        $this->load->view('goods.html', $data);
    }
    
}