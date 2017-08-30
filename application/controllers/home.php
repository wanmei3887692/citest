<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Home_Controller{
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('goods_model');
        $this->load->model('category_model');
    }
    
    
    public function index(){
        
        $data['cates'] = $this->category_model->front_cate();
        // var_dump($cates);die;
    	
        $this->load->view('index.html', $data);
    }
    
}