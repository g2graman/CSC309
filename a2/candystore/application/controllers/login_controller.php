<?php

session_start();

class login_controller extends CI_Controller {


    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
    }

    function index() {
    	if($this->session->userdata('logged_in')) {
    		$session_data = $this->session->userdata('logged_in');
    		$this->load->view('admin/index.php');
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
    									'email' => $customer->email,
    									'admin' => TRUE);
					$this->session->set_userdata(array('id' => $customer->id, 'logged_in' => TRUE));
					$this->session->set_userdata($customer_array);
					redirect('login_controller/admin', 'refresh');
    			} else {
    				$customer_array = array('id' => $customer->id,
    									'first' => $customer->first,
    									'last' => $customer->last,
    									'login' => $customer->login,
    									'email' => $customer->email,
    									'admin' => FALSE);
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
        echo 'OBEY THE RULES, MOFO';
        $this->load->view('login/new_user.php');
      }



    }




}
