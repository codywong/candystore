<?php

session_start();
class CandyStore extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	    		    	
	    	$this->load->library('upload', $config);
	    	
    }

    function index() {
    		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
			{
    			redirect('candystore/login', 'refresh');
    			return;
    		}

    		$this->load->model('product_model');
    		$products = $this->product_model->getAll();
    		$data['products']=$products;
    		$data['main']='product/list.php';
    		$this->load->view('template',$data);
    }
    
    function newForm() {
    	    if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
			{
    			redirect('candystore/login', 'refresh');
    			return;
    		}
    		$data['main']='product/newForm.php';
	    	$this->load->view('template', $data);
    }
    
    function newCustomer() {
    		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
			{
    			redirect('candystore/login', 'refresh');
    			return;
    		}
    		$data['main']='customer/newCustomer.php';
	    	$this->load->view('template', $data);
    }

	function create() {
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			$data['main']='product/newForm.php';
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('template',$data);
				return;
			}
			

			$this->load->view('template', $data);
		}	
	}
	
	function createCustomer() {
			if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
			{
    			redirect('candystore/login', 'refresh');
    			return;
    		}
		/*$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();*/
		
		if (true) {
			$this->load->model('customer_model');

			$customer = new Customer();
			$customer->first = $this->input->get_post('first');
			$customer->last = $this->input->get_post('last');
			$customer->login = $this->input->get_post('login');
			$customer->password = $this->input->get_post('password');
			$customer->email = $this->input->get_post('email');
			
			$this->customer_model->insert($customer);

			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			$data['main']='customer/newCustomer.php';
			$this->load->view('template', $data);
		}	
	}
	
	function read($id) {
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$data['main']='product/read.php';
		$this->load->view('template',$data);
	}
	
	function editForm($id) {
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$data['main']='product/editForm.php';
		$this->load->view('template',$data);
	}
	
	function update($id) {
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$data['main']='product/editForm.php';
			$this->load->view('template',$data);
		}
	}
    	
	function delete($id) {
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');
	}

	function logout() {
		// clear session and redirect to login page
		session_unset();
		session_destroy();
		redirect('candystore/login', 'refresh');
	}
    
	function login() {
		$_SESSION['loggedInAs'] = "";

		$this->load->library('form_validation');
		$this->form_validation->set_rules('login','Login','required');
		$this->form_validation->set_rules('password','Password','required');

		
		if ($this->form_validation->run() == true) {

			$customer = new Customer;
			$customer->login = htmlspecialchars($this->input->get_post('login'));
			$customer->password = htmlspecialchars($this->input->get_post('password'));

			// check database for valid login info
			$this->load->model('customer_model');
			$authenticated = $this->customer_model->checkCredentials($customer);

			// if user and pass are admin, log in as admin
			if ($customer->login == 'admin' && $customer->password == 'admin') {
				$_SESSION['loggedInAs'] = "admin";
				redirect('candystore/index', 'refresh');
			}
			// if valid credentials, log in as customer
			elseif ($authenticated->num_rows() > 0) {
				$_SESSION['loggedInAs'] = "customer";
				$_SESSION['customerID'] = $authenticated->row()->id;
				redirect('candystore/index', 'refresh');
			}
			// invalid credentials, go back to login
			else {
				$data['errorMsg'] = "Invalid username or password";
				$this->load->view('login.php', $data);	
			}
		}
		else {
			$data['errorMsg'] = "";
			$this->load->view('login.php', $data);	

		}	
	}


	function cart(){
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		$total = 0;
		$products = array();
		$items = array();

		if (isset($_SESSION['cart'])) {
			$items = unserialize($_SESSION['cart']);
			$this->load->model('product_model');
			// find each item in cart's associated product information and store in product
			foreach ($items as $item) {
				$product = $this->product_model->get($item->product_id);
				$products[] = $product;
				// increment the total
				$total+= $item->quantity * $product->price;
			}
		}

		$data['items'] = $items;
		$data['products'] = $products;
		$data['total'] = $total;
		// store total in session as well
		$_SESSION['total'] = $total;

		$data['main']='checkout/viewCart.php';
		$this->load->view('template', $data);
	}

	// adds one instance of the item into the cart
	function addOneToCart($id){
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		// cart is empty, add the item with quantity one
		if (!isset($_SESSION['cart']) || !$_SESSION['cart']) {
			$item = new Order_item;
			$item->product_id = $id;
			$item->quantity = 1;
			
			$_SESSION['cart'] = serialize(array($item));

		} 
		// items are already in the cart
		else {
			// check the cart for an already existing version of item
			$existing = false;
			$items = unserialize($_SESSION['cart']);
			foreach ($items as $item) {

				if ($item->product_id == $id) {

					$item->quantity++;
					$existing = true;
				}
			}
			// item is not found in the cart - add it
			if (!$existing) {
				$item = new Order_item;
				$item->product_id = $id;
				$item->quantity = 1;

				$items[] = $item;
			}

			// re-store updated values
			$_SESSION['cart'] = serialize($items);
		}

		// re-direct to the cart
		$this->cart();
	}

	function removeOneFromCart($id){
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		// find the item to be decremented
		$items = unserialize($_SESSION['cart']);
		for ($index = 0; $index<count($items); $index++) {
			if ($items[$index]->product_id == $id) {
				$items[$index]->quantity--;
				break;
			}
		}

		// if quantity of an item is <= 0, remove it from the cart
		if ($items[$index]->quantity <= 0) {
			unset($items[$index]);
			// reindex the array
			$items = array_values($items);

		}
		
		// re-store updated values
		$_SESSION['cart'] = serialize($items);

		// re-direct to the cart
		$this->cart();
	}

	function removeFromCart($id){
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		// find the item to be decremented
		$items = unserialize($_SESSION['cart']);
		for ($index = 0; $index<count($items); $index++) {
			if ($items[$index]->product_id == $id) {
				// remove item from cart
				unset($items[$index]);
				// reindex the array
				$items = array_values($items);
				break;
			}
		}

		// re-store updated values
		$_SESSION['cart'] = serialize($items);

		// re-direct to the cart
		$this->cart();
	}

	function checkout(){
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		if (!isset($_SESSION['cart']) || !$_SESSION['cart']) {
			$this->cart();
			return;
		}

		$data['main']='checkout/paymentInfo.php';
		$this->load->view('template',$data);
	}

	function payForm(){
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			redirect('candystore/login', 'refresh');
			return;
		}

		// if cart is empty
		if (!isset($_SESSION['cart']) || !$_SESSION['cart']) {
			$this->cart();
			return;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('creditcard_number','Credit Card Number','required');
		$this->form_validation->set_rules('creditcard_month','Expiry Month (MM)','required');
		$this->form_validation->set_rules('creditcard_year','Expiry Year (YY)','required');

		if ($this->form_validation->run() == true) {
			$this->load->model('order_model');
			$this->load->model('order_item_model');
			$this->load->model('product_model');

			// create the order
			$order = new Order();
			$order->customer_id = $_SESSION['customerID'];
			$order->order_date = date("Y-m-d", time());		// dd-mm-yy
			$order->order_time = date("G:i:s", time());		// 24hour: hh:mm:ss
			$order->total = $_SESSION['total'];
			$order->creditcard_number = htmlspecialchars($this->input->get_post('creditcard_number')); 
			$order->creditcard_month = htmlspecialchars($this->input->get_post('creditcard_month'));
			$order->creditcard_year = htmlspecialchars($this->input->get_post('creditcard_year'));

			// add order to database
			$order_id = $this->order_model->insert($order);

			// create arrays for reciept information
			$quantity = array();
			$name = array();
			$price = array();

			// add order_items to database
			$items = unserialize($_SESSION['cart']);
			foreach ($items as $item) {
				// set order_id, and add to database
				$item->order_id = $order_id;
				$this->order_item_model->insert($item);
				// get associated product
				$product = $this->product_model->get($item->product_id);
				// add data to arrays for reciepts
				$quantity[] = $item->quantity;
				$name[] = $product->name;
				$price[] = $product->price;
			}

			// empty/clear the cart 
/////////////////////////////////////////////////////////////////////unset($_SESSION['cart']);

			$data['quantity'] = $quantity;
			$data['name'] = $name;
			$data['price'] = $price;
			$data['order_id'] = $order_id;
			$data['total'] = $order->total;

			$data['main']='checkout/reciept.php';
			$this->load->view('template', $data);

		}
		else {
			redirect('candystore/payForm', 'refresh');
		}	
	}

}


