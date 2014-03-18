<?php
class admin_model extends CI_Model {

  function get_admin_info(){
    $query = $this->db->get_where('customer', array('login' => 'admin'));

    $result = $query->result();

    if ($query->num_rows() > 0) {
      foreach($result as $admin) {
        return $admin;
      }
    } else {
      return 'Error Accessing Admin Information';
    }
  }

  function manage_products(){
    $query = $this->db->get('order');
    $orders = $query->result();
    $manage_products = "";
    if($query->num_rows() > 0){

      $manage_products .= '<div class="container-fluid">';
      $manage_products .= '<div class="row vertical-center-row">';
      $manage_products .= '<div class="col-lg-12">';
      $manage_products .= '<div class="row ">';
      $manage_products .= '<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">';
      $manage_products .= '<div class="panel panel-success">';

      $manage_products .= '<table class="table">';
      $manage_products .= '<thead>';
      $manage_products .= '<tr>';
      $manage_products .= '<th>Order Number</th>';
      $manage_products .= '<th>Customer Name</th>';
      $manage_products .= '<th>Date</th>';
      $manage_products .= '<th>Total Cost</th>';
      $manage_products .= '<th>Edit</th>';
      $manage_products .= '<th>Delete</th>';
      $manage_products .= '<th>View</th>';
      $manage_products .= '</tr>';
      $manage_products .= '</thead>';
      $manage_products .= '<tbody>';

      foreach($orders as $order){

        $customer_info = $this->get_admin_info($order->customer_id);

        $manage_products .= '<tr>';
        $manage_products .= '<td>' . $order->id . '</td>';
        $manage_products .= '<td>' . $customer_info->first . ' ' . $customer_info->last . '</td>';
        $manage_products .= '<td>' . $order->order_date . '</td>';
        $manage_products .= '<td>' . $order->total . '</td>';
        $manage_products .= '<td><a href="' . base_url() . 'products/editForm"><button class="btn btn-primary">Edit</button></a></td>';
        $manage_products .= '<td><a href="' . base_url() . 'products/delete"><button class="btn btn-primary">Delete</button></a></td>';
        $manage_products .= '<td><a href="' . base_url() . 'products/read"><button class="btn btn-primary">View</button></a></td>';
        $manage_products .= '</tr>';

      }

      $manage_products .= '</tbody>';
      $manage_products .= '</table>';
      $manage_products .= '</div>';
      $manage_products .= '</div>';
      $manage_products .= '</div>';
      $manage_products .= '</div>';
      $manage_products .= '</div>';
      $manage_products .= '</div>';

    } else {
      $manage_products .= 'no products';
    }



    return $manage_products;
  }

}
?>
