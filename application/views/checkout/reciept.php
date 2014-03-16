<h2>Order Complete</h2>

<?php 
	echo "<p>" . anchor('candystore/index','Back') . "</p>";
	echo "<p> Thank you for shopping at the Candy store </p>";


?>	


<form>
	<input type=button value="View or Print Reciept" onClick="reciept()">
</form>

<script language="JavaScript">

	var quantity = <?php echo json_encode($quantity); ?>;
	var name = <?php echo json_encode($name); ?>;
	var price = <?php echo json_encode($price); ?>;
	var order_id = <?php echo json_encode($order_id); ?>;
	var total = <?php echo json_encode($total); ?>;

	function reciept() {
	 top.wRef=window.open('','myconsole',
	  'width=500,height=450,left=10,top=10'
	   +',menubar=1'
	   +',toolbar=0'
	   +',status=1'
	   +',scrollbars=1'
	   +',resizable=1')
	 top.wRef.document.writeln(
	  '<html><head><title>Order Reciept</title></head>'
	 +'<body bgcolor=white onLoad="self.focus()">'
	 +'<center><font color=red><b><i>For printing, <a href=# onclick="window.print();return false;">click here</a> or press Ctrl+P</i></b></font>'
	 +'<H3>Order Reciept</H3>'
	 +'<table border=0 cellspacing=3 cellpadding=3>'
	 )

	buf='';

	buf+='Order Id: ' + order_id + '<br>';
	buf+='Total: ' + parseFloat(total).toFixed(2) + '<br>';

	buf+='<tr><th>Quantity</th><th>Name</th><th>Price (ea)</th><th>Item Subtotal</th>  </tr>';

	for (i = 0; i<quantity.length; i++) {
		buf+= '<tr><td>'+quantity[i]+'</td><td>'+name[i]+"</td><td style='text-align:right;'>"+parseFloat(price[i]).toFixed(2)+'</td>';
		buf+= "<td style='text-align:right;'>"+parseFloat(price[i]*quantity[i]).toFixed(2)+'</td> </tr>'
	}

	buf += '</table></center></body></html>'
 	top.wRef.document.writeln(buf)
 	top.wRef.document.close()
}
</script>


