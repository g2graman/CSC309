<div class="ourcenter">
<?php
  if(isset($error)){
    echo $error;
  }

  echo '<h2>Here is a receipt of your purchase.</h2>';

  if(isset($receipt_output)){
    echo $receipt_output;
  } else {
    echo 'Error Obtaining Receipt';
  }

  echo '<a href="javascript:window.print()">Click to Print This Page</a>';

?>

</div>
