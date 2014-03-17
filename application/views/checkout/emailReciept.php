<link rel="stylesheet" href="<?=  base_url(); ?>css/receipt.css">
<center>
<h3>Order Reciept</h3>

<?php 
	echo "Order ID: $order_id <br>";
	echo "Total: ".number_format((float)$total, 2, '.', '');

	echo "<table border=0 cellspacing=3 cellpadding=3>";
	echo "<tr><th>Quantity</th><th>Name</th><th>Price (ea)</th><th>Item Subtotal</th></tr>";

	for ($i = 0; $i<count($quantity); $i++) {
		echo "<tr>";
			echo "<td>".$quantity[$i]."</td>";
			echo "<td>".$name[$i]."</td>";
			echo "<td class='money'>".number_format((float)$price[$i], 2, '.', '')."</td>";
			echo "<td class='money'>".number_format((float)$quantity[$i]*$price[$i], 2, '.', '')."</td>";
		echo "</tr>";
	}
	echo "</table>";

?>

</center>