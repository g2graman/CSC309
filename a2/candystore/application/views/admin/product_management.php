
<div class="ourcenter">
<h1>Product Manage</h1>
<p>This page allows you to add, delete or edit all products in your database.</p>


<?php
    if(isset($product_info)){
      echo $product_info;
    } else {
      echo 'Error loading Order History';
    }
?>

</div>
