
<div class="ourcenter">

<h1>Welcome <?php echo $this->session->userdata['first']; ?></h1>



<?php

	echo '<a href="'. base_url() .'products/index"><button class="btn btn-default btn-inverse">Product Management</button></a><br>';
	echo '<br>';
	echo '<a href="'. base_url() .'admin/all_orders"><button class="btn btn-default btn-inverse">Display Orders</button></a><br>';
	echo '<br>';
	echo '<a href="'. base_url() .'admin/mass_delete"><button class="btn btn-default btn-inverse">Delete Customers and Orders</button></a><br>';

?>


</div>
