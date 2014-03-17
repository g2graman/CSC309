<?php

class Login extends CI_Controller {

    function index() {
      if($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        if($this->admin_logged_in()){
          $this->admin();
        } else {
          $this->customer();
        }
      } else {
        $this->loginForm();
      }
    }

    function admin() {
         $this->load->view('admin/index.php');
    }

    function customer() {
      $this->load->view('layout/header.php');
      $this->load->view('layout/navbar.php');
      $this->load->view('customer/index.php');
    }

    function loginForm() {
        $this->load->view('login/login.php');
    }

    function validate() {

      $login = $this->input->get_post('login');
      $password = $this->input->get_post('password');

      if($login==="" || $password ===""){
        redirect('login/loginForm', 'refresh');
      }

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
          redirect('login/admin', 'refresh');
          } else {
            $customer_array = array('id' => $customer->id,
                      'first' => $customer->first,
                      'last' => $customer->last,
                      'login' => $customer->login,
                      'email' => $customer->email);
          $this->session->set_userdata(array('id' => $customer->id, 'logged_in' => TRUE));
          $this->session->set_userdata($customer_array);
          redirect('login/customer', 'refresh');
          }

        } else {
          redirect('login/loginForm', 'refresh');
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

    function admin_logged_in() {
      $this->load->library('session');
      if(isset($this->session->userdata['login']) && $this->session->userdata['login'] ==='admin') {
        return TRUE;
      }
      return FALSE;
    }

    function logout() {
      $this->session->sess_destroy();
      redirect('login', 'refresh');

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
            $receipt_info = $this->display_receipt($order_id);
            $this->email_receipt($order_id, $receipt_info);
          } else {
            echo 'Error: An account with your login or email already exists.';
            //$this->load->view('login/new_user.php');
          }
        } else {
          $data = array('error' => 'You did not correctly fill out your credit card information.');
          $this->load->view('customer/checkout.php', $data);
        }
      }

}
