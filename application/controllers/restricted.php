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
				$this->data['title'] = 'B��d';
				$this->data['body_id'] = '';
				$this->data['view'] = 'error';
				$this->data['error_message'] = 'Brak dost�pu do strony';
				$this->load->view('main_view', $this->data);
			
		}
				
		
		
	}
	
?>
