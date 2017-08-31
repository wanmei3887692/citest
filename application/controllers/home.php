<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type:text/html;charset=utf-8");
class Home extends Home_Controller{
    
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('goods_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }
    
    
    public function index(){
        
        $data['cates'] = $this->category_model->front_cate();
        
        $data['best_goods'] = $this->goods_model->best_goods();
        
        $this->load->view('header.html', $data);
        $this->load->view('menu1.html');
        $this->load->view('index.html');
        $this->load->view('footer.html');
    }
    
    //用户注册页
    public function register(){
    	
        $this->load->view('register.html');
    }
    
    
    //用户登录页
    public function login(){
    	
        $this->load->view('login.html');
    }
    
    //处理用户注册
    public function do_register(){
    	
        $this->form_validation->set_rules('username', '用户名', 'required');
        $this->form_validation->set_rules('password', '密码', 'required|min_length[6]|max_length[16]|md5');
        $this->form_validation->set_rules('repassword', '重复密码', 'required|matches[password]');
        $this->form_validation->set_rules('email', '邮箱', 'required|valid_email');
       
        if($this->form_validation->run()){
            //验证成功
        	// echo "ok";
            $data['user_name'] = $this->input->post('username',true);
            $data['password'] = $this->input->post('password',true);
            $data['email'] = $this->input->post('email',true);
            $data['reg_time'] = time();
            
            
            if($this->user_model->add_user($data)){
                //添加成功
                $this->session->set_userdata('user', $data);
                redirect('home/index');
            }
            
        }else{
            //验证失败
        	echo validation_errors();
        }
    }
    
    //登录动作
    public function signin(){
    	
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        if($user = $this->user_model->get_user($username, $password)){
            //验证成功，保存到session中
            $this->session->set_userdata('user', $user);
        	redirect('home/index');
        }
        else{
        	echo "error";
        }
    }
    
    //注销动作
    public function logout(){
        
        $this->session->unset_userdata('user');
        redirect('home/index');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}