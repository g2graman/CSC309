<?php

class Admin extends CI_Controller {

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

    function admin_logged_in() {
      $this->load->library('session');
      if(isset($this->session->userdata['login']) && $this->session->userdata['login'] ==='admin') {
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

    function logout() {
      $this->session->sess_destroy();
      redirect('login', 'refresh');

    }

    function product_management() {
      if($this->admin_logged_in()) {
        $this->load->view('admin/product_management.php');
        /*$this->load->model('order_model');
        $data['order_history'] = $this->order_model->order_history();
        $this->load->view('layout/header.php');
        $this->load->view('admin/all_orders.php'); */
      } else {
        redirect('login/index', 'refresh');
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
        redirect('login/index', 'refresh');
      }
    }

}
