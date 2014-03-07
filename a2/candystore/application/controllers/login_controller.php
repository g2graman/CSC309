<?php

class login_controller extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();	    	
    }

    function index() {
    		$this->load->view('login/login.php');
    }
    
    function admin() {
    	$this->load->view('admin/index.php');
    }
    
    function loginForm() {
	    	$this->load->view('login/loginForm.php');
    }
    
    function validate() {
    	$login = $this->input->get_post('login');
    	$password = $this->input->get_post('password');
    	/*$this->load->library('form_validation');
    	$this->form_validation->set_rules('login','Login','required|is_unique[login]');
    	$this->form_validation->set_rules('password','Password','required');
    	*/
    	//if($this->form_validation->run() == true){
    	
    		$this->load->model('login_model');
    		$this->load->model('customer');
    		echo "login: ".$login;
    		echo "pass: ".$password;
    		$valid_customer = $valid_customer = $this->login_model->login_exists($login, $password);
    		print_r($valid_customer);
    		if($valid_customer != FALSE){
    			echo "inside if";
    			$product = new Product();
    			echo "product";
    			$customer = new Customer();
    			echo "customer?";
    			
    			$customer->id = $valid_customer->id;
    			$customer->first = $valid_customer->first;
    			$customer->last = $valid_customer->last;
    			$customer->login = $valid_customer->login;
    			$customer->password = $valid_customer->password;
    			$customer->email = $valid_customer->email;
    			redirect('login_controller/admin', 'refresh');
    			 
    		} else {
    			redirect('login_controller/index', 'refresh');
    		}
       //	}
    	
    	
    }
    
	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
    	
	function delete($id) {
		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');
	}
      
   
    
    
    
}

