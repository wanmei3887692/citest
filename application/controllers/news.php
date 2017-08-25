<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Content-type:text/html;charset=utf-8");
class News extends CI_Controller {

    public function __construct(){
    	
        parent::__construct();
            
        $this->load->model("news_model");        
    }

	public function index()
	{
        
        $data['news'] = $this->news_model->list_news();
        
		$this->load->view('list_news.html', $data);
	}
    
    //处理增加
    public function insert(){
    	
        $data['title'] = $_POST['title'];
        $data['author'] = $_POST['author'];
        $data['content'] = $_POST['content'];
        $data['add_time'] = time();
        
        if($this->news_model->add_news($data)){
        	echo "添加成功";
        }
        else{
        	echo "添加失败";
        }
    }
    
    //显示增加页面
    public function add(){
        
    	$this->load->view('add.html');
    }
    
    
    
    
    
    
    
    
}

