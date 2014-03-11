<?php

  echo "Yay. ".$this->session->userdata['login']." is logged in. We are on <b>product_management</b> page.";

  echo '<a href="logout">logout</a>';

  echo "<br><br>";

?>

<h1>Product Management</h1>
<p>This page allows you to add, delete or edit all products in your database.</p>


<a href="index">Back to Admin Home Page</a>
