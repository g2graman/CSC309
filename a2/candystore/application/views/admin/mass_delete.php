<?php

  echo "Yay. ".$this->session->userdata['login']." is logged in. We are on <b>mass_delete</b> page.";

  echo '<a href="' . base_url() . 'login/logout">logout</a>';

  echo "<br><br>";

?>

<h1>Clear Database</h1>
<p>On this page you are given the option to delete all customer and order information.
This action essentially clears your database of all information, except for the products that
you have already added into the system. This action cannot be reversed.</p>

<a href="' . base_url() . 'admin/perform_delete"> Delete. </a>


<a href="' . base_url() . 'login/index">Back to Admin Home Page</a>
