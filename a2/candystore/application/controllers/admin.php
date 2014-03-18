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

      $query = $this->db->get('customer');
      $users = $query->result();

      if ($query->num_rows() > 0) {
        foreach($users as $user) {
          if($user->login != 'admin'){
            $this->db->delete('customer', array('id' => $user->id));
          }
        }
      }

      $this->load->view('layout/header.php');
      $this->load->view('layout/navbar.php');
      $data = array('output' => 'success');
      $this->load->view('admin/mass_delete.php', $data);
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
        $this->load->view('layout/navbar.php');
        $this->load->view('admin/all_orders.php', $data);
      } else {
        $this->load->view('layout/header.php');
        $this->load->view('layout/navbar.php');
        $this->load->view('login/login.php');
      }

    }

    function mass_delete() {
      if($this->admin_logged_in()) {
        $this->load->view('layout/header.php');
        $this->load->view('layout/navbar.php');
        $this->load->view('admin/mass_delete.php');
      } else {
        redirect('login/index', 'refresh');
      }
    }

}
