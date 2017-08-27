<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Privilege extends CI_Controller {
	
    public function __construct(){
    	
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
        
    }
    
    
    public function login(){
        
        $this->load->view('login.html');
    }
    
    // 生成验证码
    public function code(){
        
        $vals = array(
            'word_length' => 6,
        );
    	$code = create_captcha($vals);
        
        $this->session->set_userdata('code', $code);
    }
    
    
    //处理登录
    public function signin(){
        
        //设置验证规则
        $this->form_validation->set_rules('username', '用户名', 'required');
        $this->form_validation->set_rules('password', '密码', 'required');
    	
        //获取表单数据
        $captcha = strtolower($this->input->post('captcha'));
        
        // 获取session中保存的验证码
        $code = strtolower($this->session->userdata('code'));
        
        if( $captcha === $code ){
            
            //验证码正确，验证用户名和密码
            if( $this->form_validation->run() == false ){
            	
                $data['message'] = validation_errors();
                $data['url'] = site_url('admin/privilege/login');
                $data['wait'] = 3;
                $this->load->view('message.html', $data);
            }else{
                
                $username = $this->input->post('username'); 
                $password = $this->input->post('password');
                
                $m_pwd = $this->admin_model->find_pwd($username);
                
                if( $m_pwd == null ){
                    
                    $data['url'] = site_url('admin/privilege/login');
                    $data['message'] = '用户名不存在，请重新填写';
                    $data['wait'] = 3;
                    $this->load->view('message.html', $data);
                }else{
                    
                    if( $m_pwd['password'] == $password ){
                        
                        $this->session->set_userdata('admin', $username);                    
                        redirect('admin/main/index');
                    }else{
                        
                        $data['url'] = site_url('admin/privilege/login');
                        $data['message'] = '用户名或密码错误，请重新填写';
                        $data['wait'] = 3;
                        $this->load->view('message.html', $data);
                    }                   
                }

                /*
                if( $username == 'admin' && $password == '123' ){
                    
                    $this->session->set_userdata('admin', $username);                    
                    redirect('admin/main/index');

                }else{
                    
                    $data['url'] = site_url('admin/privilege/login');
                    $data['message'] = '用户名或密码错误，请重新填写';
                    $data['wait'] = 3;
                    $this->load->view('message.html', $data);
                }
                */
            }
            
        }
        else{
            //验证码不正确，给出提示，并跳转
            $data['url'] = site_url('admin/privilege/login');
            $data['message'] = '验证码错误，请重新填写';
            $data['wait'] = 3;
            $this->load->view('message.html', $data);
        }
    }
    
    //退出
    public function logout(){
    	
        $this->session->unset_userdata('admin');
        $this->session->sess_destroy();
        redirect('admin/privilege/login');
    }
    
}









 