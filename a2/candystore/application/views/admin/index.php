<?php

	echo "Yay. logged in as Admin. ";

	echo "user id: ".$this->session->userdata['id'];

	echo "first: ".$this->session->userdata['first'];

	echo '<a href="logout">logout</a>';

	echo "<br><br>";

	echo '<a href="'. base_url() .'products/index">Product Management</a><br>';
	echo '<a href="'. base_url() .'admin/all_orders">Display All Orders</a><br>';
	echo '<a href="'. base_url() .'admin/mass_delete">Delete Customer and Order Information</a><br>';

?>
