<h2>Payment Information</h2>

<style>
	input { display: block;}
	
</style>

<?php 
	echo "<p>" . anchor('candystore/cart','Back') . "</p>";
	
	if ($errorMsg) {
		echo "<p>" . $errorMsg . "</p>";
	}

	echo form_open("candystore/payForm");
	
	echo form_label('Credit Card Number'); 
	echo form_error('creditcard_number');
	echo form_input(array('name' => 'creditcard_number', 'maxlength'=>'16'), set_value('creditcard_number'),"required");

	echo form_label('Expiry Month (MM)'); 
	echo form_error('creditcard_month');
	echo form_input(array('name' => 'creditcard_month', 'maxlength'=>'2'), set_value('creditcard_month'),"required");

	echo form_label('Expiry Year (YY)'); 
	echo form_error('creditcard_year');
	echo form_input(array('name' => 'creditcard_year', 'maxlength'=>'2'), set_value('creditcard_month'),"required");


	echo form_submit('submit', 'Submit');
	echo form_close();
?>	

