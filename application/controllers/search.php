<?php
	require_once('movies_corner.php');
	class Search extends Movies_corner
	{
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('movies_model','movies');
			$this->load->helper('movies');
			$this->load->helper('data');			
		}
		
		function index()
		{
			$key_word = $this->input->post('search');
			
			if( !$key_word )
			{
				show_error('Must specify search phrase.');
				return;
			}
			
			$this->data['title'] = 'Search results';
			$this->data['results'] = $this->movies->search_movie($key_word);
			$this->data['view'] = 'results';
			$this->data['search_phrase'] = $key_word;
			$this->data['body_id'] = 'search_body';
			
			$this->load->view('main_view', $this->data);
		}
	}
?>
