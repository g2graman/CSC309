<?php

	echo "Yay. logged in as Customer. ";

	echo "user id: ".$this->session->userdata['id'];

	echo "first: ".$this->session->userdata['first'];

	echo '<a href="logout">logout</a>';

	echo '<br><br>';

	echo '<a href="browse">Browse Candy</a>';

?>
