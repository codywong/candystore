<h2>Your Cart</h2>

<?php 
	echo "<p>" . anchor('candystore/index','Back') . "</p>";

	// if cart is empty, display message
	if (!$items) {
		echo "<p> Your cart is empty! </p>";
		return;
	}

	echo "<table>";
	echo "<tr><th>Quantity</th><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
	
	for ($i = 0; $i<count($items); ++$i) {
		$product = $products[$i];
		$item = $items[$i];

		echo "<tr>";
		echo "<td>";
			// decrement button
			echo form_open("candystore/removeOneFromCart/$product->id", 'class="cartButton"');
			echo form_submit('submit', '-', 'class="cartButton"');
			echo form_close();

			// quantity
			echo "&nbsp" . $item->quantity . "&nbsp";
			
			// increment button
			echo form_open("candystore/addOneToCart/$product->id", 'class="cartButton"');
			echo form_submit('submit', '+', 'class="cartButton"');
			echo form_close();
			echo "</td>";

		echo "<td>" . $product->name . "</td>";
		echo "<td>" . $product->description . "</td>";
		echo "<td>" . $product->price . "</td>";
		echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
			
		echo "</tr>";
	}
	echo "<table>";
?>