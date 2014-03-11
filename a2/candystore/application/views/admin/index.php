<?php

	echo "Yay. logged in as Admin. ";

	echo "user id: ".$this->session->userdata['id'];

	echo "first: ".$this->session->userdata['first'];

	echo '<a href="logout">logout</a>';

	echo "<br><br>";

?>

<ul>
	<li>
		<a href="product_management">Product Management</a>
	</li>
	<li>
		<a href="all_orders">Display All Orders</a>
	</li>
	<li>
		<a href="mass_delete">Delete Customer and Order Information</a>
	</li>
</ul>
