<?php
$this->load->library('session');
echo '<div class="container">';
echo '<nav class="navbar navbar-inverse navbar-embossed navbar-fixed-top" role="navigation">';
echo '<div class="navbar-header">';
echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">';
echo '</button>';
echo '<a class="navbar-brand" href="#">FRANSHNI CANDY STORE</a>';
echo '</div>';
echo '<div class="collapse navbar-collapse" id="navbar-collapse-01">';
echo '<ul class="nav navbar-nav">';
echo '<li><a href="' . base_url() .'cart/browse">Browse Products</a></li>';
echo '<li><a href="' . base_url() .'cart/checkout">Checkout</a></li>';
echo '</ul>';
echo '<div class="container-fluid">';
  if(isset($this->session->userdata['login'])){
    echo '<p class="navbar-text navbar-right">Signed in as ';
	echo '<a class="navbar-link" href="#">' . $this->session->userdata['login'];
  echo '<a href="' . base_url() .'login/logout">';
	echo '<button class="btn btn-default btn-inverse">';
	echo 'Logout';
	echo '</button>';
  echo '</a>';
  } else {
	echo '<p class="navbar-text navbar-right">Not logged in';
	echo '<a class="navbar-link" href="#">';
	echo '<button class="btn btn-default btn-inverse">';
	echo 'Login';
	echo '</button>';
  }
echo '</a>';
echo '</p>';
echo '</div>';
echo '</div>';
echo '</nav>';
echo '</div>';
?>
