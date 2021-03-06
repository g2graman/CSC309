<?php
$this->load->library('session');
echo '<div class="container">';
echo '<nav class="navbar navbar-inverse navbar-embossed navbar-fixed-top" role="navigation">';
echo '<div class="navbar-header">';
echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">';
echo '</button>';
if(isset($this->session->userdata['login']) && $this->session->userdata['login'] === 'admin'){
  echo '<a class="navbar-brand" href="' . base_url() .'login/index">FRANSHNI CANDY STORE</a>';
} else {
  echo '<a class="navbar-brand" href="' . base_url() . 'cart/browse">FRANSHNI CANDY STORE</a>';
}
echo '</div>';
echo '<div class="collapse navbar-collapse" id="navbar-collapse-01">';
echo '<ul class="nav navbar-nav">';
if(isset($this->session->userdata['login']) && $this->session->userdata['login'] === 'admin'){
  echo '<li><a href="' . base_url() .'login/index">Admin Controls</a></li>';
}
echo '<li><a href="' . base_url() .'cart/browse">Browse Products</a></li>';
echo '<li><a href="' . base_url() .'cart/checkout">Checkout</a></li>';
echo '</ul>';
echo '<div class="container-fluid">';
  if(isset($this->session->userdata['login'])){
    echo '<p class="navbar-text navbar-right">Signed in as ';
	echo '<a class="navbar-link" href="#">' . $this->session->userdata['login'];
  echo '  |  ';
  echo 'Cart Total: ' . $this->session->userdata['total'];
  echo '  |  ';
  echo '<a href="' . base_url() .'login/logout">';
	echo 'Logout';
  echo '</a>';
  } else {
	echo '<p class="navbar-text navbar-right">';
  echo 'Cart Total: ' . $this->session->userdata['total'];
  echo '  |  ';
  echo '<a href="' . base_url() .'login/login">';
	echo 'Login';
	echo '</a>';
  }
echo '</a>';
echo '</p>';
echo '</div>';
echo '</div>';
echo '</nav>';
echo '</div>';
?>
