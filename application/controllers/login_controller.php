<?php
class CandyStore extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
    }


    function index() {
    		$this->load->view('login');
    }

?>