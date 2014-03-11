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

  function get($id)
  {
    $query = $this->db->get_where('product',array('id' => $id));

    return $query->row(0,'Product');
  }

  function delete($id) {
    return $this->db->delete("product",array('id' => $id ));
  }

  function insert($product) {
    return $this->db->insert("product", array('name' => $product->name,
                                          'description' => $product->description,
                            'price' => $product->price,
                          'photo_url' => $product->photo_url));
  }

  function update($product) {
    $this->db->where('id', $product->id);
    return $this->db->update("product", array('name' => $product->name,
                                          'description' => $product->description,
                            'price' => $product->price));
  }


}
?>
