<h2>Login</h2>

<?php
	if(isset($error)){
		echo $error;
	}

	echo form_open('login/validate');

	echo form_label('Login Username');
	echo form_error('login');
	echo form_input('login',set_value('login'),"required");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password',set_value('password'),"required");

	echo form_submit('submit', 'Login');
	echo form_close();

	echo '<a href=' . base_url() .'login/create_user>Create User</a>';
	echo '<br>';
	echo '<a href=' . base_url() .'login/browse>Browse Candy</a>';
?>
