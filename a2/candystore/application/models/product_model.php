<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
class Product_model extends CI_Model {

	function getAll()
	{
		$query = $this->db->get('product');
		return $query->result('Product');
	}

	function get($id)
	{
		$query = $this->db->get_where('product',array('id' => $id));
		$result = $query->result();
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

	function getPrice($id){
		$query = $this->db->get_where('product',array('id' => $id));
		return $query->row(0,'Product');
	}

	function browse_products(){
		$this->load->library('session');
		$this->load->view('layout/header.php');
		//$this->load->view('layout/navbar.php');
		$query = $this->db->get('product');
		$products = $query->result();
		$browsing = "";
		if($query->num_rows() > 0){
			$browsing .= '<div class="container-fluid">';
			$browsing .= '<div class="row-fluid vertical-center-row">';
			$browsing .= '<div class="col-lg-12">';
			$browsing .= '<div class="row-fluid">';
			$browsing .= '<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">';
			$browsing .= '<ul class="list-group">';
			foreach ($products as $product){
				$browsing .= '<a id="' . $product->id .'" class="">';
				$browsing .= '<a class="thumbnail">';
				$browsing .= '<img src="' . base_url() . $product->photo_url . '" alt="..." >';
				$browsing .= '</a>';
				$browsing .= '<h4 class="list-group-item-heading">'. $product->name .'';
				if(isset($this->session->userdata[$product->id])){
					$browsing .= '<span class="label label-default pull-right">' . $this->session->userdata[$product->id] . '</span>';
				} else {
					$browsing .= '<span class="label label-default pull-right">0</span>';
				}
				$browsing .= '</h4>';
				$browsing .= '<p class="list-group-item-text">';
				$browsing .= '<p><div class="well"><b>Price: $' . $product->price . '</b><br>' . $product->description .'</div></p>';
				$browsing .= '<a href="' . base_url() .'cart/add_to_cart/'.$product->id.'" class="btn btn-primary pull-left" role="button">Add to Cart</a>';
				$browsing .= '<a href="' . base_url() .'cart/remove_from_cart/'.$product->id.'" class="btn btn-default pull-right" role="button">Remove From Cart</a>';
				$browsing .= '</p>';
				$browsing .= '</a><br><br>';
			}
			$browsing .= '</ul>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
		} else {
			$browsing .= 'no products';
		}
		return $browsing;
	}

	function show_cart() {
		$this->load->library('session');
		$query = $this->db->get('product');
		$products = $query->result();
		$browsing = "";
		if($query->num_rows() > 0){
			$browsing .= '<div class="container-fluid">';
			$browsing .= '<div class="row vertical-center-row">';
			$browsing .= '<div class="col-lg-12">';
			$browsing .= '<div class="row ">';
			$browsing .= '<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">';
			$browsing .= '<div class="panel panel-success">';

			$browsing .= '<table class="table">';
			$browsing .= '<thead>';
			$browsing .= '<tr>';
			$browsing .= '<th>#</th>';
			$browsing .= '<th></th>';
			$browsing .= '<th>Product Name</th>';
			$browsing .= '<th>Quantity</th>';
			$browsing .= '<th>Item Cost</th>';
			$browsing .= '<th>Total Cost</th>';
			$browsing .= '</tr>';
			$browsing .= '</thead>';
			$browsing .= '<tbody>';
			$counter = 0;
			$quantity = 0;
			$total_cost = 0;
			foreach($products as $product) {
				if (isset($this->session->userdata[$product->id]) && $this->session->userdata[$product->id] > 0) {
					$counter = $counter + 1;
					$browsing .= '<tr>';
					$browsing .= '<td>'. $counter . '</td>';
					$browsing .= '<td><div class="media">';
					$browsing .= '<a class="pull-left" href="#">';
					$browsing .= '<img class="media-object" src="' . base_url() . $product->photo_url . '" width="64px" height="64px" alt="' . $product->name . '"></a>';
					$browsing .= '</div></td>';
					$browsing .= '<td>' . $product->name . '</td>';
					$browsing .= '<td>' . $this->session->userdata[$product->id] . '</td>';
					$browsing .= '<td>' . $product->price . '</td>';
					$browsing .= '<td>' . $product->price * $this->session->userdata[$product->id] . '</td>';
					$browsing .= '</tr>';

					$quantity = $quantity + $this->session->userdata[$product->id];
					$total_cost = $total_cost + $product->price * $this->session->userdata[$product->id];

				}
			}

			$browsing .= '</tbody>';
			$browsing .= '</table>';
			$browsing .= '<div class="panel-footer">Total Cost: $'. $total_cost . '<br>Total Quantity: '. $quantity .'</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';
			$browsing .= '</div>';

		} else {
			$browsing .= 'no products';
		}

		return $browsing;
	}



	function validate_new_order_info($userInfo){

		$cnum = $userInfo['cnum'];
		$expmonth = $userInfo['expmonth'];
		$expyear = $userInfo['expyear'];

		$year = "%Y";
		$month = "%m";
		$time = time();

		$full_year = mdate($year, $time);
		$the_year = substr($full_year, -2);
		$the_month = mdate($month, $time);

		if($expmonth < 0 || $expmonth > 12 ){
			return false;
		}

		if($expyear == $the_year){
			if($the_month > $expmonth){
				return false;
			}
		}

		if($expyear > 100 || $expyear < $the_year){
			return false;
		}

		return true;
	}

	function process_order($userInfo){

		$this->load->helper('date');
		$this->load->library('session');

		$datestring = "%Y-%m-%d";
		$timestring = "%h:%i:%s";
		$time = time();

		$the_date = mdate($datestring, $time);
		$the_time = mdate($timestring, $time);

		$total = 0;
		$query = $this->db->get('product');
		$products = $query->result();

		$this->db->insert("order", array('customer_id' => $this->session->userdata['id'],
																		 'order_date' => $the_date,
																		 'order_time' => $the_time,
																		 'total' => $this->session->userdata['total'],
																		 'creditcard_number' => $userInfo['cnum'],
																	   'creditcard_month' => $userInfo['expmonth'],
																	   'creditcard_year' => $userInfo['expyear']));

		$order_id = $this->db->insert_id();

		foreach($products as $product){
			if (isset($this->session->userdata[$product->id])) {
				$this->db->insert("order_item", array('order_id' => $order_id,
																							'product_id' => $product->id,
																							'quantity' => $this->session->userdata[$product->id]));
			}
		}

		return $order_id;
	}



	function reset_cart(){
		$query = $this->db->get('product');
		$products = $query->result();

		$this->load->library('session');

		foreach($products as $product){
			if (isset($this->session->userdata[$product->id])) {
				$this->session->unset_userdata($product->id);
			}
		}

		$this->session->unset_userdata('total');
		$this->session->unset_userdata('total_quantity');
	}

}
?>
