<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods extends CI_Controller {
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('goodstype_model');
        $this->load->model('attribute_model');
        $this->load->model('category_model');
        $this->load->model('brand_model');
        
    }
    
    //商品展示页
    public function index(){
    	
        $this->load->view('goods_list.html');
    }
    
    
    
    
    //商品添加页
    public function add(){
           
        $data['goodstypes'] = $this->goodstype_model->show_goodstype();
        
        $data['cates'] = $this->category_model->list_cate();
        
        $data['brands'] = $this->brand_model->brand_list();
    	
        $this->load->view('goods_add.html', $data);
    }
    
    
    //商品编辑页
    public function edit(){
    	
        $this->load->view('goods_edit.html');
    }
    
    //生成属性表单域
    public function create_attrs_html(){
        
        //获得商品类型id
        $type_id = $this->input->get('type_id');
        
        $attrs = $this->attribute_model->get_attr($type_id);
        
        $html = "";
        foreach($attrs as $v){
            
            $html .= "<tr>";
            $html .= "<td class='label'>".$v['attr_name']."</td>";
            $html .= "<td>";
            $html .= "<input type='hidden' name='attr_id_list[]' value='".$v['attr_id']."'>";
            switch ($v['attr_input_type'])
            {
                case 0: 
                    //文本框
                    $html .= "<input name='attr_value_list[]' type='text' value='' size='40'> ";
                    break;
                case 1: 
                    //下拉列表
                    $arr = explode(PHP_EOL, $v['attr_value']);
                    
                    $html .= "<select name='attr_value_list[]'>";
                    $html .= "<option value=''>请选择...</option>";
                    foreach($arr as $v){
                        
                        $html .= "<option value='".$v."'>".$v."</option>";
                    }
                    
                    $html .= "</select>";
                    break;
                case 2: 
                    //文本框
                    
                    break;
                    
                default:
                    
                    break;
            }
            
            $html .= "</td>";
            $html .= "</tr>";
        }
        
        echo $html;
    	
    }
	
}










