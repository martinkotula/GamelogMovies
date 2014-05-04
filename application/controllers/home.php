<?php
	require_once 'movies_corner.php';
	class Home extends Movies_corner
	{
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('users_model');
			$this->load->model('movies_model');
			$this->load->model('reviews_model');
			
			$this->load->library('pagination');
			
			$this->load->helper('url');
		}
		function index()
		{
			$this->display();
		}
		
		function display($offset=0)
		{
			$this->session->set_flashdata('redirectToCurrent',current_url());
			$config['base_url'] = base_url().'home/display';
			$config['per_page'] = 15;
			$config['total_rows'] = $this->reviews_model->count_all_reviews();
			
			$this->pagination->initialize($config);
			
			$this->data['view'] = 'home/home';
			$this->data['title'] = 'Gamelog movies corner';
			$this->data['active_users'] = $this->load->view('home/active_users',array('most_active_users' => $this->users_model->get_users('ReviewsCount','DESC',3,0)), TRUE);
			$this->data['top_rated_films'] = $this->load->view('home/top_rated', array('top_rated_films' => $this->movies_model->get_top_rated(10)),TRUE);
			$this->data['recent_reviews'] = $this->load->view('home/recent_reviews', array('recent_reviews' => $this->reviews_model->get_recent(15,$offset), 'links'=>$this->pagination->create_links()),TRUE);
			$this->data['reviews_count'] = $this->reviews_model->count_all_reviews();
			$this->data['movies_count'] = $this->movies_model->count_movies();
			$this->data['body_id'] = 'home_body';
			
			$this->load->view('main_view', $this->data);
		}
	}
?>
