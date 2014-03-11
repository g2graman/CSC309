<h2>Create a New Account</h2>

<?php
  echo form_open('login_controller/new_user');

  echo form_label('First Name');
  echo form_error('first');
  echo form_input('first',set_value('first'),"required");
  echo '<br>';
  echo '<br>';

  echo form_label('Last Name');
  echo form_error('last');
  echo form_input('last',set_value('last'),"required");
  echo '<br>';
  echo '<br>';

  echo form_label('Login Name');
  echo form_error('login');
  echo form_input('login',set_value('login'),"required");
  echo '<br>';
  echo '<br>';

  echo form_label('Password');
  echo form_error('password');
  echo form_password('password',set_value('password'),"required");
  echo '<br>';
  echo '<br>';

  echo form_label('Email');
  echo form_error('email');
  echo form_input('email',set_value('email'),"required");
  echo '<br>';
  echo '<br>';

  echo form_submit('submit', 'Create New Account');
  echo form_close();

  echo '<a href=' . base_url() .'/login_controller>Return</a>';
?>
