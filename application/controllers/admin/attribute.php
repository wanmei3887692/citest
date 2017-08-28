<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attribute extends CI_Controller{
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('goodstype_model');
        $this->load->model('attribute_model');
    }
    
    
    
    //属性展示页
    public function index(){
        
        $data['attr'] = $this->attribute_model->list_attr();
        
        // var_dump($data);die;
    	$this->load->view('attribute_list.html', $data);
    }
    
    
    
    //属性增加页
    public function add(){
        
    	$data['goodstype'] = $this->goodstype_model->show_goodstype();
        $this->load->view('attribute_add.html', $data);
    }
    
    
    
    //属性编辑页
    public function edit(){
    	
        $this->load->view('attribute_edit.html');
    }
    
    
    
    //处理属性增加
    public function insert(){
        
        $data['attr_name'] = $this->input->post('attr_name');
        $data['type_id'] = $this->input->post('type_id');
        $data['attr_type'] = $this->input->post('attr_type');
        $data['attr_input_type'] = $this->input->post('attr_input_type');
        $data['attr_value'] = $this->input->post('attr_value');
        
        if($this->attribute_model->add_attr($data)){
        	//添加成功
            $m['url'] = site_url('admin/attribute/index');
            $m['wait'] = 3;
            $m['message'] = "添加商品属性成功";
            
            $this->load->view('message.html', $m);
        }
        else{
        	//添加失败
            $m['url'] = site_url('admin/attribute/index');
            $m['wait'] = 3;
            $m['message'] = "添加商品属性失败";
            
            $this->load->view('message.html', $m);
        }
        
    }
    
    
    
    
    
    
    
    
    
    
    
}




