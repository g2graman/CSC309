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
    $this->load->library('session');
    $query = $this->db->get('product');
    $products = $query->result();
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
      $manage_products .= '<th>#</th>';
      $manage_products .= '<th></th>';
      $manage_products .= '<th>Product Name</th>';
      $manage_products .= '<th>Description</th>';
      $manage_products .= '<th>Item Cost</th>';
      $manage_products .= '<th>Edit</th>';
      $manage_products .= '<th>Delete</th>';
      $manage_products .= '<th>View</th>';
      $manage_products .= '</tr>';
      $manage_products .= '</thead>';
      $manage_products .= '<tbody>';
      $counter = 0;
      $quantity = 0;
      $total_cost = 0;
      foreach($products as $product) {
          $counter = $counter + 1;
          $manage_products .= '<tr>';
          $manage_products .= '<td>'. $counter . '</td>';
          $manage_products .= '<td><div class="media">';
          $manage_products .= '<a class="pull-left" href="#">';
          $manage_products .= '<img class="media-object" src="' . base_url() . $product->photo_url . '" width="64px" height="64px" alt="' . $product->name . '"></a>';
          $manage_products .= '</div></td>';
          $manage_products .= '<td>' . $product->name . '</td>';
          $manage_products .= '<td>' . $product->description . '</td>';
          $manage_products .= '<td>' . $product->price . '</td>';
          $manage_products .= '<td><a href="' . base_url() . 'products/editForm/' . $product->id .'"><button class="btn btn-primary">Edit</button></a></td>';
          $manage_products .= '<td><a href="' . base_url() . 'products/delete/' . $product->id .'"><button class="btn btn-primary">Delete</button></a></td>';
          $manage_products .= '<td><a href="' . base_url() . 'products/read/' . $product->id .'"><button class="btn btn-primary">View</button></a></td>';
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
