<?php
	require_once('movies_corner.php');

	
	class Moderator extends Movies_corner
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->_authorize_user();
						
			$this->load->model('movies_model','movies');
			$this->load->model('reviews_model','reviews');
			$this->load->model('gl_model','db_manager');
			
			$this->data['body_id'] = 'moderator_body';
			
			$syncKey = $this->config->item('review_sync_key');
			$this->data['secondary'] = array(  'Bad Reviews' => 'moderator/bad_reviews', 'Reviews'=>'moderator/reviews', 'Update'=>'reviewssync/index/'.$syncKey);
			$this->counter = 0;	

		}
		
		public function index()
		{	
			redirect('moderator/bad_reviews');			
		}
		
		public function bad_reviews()
		{
			$this->data['bad_reviews'] = $this->reviews->get_bad_reviews();
			$this->data['title'] = 'Bad Reviews';
			$this->data['view'] = 'restricted/bad_reviews';	
			
			$this->load->view('main_view',$this->data);
		}
		
		function clear()
		{
			$this->data['title'] = 'Update';			
			
			$this->data['view'] = 'restricted/update_results';
			
			$this->load->model('movies_model');
			$empty_records = $this->movies_model->movies_with_no_reviews();
						
			foreach($empty_records as $empty)
				$this->movies_model->delete($empty->MovieID);
				
			$this->data['result'] = "<p>Znaleziono ". count($empty_records)." pustych tytu³ów</p>";
			$this->load->view('main_view',$this->data);
		}
		
	}
	
?>
