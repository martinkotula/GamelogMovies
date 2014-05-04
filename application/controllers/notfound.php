<?php
	require_once 'movies_corner.php';
	class NotFound extends Movies_corner
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
				$this->data['error_message'] = 'Nie znaleziono zasobu';
				$this->load->view('main_view', $this->data);
			
		}
				
		
		
	}
	
?>
