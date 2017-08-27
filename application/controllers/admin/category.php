<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-type:text/html;charset=utf-8");
class Category extends CI_Controller {
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('category_model');
        $this->load->library('form_validation');
        $this->output->enable_profiler(TRUE);
    }
    
    /*category测试数据
    
    insert into ci_category(cat_name, parent_id)values('河北',0);
    insert into ci_category(cat_name, parent_id)values('湖北',0);
    insert into ci_category(cat_name, parent_id)values('张家口',1);
    insert into ci_category(cat_name, parent_id)values('武汉',2);
    insert into ci_category(cat_name, parent_id)values('宣化区',3);
    insert into ci_category(cat_name, parent_id)values('武昌',4);
    
    */
    
    public function index(){
    	// $this->output->enable_profiler(TRUE);
        $data['cates'] = $this->category_model->list_cate();
        $this->load->view('cat_list.html', $data);
    }
    
    public function add(){
    	
        $data['cates'] = $this->category_model->list_cate();
        $this->load->view('cat_add.html', $data);
    }

    public function edit($cat_id){
        
    	$data['cates'] = $this->category_model->list_cate();
        $data['c'] = $this->category_model->get_one_cate($cat_id);
        $this->load->view('cat_edit.html', $data);
    }
    
    //处理增加分类
    public function do_add(){
        
        
        $this->form_validation->set_rules('cat_name', '分类名称', 'required');
        
        if( $this->form_validation->run() == FALSE ){
        	
            $data['url'] = site_url('admin/category/add');
            $data['wait'] = 3;
            $data['message'] = validation_errors();            
            $this->load->view('message.html', $data);
            
            
        }else{
            
            $data['cat_name'] = $this->input->post('cat_name');
            $data['parent_id'] = $this->input->post('parent_id', true);
            $data['sort_order'] = $this->input->post('sort_order');
            $data['unit'] = $this->input->post('unit');
            $data['is_show'] = $this->input->post('is_show');
            $data['cat_desc'] = $this->input->post('cat_desc');
            
            if($this->category_model->insert($data)){
                $m['url'] = site_url('admin/category/index');
                $m['wait'] = 3;
                $m['message'] = '添加分类成功';            
                $this->load->view('message.html', $m);
            }
        }
    	
    }
    
    //处理编辑
    public function do_edit(){
        
        $this->form_validation->set_rules('cat_name', '分类名称', 'required');
        //进行表单验证
        if( $this->form_validation->run() == FALSE ){
        	
            $data['url'] = site_url('admin/category/add');
            $data['wait'] = 3;
            $data['message'] = validation_errors();            
            $this->load->view('message.html', $data);
            
        }else{
            
            //验证成功，接收表单参数
            $cat_id = $this->input->post('cat_id');
            $data['cat_name'] = $this->input->post('cat_name');
            $data['parent_id'] = $this->input->post('parent_id', true);
            $data['sort_order'] = $this->input->post('sort_order');
            $data['unit'] = $this->input->post('unit');
            $data['is_show'] = $this->input->post('is_show');
            $data['cat_desc'] = $this->input->post('cat_desc');
            
            //获得所有子分类
            $children = $this->category_model->child($cat_id);
            
            //如果所选的父分类为自己和自己的子分类，不合逻辑
            if($data['parent_id'] == $cat_id || in_array($data['parent_id'], $children)){
                
            	$m['url'] = site_url('admin/category/edit') .'/'.$cat_id;
                $m['wait'] = 3;
                $m['message'] = '所选父分类不能为自己的子分类';            
                $this->load->view('message.html', $m);
            }else{
                
                if($this->category_model->edit($data, $cat_id)){
                    $m['url'] = site_url('admin/category/index');
                    $m['wait'] = 3;
                    $m['message'] = '编辑分类成功';            
                    $this->load->view('message.html', $m);
                }
            }
        }
    }
    
    
    //删除分类
    public function del_cat($cat_id){
    	
        //查询是否有子分类
        if($this->category_model->find_child($cat_id)){
            
            $m['url'] = site_url('admin/category/index');
            $m['wait'] = 3;
            $m['message'] = '请先删除子分类，再删除';            
            $this->load->view('message.html', $m);
        }else{
            
            if($this->category_model->del_cat($cat_id)){
                $m['url'] = site_url('admin/category/index');
                $m['wait'] = 3;
                $m['message'] = '删除分类成功';            
                $this->load->view('message.html', $m);
            }
        }
        
    }
    
}








