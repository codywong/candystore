<?php 
echo "<p>" . anchor('candystore/logout','Logout') . "</p>";
if ($loggedInAs == 'customer') {
	echo "<p>" . anchor('candystore/cart','View Cart') . "</p>";
}
echo "<p>" . anchor('candystore/index','Home') . "</p>";
?>

<h1>Best Candy Store</h1>