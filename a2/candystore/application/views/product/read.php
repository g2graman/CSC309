<div class="ourcenter">
<h2><?php echo $product->name; ?></h2>
<?php
	$browsing = '';
	$browsing .= '<div class="container-fluid">';
	$browsing .= '<div class="row-fluid vertical-center-row">';
	$browsing .= '<div class="col-lg-12">';
	$browsing .= '<div class="row-fluid">';
	$browsing .= '<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">';
	$browsing .= '<ul class="list-group">';
	$browsing .= '<a id="' . $product->id .'" class="">';
	$browsing .= '<a class="thumbnail">';
	$browsing .= '<img src="' . base_url() . $product->photo_url . '" alt="..." >';
	$browsing .= '</a>';
	$browsing .= '<p class="list-group-item-text">';
	$browsing .= '<p><div class="well"><b>Price: $' . $product->price . '</b><br>' . $product->description .'</div></p>';
	$browsing .= '</p>';
	$browsing .= '</a><br><br>';
	$browsing .= '</ul>';
	$browsing .= '</div>';
	$browsing .= '</div>';
	$browsing .= '</div>';
	$browsing .= '</div>';
	$browsing .= '</div>';
	$browsing .= '</div>';
	echo $browsing;
?>

</div>
