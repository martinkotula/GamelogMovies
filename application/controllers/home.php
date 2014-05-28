<?php
	require_once 'movies_corner.php';
	class Home extends Movies_corner
	{
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('reviews_model');
			
			$this->load->library('pagination');
			
			$this->load->helper('url');
			$this->data['activeLink'] = 'home';
		}
		function index($offset=0)
		{
			$baseUrl = base_url().'home/index';			
			$this->data['view'] = 'home/home';
			
			$this->display($offset, $baseUrl, 9);
		}
		
		function display($offset=0, $baseUrl, $perPage)
		{
			$config['base_url'] = $baseUrl;
			$config['per_page'] = $perPage;
			$config['total_rows'] = $this->reviews_model->count_all_reviews();
			
			$this->pagination->initialize($config);
			
			$this->data['title'] = 'Gamelog movies corner';			
			$this->data['recent_reviews'] = $this->reviews_model->get_recent($perPage,$offset);
			$this->data['links'] = $this->pagination->create_links();
			$this->data['body_id'] = 'home_body';
			
			$this->load->view('main_view', $this->data);
		}
		
		function listRecent($offset=0)
		{
			$baseUrl = base_url().'home/list';			
			$this->data['view'] = 'home/list';
			
			$this->display($offset, $baseUrl, 15);
		}

	}
?>
