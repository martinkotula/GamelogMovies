<?php
	require_once 'movies_corner.php';
	class Restricted extends Movies_corner
	{
		function __construct()
		{
			parent::__construct();
		}
		
		function index()
		{
				$this->data['title'] = 'B³±d';
				$this->data['body_id'] = '';
				$this->data['view'] = 'error';
				$this->data['error_message'] = 'Brak dostêpu do strony';
				$this->load->view('main_view', $this->data);
			
		}
				
		
		
	}
	
?>
