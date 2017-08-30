<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//商品品牌管理
class Brand extends CI_Controller{
    
    public function __construct(){
        
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('brand_model');
        $this->load->library('upload');
        
    	
    }
    
    
    //品牌展示页
    public function index(){
        
        $data['brands'] = $this->brand_model->brand_list();
        
        // var_dump($data);die;
    	
        $this->load->view('brand_list.html', $data);
    }
    
    
    //品牌添加页
    public function insert(){
    	
        $this->load->view('brand_add.html');
    }
    
    
    //品牌编辑页
    public function eidt(){
    	
        $this->load->view('brand_add.thml');
    }
    
    
    //处理品牌添加
    public function brand_add(){
    	
        $this->form_validation->set_rules('brand_name', '品牌名称', 'required');
        
        if($this->form_validation->run() == false){
        	//验证失败
            $m['url'] = site_url('admin/brand/insert');
            $m['wait'] = 3;
            $m['message'] = validation_errors();
            
            $this->load->view('message.html', $m);
        }
        else{
            //验证成功，收集数据
            //上传logo文件
           
            if($this->upload->do_upload('logo')){
            	//上传成功
                $fileinfo = $this->upload->data();
                $data['logo'] = $fileinfo['file_name'];
                
                $data['brand_name'] = $this->input->post('brand_name');
                $data['url'] = $this->input->post('url');
                $data['brand_desc'] = $this->input->post('brand_desc');
                $data['is_show'] = $this->input->post('is_show');
                $data['sort_order'] = $this->input->post('sort_order');
                
                if($this->brand_model->brand_insert($data)){
                    //品牌添加成功
                    $m['url'] = site_url('admin/brand/index');
                    $m['wait'] = 3;
                    $m['message'] = "品牌添加成功";
                    
                    $this->load->view("message.html", $m);
                    
                }
                else{
                    //品牌添加失败
                    $m['url'] = site_url('admin/brand/add');
                    $m['wait'] = 3;
                    $m['message'] = "品牌添加失败";
                    
                    $this->load->view("message.html", $m);
                }
            }
            else{
            	//上传失败
                $m['url'] = site_url('admin/brand/insert');
                $m['wait'] = 3;
                $m['message'] = $this->upload->display_errors();
                
                $this->load->view('message.html', $m);
            }
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

