<div class="ourcenter">

<h1>Clear Database</h1>

<?php

  echo '<div class="container-fluid">';
  echo '<div class="row vertical-center-row">';
  echo '<div class="col-lg-12">';
  echo '<div class="row ">';
  echo '<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">';

  if(isset($output) && $output == "success"){
    echo 'All customers and order information has been deleted from the database.';
  } else {
    echo 'On this page you are given the option to delete all customer and order information. This action essentially clears your database of all information, except for the products that you have already added into the system. This action cannot be reversed.';
  }

  echo '</div>';
  echo '</div>';
  echo '</div>';
  echo '</div>';
  echo '</div>';

?>
<p></p>

<?php echo '<a href="'. base_url() .'admin/perform_delete"><button class="btn btn-default btn-inverse">Delete Customer and Order Information</button></a><br>'; ?>
</div>
