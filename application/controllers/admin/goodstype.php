<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//商品类型控制器
class Goodstype extends CI_Controller {
	
    public function __construct(){
    	
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('goodstype_model');
        
    }
    
    //类型显示页
    public function index($offset = ''){
        
        $config['base_url'] = site_url('admin/goodstype/index');
        $config['total_rows'] = $this->goodstype_model->count_goodstype();
        $config['per_page'] = 2; 
        $config['uri_segment'] = 4;
        
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';

        $this->pagination->initialize($config); 

        $data['page_link'] = $this->pagination->create_links();
        
        $limit = $config['per_page'];
        
        $data['goodstype'] = $this->goodstype_model->list_goodstype($limit, $offset);
        $this->load->view('goods_type_list.html', $data);
    }
    
    //类型添加页
    public function add(){
    	
        $this->load->view('goods_type_add.html');
    }
    
    
    //类型编辑页
    public function edit(){
    	
        $this->load->view('goods_type_edit.html');
    }
    
    //处理类型添加
    public function insert(){
    	
        $this->form_validation->set_rules('type_name', '类型名称', 'required');
        
        if($this->form_validation->run() == false){
        	//验证失败
            $m['url'] = site_url('admin/goodstype/add');
            $m['wait'] = 3;
            $m['message'] = validation_errors();
            
            $this->load->view('message.html', $m);
        }
        else{
        	//验证成功
            
            $data['type_name'] = $this->input->post('type_name', true);
            
            if($this->goodstype_model->add_goodstype($data)){
                //添加成功
                $m['url'] = site_url('admin/goodstype/index');
                $m['wait'] = 3;
                $m['message'] = "添加商品类型成功";
                
                $this->load->view('message.html', $m);
            }else{
                //添加失败
                $m['url'] = site_url('admin/goodstype/add');
                $m['wait'] = 3;
                $m['message'] = "添加商品类型失败";
                
                $this->load->view('message.html', $m);
                
            }
            
        }
        
    }
    
}


