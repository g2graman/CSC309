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
      foreach ($orders as $order){
        $receipt_output .= '<div>Receipt Generated for ' . $this->session->userdata['first'] . ' ' . $this->session->userdata['last'] . '</div>';
        $receipt_output .= '<div> Order ' . $order->id . ' on ' . $order->order_date . ' at ' . $order->order_time .'</div>';

        $receipt_output .= $this->generate_receipt_header();

        $order_item_query = $this->db->get_where('order_item',array('order_id' => $order->id));
        $order_items = $order_item_query->result();
        if($order_item_query->num_rows() > 0){
          foreach($order_items as $item){
            $item_counter = $item_counter + 1;
            $product_name = $this->get_product_name($item->product_id);
            $product_price = $this->get_product_price($item->product_id);
            $total_price = $product_price * $item->quantity;
            $total_quantity = $total_quantity + $item->quantity;

            $receipt_output .= '<div class="row">';
            $receipt_output .= '<div class="col-md-1">' . $item_counter .'</div>';
            $receipt_output .= '<div class="col-md-2">' . $item->product_id . '</div>';
            $receipt_output .= '<div class="col-md-3">' . $product_name . '</div>';
            $receipt_output .= '<div class="col-md-2">' . $item->quantity . '</div>';
            $receipt_output .= '<div class="col-md-2">' . $product_price . '</div>';
            $receipt_output .= '<div class="col-md-2">' . $total_price . '</div>';
            $receipt_output .= '</div>';
          }
        }

        $receipt_output .= '<div>Total Cost of Purchase: ' . $order->total . '      Total Quantity Purchased: ' . $total_quantity .'';
        $receipt_output .= '<br>';
        $receipt_output .= '</div>';
      }
    } else {
      return 'Error generating receipt';
    }

    return $receipt_output;

  }

  function get_product_name($id){
    $product_query = $this->db->get_where('product', array('id' => $id));
    $products = $product_query->result();

    if($product_query->num_rows() == 1){
      foreach($products as $product){
        return $product->name;
      }
    } else {
      return 'Error Accessing Product Name';
    }
  }

  function get_product_price($id){
    $product_query = $this->db->get_where('product', array('id' => $id));
    $products = $product_query->result();

    if($product_query->num_rows() == 1){
      foreach($products as $product){
        return $product->price;
      }
    } else {
      return 'Error Accessing Product Price';
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
