<h2>Product Table</h2>
<?php
		echo "<p>" . anchor('products/newForm','Add New') . "</p>";

		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";

		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . $product->photo_url . "' width='100px' /></td>";

			echo "<td>" . anchor("products/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("products/editForm/$product->id",'Edit') . "</td>";
			echo "<td>" . anchor("products/read/$product->id",'View') . "</td>";

			echo "</tr>";
		}
		echo "<table>";

		echo '<a href="' . base_url() . 'login/index">Return Home</a>';
?>
