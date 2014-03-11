<h2>Admin Login</h2>

<?php
	echo "<!-- <p>" . anchor('candystore/index','Back') . "</p> -->";

	echo form_open('login_controller/validate');

	echo form_label('Login Username');
	echo form_error('login');
	echo form_input('login',set_value('login'),"required");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password',set_value('password'),"required");

	echo form_submit('submit', 'Login');
	echo form_close();

	echo '<a href=' . base_url() .'login_controller/create_user>Create User</a>';
?>
