<?php

session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
class login_controller extends CI_Controller {


    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
    }

    function index() {
    	if($this->session->userdata('logged_in')) {
    		$session_data = $this->session->userdata('logged_in');
        if($this->admin_logged_in()){
          $this->load->view('admin/index.php');
        } else {
          $this->load->view('customer/index.php');
        }
    	} else {
    		$this->load->view('login/login.php');
    	}
    }

    function admin() {
      if($this->admin_logged_in()) {
    	   $this->load->view('admin/index.php');
      } else {
        $this->load->view('login/error.php');
      }
    }

    function customer() {
    	$this->load->view('customer/index.php');
    }

    function loginForm() {
	    	$this->load->view('login/loginForm.php');
    }

    function validate() {
    	$login = $this->input->get_post('login');
    	$password = $this->input->get_post('password');

      $this->load->library('form_validation');
    	$this->form_validation->set_rules('login','Login','required');
    	$this->form_validation->set_rules('password','Password','required');

    	if($this->form_validation->run() == true){

    		$this->load->model('login_model');
    		$this->load->model('customer');
    		$valid_customer = $valid_customer = $this->login_model->login_exists($login, $password);
    		if($valid_customer != NULL){
    			$this->load->library('session');
    			$customer = new Customer();

    			// create new customer object
    			$customer->id = $valid_customer->id;
    			$customer->first = $valid_customer->first;
    			$customer->last = $valid_customer->last;
    			$customer->login = $valid_customer->login;
    			$customer->password = $valid_customer->password;
    			$customer->email = $valid_customer->email;

    			//check if user is admin, store user info into array
    			if($login === "admin" || $login === "Admin"){
    				$customer_array = array('id' => $customer->id,
    									'first' => $customer->first,
    									'last' => $customer->last,
    									'login' => $customer->login,
    									'email' => $customer->email);
					$this->session->set_userdata(array('id' => $customer->id, 'logged_in' => TRUE));
					$this->session->set_userdata($customer_array);
					redirect('login_controller/admin', 'refresh');
    			} else {
    				$customer_array = array('id' => $customer->id,
    									'first' => $customer->first,
    									'last' => $customer->last,
    									'login' => $customer->login,
    									'email' => $customer->email);
					$this->session->set_userdata(array('id' => $customer->id, 'logged_in' => TRUE));
					$this->session->set_userdata($customer_array);
	    		redirect('login_controller/customer', 'refresh');
    			}

    		} else {
    			redirect('login_controller/index', 'refresh');
    		}
      }


    }

    function is_logged_in() {
      $this->load->library('session');
      if(isset($this->session->userdata['login'])) {
        return TRUE;
      }
      return FALSE;
    }

    function perform_delete() {
      $this->db->empty_table('order_item');
      $this->db->empty_table('order');
      $this->db->empty_table('customer');
      $this->load->view('admin/deleted.php');
    }

    function admin_logged_in() {
      $this->load->library('session');
      if(isset($this->session->userdata['login']) && $this->session->userdata['login'] ==='admin') {
        return TRUE;
      }
      return FALSE;
    }

    function logout() {
      $this->session->sess_destroy();
      redirect('login_controller', 'refresh');

    }

    function product_management() {
      if($this->admin_logged_in()) {
        $this->load->view('admin/product_management.php');
        /*$this->load->model('order_model');
        $data['order_history'] = $this->order_model->order_history();
        $this->load->view('layout/header.php');
        $this->load->view('admin/all_orders.php'); */
      } else {
        redirect('login_controller/index', 'refresh');
      }
    }

    function all_orders() {
      if($this->admin_logged_in()) {
        //echo 'inside all orders';
        $this->load->model('order_model');
        //echo 'loaded order_model';
        $data['order_history'] = $this->order_model->order_history();
        //echo 'order_history';
        $this->load->view('layout/header.php');
        $this->load->view('admin/all_orders.php');
      } else {
        $this->load->view('layout/header.php');
        $this->load->view('login/error.php');
      }

    }

    function mass_delete() {
      if($this->admin_logged_in()) {
        $this->load->view('admin/mass_delete.php');
        /*$this->load->model('order_model');
        $data['order_history'] = $this->order_model->order_history();
        $this->load->view('layout/header.php');
        $this->load->view('admin/all_orders.php'); */
      } else {
        redirect('login_controller/index', 'refresh');
      }
    }

    function create_user(){
      $this->load->view('login/new_user.php');
    }

    function new_user(){
      $userInfo['first'] = $this->input->get_post('first');
      $userInfo['last'] = $this->input->get_post('last');
      $userInfo['login'] = $this->input->get_post('login');
      $userInfo['password'] = $this->input->get_post('password');
      $userInfo['email'] = $this->input->get_post('email');

      $this->load->library('form_validation');
      $this->form_validation->set_rules('login','Login','required|max_length[16]');
      $this->form_validation->set_rules('password','Password','required|min_length[6]|max_length[16]');
      $this->form_validation->set_rules('first','First','required|max_length[24]');
      $this->form_validation->set_rules('last','Last','required|max_length[24]');
      $this->form_validation->set_rules('email','Email','valid_email|required|max_length[45]');

      if($this->form_validation->run() == true){
        $this->load->model('customer_model');

        if($this->customer_model->validate_new_user_info($userInfo)){
          $this->customer_model->create_user($userInfo);
          $this->load->view('login/success.php');
          $this->load->view('login/login.php');
        } else {
          echo 'Error: An account with your login or email already exists.';
          $this->load->view('login/new_user.php');
        }
      } else {
        $this->load->view('login/new_user.php');
      }



    }

    /* this function lets use browse through all candy products */
    function browse(){
      $this->load->model('product_model');
      $this->load->library('session');
      if(!isset($this->session->userdata['total'])){
        $this->session->set_userdata(array('total' => 0));
      }
      if(!isset($this->session->userdata['total_quantity'])){
      	$this->session->set_userdata(array('total_quantity' => 0));
      }

      $browse_output = $this->product_model->browse_products();
      $data = array('browse_data' => $browse_output);
      //echo $data;
      //$this->load->view->('customer/browse.php');
      $this->load->view('layout/header.php');
      $this->load->view('customer/browse.php', $data);
    }

    function checkout(){
      if($this->is_logged_in()){
        $this->load->model('order_model');
        $this->load->library('session');
        if(!isset($this->session->userdata['total'])){
          $this->session->set_userdata(array('total' => 0));
        }
        if(!isset($this->session->userdata['total_quantity'])){
        	$this->session->set_userdata(array('total_quantity' => 0));
        }
        $this->load->view('layout/header.php');
        $this->show();
        //$this->collect_user_info();
        //$this->verify_user_info();
        //$this->process_order();
        //$this->display_receipt();
        //$this->email_receipt();
      } else {
        $data = array(
          'error' => 'You are not currently logged in. Please login or create an account to continue.',
          'prev' => 'login_controller/checkout'
        );
        $this->load->model('login_model');
        $this->load->view('login/login.php', $data);
      }
    }

    function show() {
      $this->load->model('product_model');
      $show_output = $this->product_model->show_cart();
      $data = array('show_output' => $show_output);
      $this->load->view('layout/header.php');
      $this->load->view('customer/checkout.php', $data);
    }

      function add_to_cart() {
        $product_id = $this->uri->segment(3);
        $this->load->library('session');

        if(isset($this->session->userdata[$product_id])){
          $newValue = $this->session->userdata[$product_id] + 1;
          $this->session->set_userdata(array($product_id => $newValue));
        } else {
          $this->session->set_userdata(array($product_id => 1));
        }

        $this->load->model('product_model');
        $product_info = $this->product_model->getPrice($product_id);

        $old_total = $this->session->userdata['total'];
        $old_quant = $this->session->userdata['total_quantity'];
        $this->session->set_userdata(array('total' => $old_total + $product_info->price));
        $this->session->set_userdata(array('total_quantity' => $old_quant + 1));
        $this->browse();
      }

      function remove_from_cart($product_id) {
        $product_id = $this->uri->segment(3);
        $this->load->library('session');

        $this->load->model('product_model');
        $product_info = $this->product_model->getPrice($product_id);

        if(isset($this->session->userdata[$product_id])) {
          if($this->session->userdata[$product_id] >= 1) {
            $newValue = $this->session->userdata[$product_id] - 1;
            $this->session->set_userdata(array($product_id => $newValue));
            $old_quant = $this->session->userdata['total_quantity'];
            $this->session->set_userdata(array('total_quantity' => $old_quant - 1));

            if ($this->session->userdata['total_quantity'] <= 0){
            	$this->session->set_userdata(array('total' => 0));
            } else {
            	$old_total = $this->session->userdata['total'];
            	$this->session->set_userdata(array('total' => $old_total - $product_info->price));
            }
           }
        }

        $this->browse();
      }


      function verify_user_info(){
        $userInfo['cnum'] = $this->input->get_post('cnum');
        $userInfo['expmonth'] = $this->input->get_post('expmonth');
        $userInfo['expyear'] = $this->input->get_post('expyear');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('cnum','Credit Card Number','required|max_length[16]|min_length[16]');
        $this->form_validation->set_rules('expmonth','Expiration Month','required|integer|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('expyear','Expiration Year','required|integer|min_length[4]|max_length[4]');

        if($this->form_validation->run() == true){
          $this->load->model('product_model');
          if($this->product_model->validate_new_order_info($userInfo)){
            $order_id = $this->product_model->process_order($userInfo);
            $this->display_receipt($order_id);
            $this->email_receipt();
          } else {
            echo 'Error: An account with your login or email already exists.';
            //$this->load->view('login/new_user.php');
          }
        } else {
          $data = array('error' => 'You did not correctly fill out your credit card information.');
          $this->load->view('customer/checkout.php', $data);
        }
      }

      function display_receipt($order_id){
        echo 'inside display_receipt';
        $this->load->model('order_model');
        $receipt_output = $this->order_model->create_receipt($order_id);
        $data = array('receipt_output' => $receipt_output);
        $this->load->view('layout/header.php');
        $this->load->view('customer/receipt.php', $data);
      }

      function email_receipt(){
        echo 'inside email_receipt';
      }





}
