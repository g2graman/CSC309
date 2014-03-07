<h2>Admin Login</h2>

<?php 
	echo "<!-- <p>" . anchor('candystore/index','Back') . "</p> -->";
	
	echo form_open('login_controller/validate');
		
	echo form_label('Username'); 
	echo form_error('username');
	echo form_input('username',set_value('username'),"required");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password',set_value('password'),"required");
	
	echo form_submit('submit', 'Login');
	echo form_close();
?>	

