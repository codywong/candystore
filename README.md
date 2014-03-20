candystore
=========
***SMTP server information is commented out. please provide config information
***or uncomment lines 512-515 in application/contollers/candystore.php

Members: 
Cody Wong		998217503	g2areo
Qiannan Gao	 	1001041810	c4gaoqia


A basic website for a candy store with two types of users:

Admin:  (user: admin           pass: admin)
- can create new users
- can add/edit/update/delete items being sold
- view all past orders placed (order id, totals, etc. credit card info is not shown)
- can delete all customer info and orders (from the index)
- shopping/adding things to cart is restricted to customer accounts


Customer
- can register self
- add and remove items from their cart
- checkout, and provide credit card info
- reciept is auto-emailed to the customer's registration email. If no email is provided
	an error message is given to notify an admin (to which someone will have to manually
	edit the database)
	-> SMTP server is commented out as per assignment description. to enable, uncomment block in payForm 
		function in candystore controller.
- view and print reciept
