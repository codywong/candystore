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
    			$this->load->view('login.php');
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
    			$this->load->view('login.php');
    			return;
    		}
    		$data['main']='product/newForm.php';
	    	$this->load->view('template', $data);
    }
    
    function newCustomer() {
    		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
			{
    			$this->load->view('login.php');
    			return;
    		}
    		$data['main']='customer/newCustomer.php';
	    	$this->load->view('template', $data);
    }

	function create() {
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			$this->load->view('login.php');
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
    			$this->load->view('login.php');
    			return;
    		}
		/*$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();*/
		
		if (true ) {
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
			$this->load->view('login.php');
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
			$this->load->view('login.php');
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
			$this->load->view('login.php');
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
			$this->load->view('login.php');
			return;
		}

		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');
	}

	function cart(){
		if (!isset($_SESSION['loggedInAs']) || $_SESSION['loggedInAs'] == "") 
		{
			$this->load->view('login.php');
			return;
		}
		$data['main']='checkout/viewCart.php';
		$this->load->view('template', $data);
	}

	function logout() {
		session_unset();
		session_destroy();
		$this->login();
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


			$this->load->model('customer_model');
			$authenticated = $this->customer_model->checkCredentials($customer);
			if ($customer->login == 'admin' && $customer->password == 'admin') {
				$_SESSION['loggedInAs'] = "admin";
				$this->index();
			}
			elseif ($authenticated->num_rows() > 0) {
				$_SESSION['loggedInAs'] = "customer";
				$this->index();
			} else {
				redirect('candystore/login', 'refresh');	
			}

			
		}
		else {
			$this->load->view('login.php');
		}	
	}
}

