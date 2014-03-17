<?php

  if(isset($browse_data_customer)){
    echo $browse_data_customer;
  } else if (isset($browse_data)){
    echo '<br><br><br>';
    echo $browse_data;
  } else {
    echo '<br><br>';
    echo 'Error loading page information';
  }

?>
