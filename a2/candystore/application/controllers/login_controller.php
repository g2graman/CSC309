<?php

session_start();

class login_controller extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();	    	
    }

    function index() {
    	if($this->session->userdata('logged_in')){
    		$session_data = $this->session->userdata('logged_in');
    		$this->load->view('admin/index.php');
    	} else {
    		$this->load->view('login/login.php');
    	}
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
    		$valid_customer = $valid_customer = $this->login_model->login_exists($login, $password);
    		if($valid_customer != NULL){
    			$this->load->library('session');
    			$product = new Product();
    			$customer = new Customer();
    			
    			// create new customer object
    			$customer->id = $valid_customer->id;
    			$customer->first = $valid_customer->first;
    			$customer->last = $valid_customer->last;
    			$customer->login = $valid_customer->login;
    			$customer->password = $valid_customer->password;
    			$customer->email = $valid_customer->email;
    			
    			//store customer info into array
    			$customer_array = array('id' => $customer->id,
    									'first' => $customer->first,
    									'last' => $customer->last,
    									'login' => $customer->login,
    									'email' => $customer->email);
    			
    			$this->session->set_userdata(array('id' => $customer->id, 'logged_in' => TRUE));
    			$this->session->set_userdata($customer_array);
    			redirect('login_controller/admin', 'refresh');
    			 
    		} else {
    			redirect('login_controller/index', 'refresh');
    		}
       //	}
    	
    	
    }
    
    function logout() {
    	
    	$this->session->unset_userdata('logged_in');
    	session_destroy();
    	redirect('login_controller', 'refresh');
    	
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

