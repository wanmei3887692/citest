<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods extends CI_Controller {
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('goodstype_model');
        $this->load->model('attribute_model');
        $this->load->model('category_model');
        $this->load->model('brand_model');
        $this->load->model('goods_model');
        
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
	
    //处理商品添加
    public function insert(){
        
        $data['goods_name'] = $this->input->post('goods_name');
        $data['goods_sn'] = $this->input->post('goods_sn');
        $data['cat_id'] = $this->input->post('cat_id');
        $data['brand_id'] = $this->input->post('brand_id');
        $data['shop_price'] = $this->input->post('shop_price');
        $data['market_price'] = $this->input->post('market_price');
        $data['promote_price'] = $this->input->post('promote_price');
        $data['promote_start_time'] = strtotime($this->input->post('promote_start_time'));
        $data['promote_end_time'] = strtotime($this->input->post('promote_end_time'));
        $data['goods_desc'] = $this->input->post('goods_desc');
        $data['goods_number'] = $this->input->post('goods_number');
        $data['is_hot'] = $this->input->post('is_hot');
        $data['is_best'] = $this->input->post('is_best');
        $data['is_new'] = $this->input->post('is_new');
        $data['is_promote'] = $this->input->post('is_promote');
        $data['is_onsale'] = $this->input->post('is_onsale');
        $data['add_time'] = time();
        $data['goods_brief'] = $this->input->post('goods_brief');
        
        
        $config['upload_path'] = "./public/uploads/";
        $config['allowed_types'] = "jpg|gif|jpeg|png";
        $config['max_size'] = 100;
        
        $this->load->library('upload', $config);
        
        if($this->upload->do_upload('goods_img')){
            //上传成功,生成缩略图
            $res = $this->upload->data();   //获取上传成功图片信息
            $data['goods_img'] = $res['file_name'];
            
            $config_img['source_image'] = "./public/uploads/".$res['file_name'];
            $config_img['create_thumb'] = TRUE;
            $config_img['maintain_ratio'] = TRUE;
            $config_img['width'] = 160;
            $config_img['height'] = 160;

            //载入并初始化图像处理类
            $this->load->library('image_lib', $config_img);
            
            if($this->image_lib->resize()){
                //生成缩略图成功
                $data['goods_thumb'] = $res['raw_name'].$this->image_lib->thumb_marker.$res['file_ext'];

                if($goods_id = $this->goods_model->add_goods($data)){
                	//添加商品成功,获取属性，并插入到商品属性表中
                    $attr_ids = $this->input->post('attr_id_list');
                    $attr_values = $this->input->post('attr_value_list');
                    
                    foreach($attr_values as $k => $v){
                        
                        if(!empty($v)){
                            
                            $data2['goods_id'] = $goods_id;
                            $data2['attr_id'] = $attr_ids[$k];
                            $data2['attr_value'] = $v;
                            
                            $this->db->insert('goods_attr', $data2);
                        }
                    }
                    //插入成功
                    $m['url'] = site_url('admin/goods/index');
                    $m['wait'] = 3;
                    $m['message'] = '添加商品成功';
                    
                    $this->load->view('message.html', $m);
                }
                else{
                    //添加商品失败
                	$m['url'] = site_url('admin/goods/add');
                    $m['wait'] = 3;
                    $m['message'] = '添加商品失败';
                    
                    $this->load->view('message.html', $m);
                }
            	
            }
            else{
                //生成缩略图失败
            	$m['url'] = site_url('admin/goods/add');
                $m['wait'] = 3;
                $m['message'] = $this->image_lib->display_errors();
                
                $this->load->view('message.html', $m);
            }
            
        }
        else{
        	//上传失败
            $m['url'] = site_url('admin/goods/add');
            $m['wait'] = 3;
            $m['message'] = $this->upload->display_errors();
            
            $this->load->view('message.html', $m);
        }
        
    }
    
    
    
    
    
    
    
    
}










