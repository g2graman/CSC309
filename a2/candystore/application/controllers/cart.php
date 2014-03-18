<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

class Cart extends CI_Controller {

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

    /* this function lets use browse through all candy products */
    function browse(){
      $this->load->model('product_model');
      $this->load->library('session');
      if(isset($this->session->userdata['browse_id'])){
        $browse_id = $this->session->userdata['browse_id'];
        $this->session->unset_userdata('browse_id');
        header('Location:' . base_url() . 'cart/browse#' . $browse_id );
      }

      if(!isset($this->session->userdata['total'])){
        $this->session->set_userdata(array('total' => 0));
      }

      if(!isset($this->session->userdata['total_quantity'])){
        $this->session->set_userdata(array('total_quantity' => 0));
      }

      $browse_output = $this->product_model->browse_products();
      $data = array('browse_data' => $browse_output);

      $this->load->view('layout/header.php');
      $this->load->view('layout/navbar.php');
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
        $this->load->view('layout/navbar.php');
        $this->show();
      } else {
        $data = array(
          'error' => 'You are not currently logged in. Please login or create an account to continue.',
          'prev' => 'cart/checkout'
        );
        if(!isset($this->session->userdata['total'])){
          $this->session->set_userdata(array('total' => 0));
        }

        if(!isset($this->session->userdata['total_quantity'])){
          $this->session->set_userdata(array('total_quantity' => 0));
        }
        $this->load->view('layout/header.php');
        $this->load->view('layout/navbar.php');
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
      $this->session->set_userdata(array('browse_id' => $product_id));
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
        } else if($this->session->userdata[$product_id] == 0){
          $this->session->unset_userdata(array($product_id));
        }
      }

      $this->session->set_userdata(array('browse_id' => $product_id));
      $this->browse();
    }

}
