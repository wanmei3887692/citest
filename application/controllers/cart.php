<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends Home_Controller {
	
    

    public function show(){
        
        $data['cart'] = $this->cart->contents();
        
        // var_dump($data);die;

        $this->load->view('flow.html', $data);
    }


    public function add(){
    	
        $data['id'] = $this->input->post('goods_id');
        $data['qty'] = $this->input->post('goods_nums');
        $data['name'] = $this->input->post('goods_name');
        // $data['name'] = 'aaa';
        $data['price'] = $this->input->post('shop_price');
        
        
        $carts = $this->cart->contents();
        foreach($carts as $cart){
            if($cart['id'] == $data['id']){
                $data['qty'] += $cart['qty']; 
            }
        }
        

        if($this->cart->insert($data)){
        	
            redirect('cart/show');
            
        }else{
            
            echo "error";
        }
        
    }

    public function delete($rowid){
    	
        $data['rowid'] = $rowid;
        $data['qty'] = 0;
        $this->cart->update($data);
        redirect('cart/show');
        
    }





    
    
    
    
    
    
    
    
    
}