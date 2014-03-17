<?php

	echo '<div style="padding-top:60px;"></div>'

?>

<div class="center">

<h1>Welcome <?php echo $this->session->userdata['first']; ?></h1>

<p>Feel free to browse the store and add candy to your cart. When you're ready,
	<?php echo "<a href=' . base_url() .'cart/checkout>Checkout</a>" ?>.


</div>
