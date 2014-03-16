<?php
  if(isset($error)){
    echo $error;
  }

  echo 'If you would like to print your receipt, <a href="javascript:window.print()">Click to Print This Page</a>';

  echo '<br><br>';

  echo '<h2>Here is a receipt of your purchase.</h2>';

  echo '<br><br>';

  if(isset($receipt_output)){
    echo $receipt_output;
  } else {
    echo 'Error Obtaining Receipt';
  }

  echo '<a href="' . base_url() . 'products/browse">Browse more products</a>';

?>
