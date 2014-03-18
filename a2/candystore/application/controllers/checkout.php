<?php

class Checkout extends CI_Controller {

    function index() {
      if($this->session->userdata('logged_in')) {
        $session_data = $this->session->userdata('logged_in');
        $this->browse();
      } else {
        $this->loginForm();
      }
    }

    function is_logged_in() {
      $this->load->library('session');
      if(isset($this->session->userdata['login'])) {
        return TRUE;
      }
      return FALSE;
    }

    function loginForm() {
        $this->load->view('login/login.php');
    }

    function verify_user_info(){
      $this->load->library('session');
      $userInfo['cnum'] = $this->input->get_post('cnum');
      $userInfo['expmonth'] = $this->input->get_post('expmonth');
      $userInfo['expyear'] = $this->input->get_post('expyear');

      $this->load->library('form_validation');
      $this->form_validation->set_rules('cnum','Credit Card Number','required|max_length[16]|min_length[16]');
      $this->form_validation->set_rules('expmonth','Expiration Month','required|integer|min_length[2]|max_length[2]');
      $this->form_validation->set_rules('expyear','Expiration Year','required|integer|min_length[2]|max_length[2]');

      if($this->form_validation->run() == true){
        $this->load->model('product_model');
        if($this->product_model->validate_new_order_info($userInfo)){
          $order_id = $this->product_model->process_order($userInfo);
          $receipt_info = $this->display_receipt($order_id);
          $this->email_receipt($order_id, $receipt_info);
          $this->product_model->reset_cart();
        } else {
          $this->session->set_userdata(array('redirect_value' => 'Error: You did not correctly fill out your Credit Card Information'));
          redirect('cart/checkout', 'refresh');
        }
      } else {
        $this->session->set_userdata(array('redirect_value' => 'Error: You did not correctly fill out your Credit Card Information'));
        redirect('cart/checkout', 'refresh');
      }
    }

    function display_receipt($order_id){
      $this->load->model('order_model');
      $receipt_output = $this->order_model->create_receipt($order_id);
      $data = array('receipt_output' => $receipt_output);
      $this->load->view('layout/header.php');
      $this->load->view('layout/navbar.php');
      $this->load->view('customer/receipt.php', $data);
      return $receipt_output;
    }

    function email_receipt($order_id, $receipt_info){
      $this->load->library('email');
      $config['protocol'] = 'smtp';
      $config['mailpath'] = '/usr/sbin/sendmail';
      $config['charset'] = "utf-8";
      $config['smtp_host'] = 'ssl://smtp.gmail.com';
      $config['smtp_user'] = 'inthemorningtabed@gmail.com';
      $config['smtp_pass'] = '2013cssu2014';
      $config['smtp_port'] = '465';
      $config['mailtype'] = 'html';
      $config['newline'] = "\r\n";


      $this->load->library('session');
      $this->load->model('admin_model');

      $admin_info = $this->admin_model->get_admin_info();

      $this->email->initialize($config);
      $this->email->from($admin_info->email, $admin_info->first . ' ' . $admin_info->last);
      $this->email->to($this->session->userdata['email']);
      $this->email->subject('Receipt #'.$order_id);
      $this->email->message($receipt_info);
      return $this->email->send();
    }
}
