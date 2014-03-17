<?php
class order_model extends CI_Model {

  function getAll()
  {
    $query = $this->db->get('order');
    return $query->result('Product');
  }

  function order_history() {
    $query = $this->db->get('order');
    $orders = $query->result();
    if($query->num_rows() > 0){
      foreach ($orders as $order){
        echo '<div class="row">';
        echo '<div class="col-md-1">'.$order->id.'</div>';
        echo '<div class="col-md-3">'.$order->customer_id.'</div>';
        echo '<div class="col-md-3">'.$order->order_date.'</div>';
        echo '<div class="col-md-3">'.$order->total.'</div>';
        echo '<div class="col-md-2"> View ID </div>';
        echo '<br>';
        echo '</div>';
      }
    } else {
      echo 'no orders';
    }


  }

  function create_receipt($order_id){

    $this->load->library('session');

    $order_query = $this->db->get_where('order',array('id' => $order_id));

    $orders = $order_query->result();
    $receipt_output = "";
    $total_quantity = 0;
    $item_counter = 0;

    if($order_query->num_rows() > 0){
		$receipt_output .= '<div class="container-fluid">';
        $receipt_output .= '<div class="row vertical-center-row">';
        $receipt_output .= '<div class="col-lg-12">';
        $receipt_output .= '<div class="row ">';
        $receipt_output .= '<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">';

      foreach ($orders as $order){
		    $receipt_output .= '<div class="panel panel-info">';
        $receipt_output .= '<div class="panel-heading">Receipt generated for ' . $this->session->userdata['first'] . ' ' . $this->session->userdata['last'] . '</div>';
        $receipt_output .= '<div class="panel-body">';
        $receipt_output .= '<p> Order ' . $order->id . ' on ' . $order->order_date . ' at ' . $order->order_time . '</p>';
        $receipt_output .= '</div>';
		    $receipt_output .= '<table class="table">';
        $receipt_output .= '<thead>';
        $receipt_output .= '<tr>';
        $receipt_output .= '<th>#</th>';
        $receipt_output .= '<th>Product ID</th>';
        $receipt_output .= '<th>Product Name</th>';
        $receipt_output .= '<th>Quantity</th>';
        $receipt_output .= '<th>Cost Per Item</th>';
        $receipt_output .= '</tr>';
        $receipt_output .= '</thead>';
        $receipt_output .= '<tbody>';


        $order_item_query = $this->db->get_where('order_item',array('order_id' => $order->id));
        $order_items = $order_item_query->result();
        $item_counter = 0;
        $quantity_counter = 0;
        if($order_item_query->num_rows() > 0){
          foreach($order_items as $item){
            $product_info = $this->get_product_info($item->product_id);
            $product_price = $product_info->price;
            $product_name = $product_info->name;
    			  $item_counter = $item_counter + 1;
            $quantity_counter = $quantity_counter + $item->quantity;
    			  $receipt_output .= '<tr>';
    			  $receipt_output .= '<td>' . $item_counter . '</td>';
    			  $receipt_output .= '<td>' . $product_name .'</td>';
    			  $receipt_output .= '<td>' . $product_price .'</td>';
    			  $receipt_output .= '<td> ' . $item->quantity . '</td>';
    			  $receipt_output .= '<td> ' . $product_price * $item->quantity . '</td>';
    			  $receipt_output .= '</tr>';
            }
          }

		    $receipt_output .= '</tbody>';
        $receipt_output .= '</table>';
        $receipt_output .= '<div class="panel-footer">Total Cost of Purchase: ' . $order->total . '<br>Total Quantity Purchased: ' . $quantity_counter . '</div>';
        $receipt_output .= '</div>';
        $receipt_output .= '</div>';
        $receipt_output .= '</div>';
        $receipt_output .= '</div>';
        $receipt_output .= '</div>';
		    $receipt_output .= '</div>';
        $receipt_output .= '<div>';
        $receipt_output .= '<br>';
        $receipt_output .= '</div>';
      }
    } else {
      return 'Error generating receipt';
    }

    return $receipt_output;

  }

  function get_product_info($id){
    $product_query = $this->db->get_where('product', array('id' => $id));
    $products = $product_query->result();

    if($product_query->num_rows() == 1){
      foreach($products as $product){
        return $product;
      }
    } else {
      return 'Error Accessing Product Name';
    }
  }

  function generate_receipt_header(){
    $receipt_output = '<div class="row">';
    $receipt_output .= '<div class="col-md-1">Item #</div>';
    $receipt_output .= '<div class="col-md-2">Product ID</div>';
    $receipt_output .= '<div class="col-md-3">Product Name</div>';
    $receipt_output .= '<div class="col-md-2">Quantity</div>';
    $receipt_output .= '<div class="col-md-2">Cost Per Item</div>';
    $receipt_output .= '<div class="col-md-2">Total Cost</div>';
    $receipt_output .= '</div>';
    return $receipt_output;
  }


}
?>
