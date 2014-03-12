<h2>Submit order</h2>

<?php
  if(isset($show_output)){
    echo 'show output';
    echo $show_output;
  }

  echo form_open('login_controller/verify_user_info');

  echo form_label('Credit Card Number');
  echo form_error('cnum');
  echo form_input('cnum',set_value('cnum'),"required");
  echo '<br>';
  echo '<br>';

  echo form_label('Expiration Month');
  echo form_error('expmonth');
  echo form_input('expmonth',set_value('expmonth'),"required");
  echo '<br>';
  echo '<br>';

  echo form_label('Expiration Year');
  echo form_error('expyear');
  echo form_input('expyear',set_value('expyear'),"required");
  echo '<br>';
  echo '<br>';

  echo form_submit('submit', 'Submit order');
  echo form_close();

  echo '<a href=' . base_url() .'/login_controller>Return</a>';
?>
