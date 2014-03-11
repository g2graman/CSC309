<?php
class Product_model extends CI_Model {

	function getAll()
	{
		$query = $this->db->get('product');
		return $query->result('Product');
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

	function browse_products(){
		$query = $this->db->get('product');
		$products = $query->result();
		$browsing = "";
		if($query->num_rows() > 0){
			foreach ($products as $product){
				$browsing .= '<div class="row">';
				  $browsing .= '<div class="col-sm-6 col-md-4">';
				    $browsing .= '<div class="thumbnail">';
				      $browsing .= '<img src="' . base_url() . $product->photo_url . '" alt="..." width="100px" height="100px">';
				      $browsing .= '<div class="caption">';
				        $browsing .= '<h3>' . $product->name .'</h3>';
				        $browsing .= '<p>' . $product->description . '</p>';
				        $browsing .= '<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>';
				      $browsing .= '</div>';
				    $browsing .= '</div>';
				  $browsing .= '</div>';
				$browsing .= '</div>';
			}
		} else {
			$browsing .= 'no products';
		}

		return $browsing;

	}


}
?>
