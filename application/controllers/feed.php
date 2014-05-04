<?php
	require_once('movies_corner.php');
	
	class Feed extends Movies_corner
	{
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('gl_model','db_manager');
			if( !$this->_is_logged_in())
				redirect('login');
		
		}
		
		function rss()
		{			
			 $this->load->model('reviews_model', 'reviews');
			 $this->load->model('gl_model');
			 $this->load->helper('file');
			 
			 $last_pub_date = $this->gl_model->get_last_pub_date();
			 
			 $data['reviews'] = $this->reviews->get_recent_feed($last_pub_date);
			 $data['last_pub_date'] = date(DATE_RFC822);
			 
			 $this->gl_model->set_last_pub_date(date('Y-m-d H:i:s'));
			 
			 header('Content-type: text/xml');  
			 $feed = $this->load->view('rss', $data, true);
			 write_file('./feeds/rss.xml', $feed);
			 
			 redirect('home');
			 
		}
		
	}
?>
