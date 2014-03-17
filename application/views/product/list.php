<h2>Product Table</h2>
<?php 
		echo "<p>" . anchor('candystore/newForm','Add New Item') . "</p>";
		if ($loggedInAs == 'admin') {
 	  		echo "<p>" . anchor('candystore/newCustomer','Register New Member') . "</p>";
 	  		echo "<p>" . anchor('candystore/viewOrders','View Past Orders') . "</p>";
 	  		echo "<p>" . anchor('candystore/deleteAll', 'Delete all customer and order information', array('onClick' => "return confirm('Are you sure you want to delete?')"))  . "</p>";
 	  	}
 	  
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td class='money'>" . number_format((float)$product->price, 2, '.', '') . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("candystore/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("candystore/editForm/$product->id",'Edit') . "</td>";
			echo "<td>" . anchor("candystore/read/$product->id",'View') . "</td>";
			if ($loggedInAs == 'customer') {
				echo "<td>" . anchor("candystore/addOneToCart/$product->id",'Add to Cart') . "</td>";
			}
				
			echo "</tr>";
		}
		echo "<table>";
?>	

