<?php 

	echo "Yay. logged in";
	
	echo "user id: ".$this->session->userdata['id'];
		
	echo "first: ".$this->session->userdata['first'];
	
	echo '<a href="logout">logout</a>';
	
?>