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
      $this->load->view('customer/index.php');
    }

    function loginForm() {
        $this->load->view('login/login.php');
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
          redirect('login/index', 'refresh');
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

}
