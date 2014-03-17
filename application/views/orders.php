<h2>Placed Orders</h2>
<?php 
		echo "<p>" . anchor('candystore/index','Back') . "</p>";
 	  
		echo "<table>";
		echo "<tr><th>Order ID</th><th>Customer ID</th><th>Order Date</th>";
		echo "<th>Order Time</th><th>Total</th></tr>";
		
		foreach ($orders as $order) {
			echo "<tr>";
			echo "<td>" . $order->id . "</td>";
			echo "<td>" . $order->customer_id . "</td>";			
			echo "<td>" . $order->order_date . "</td>";			
			echo "<td>" . $order->order_time . "</td>";
			echo "<td>" . $order->total . "</td>";
			echo "</tr>";
		}
		echo "<table>";
?>	