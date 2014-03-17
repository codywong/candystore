candystore
=========

Members: 
Cody Wong		998217503		g2areo
Amelia Gao 	1001041810	


A basic website for a candy store with two types of users:
*note: designed as a private candy store - only admin can create new users

Admin:  (user: admin           pass: admin)
- can create new users
- can add/edit/update/delete items being sold
- view all past orders placed (order id, totals, etc. credit card info is not shown)
- can delete all customer info and orders (from the index)
- shopping/adding things to cart is restricted to customer accounts


Customer
- add and remove items from their cart
- checkout, and provide credit card info
- reciept is auto-emailed to the customer's registration email. If no email is provided
	an error message is given to notify an admin (to which someone will have to manually
	edit the database)
- view and print reciept
