<?php
	require_once 'movies_corner.php';
	class Movies extends Movies_corner
	{		 		
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('movies_model');
			$this->load->model('reviews_model');
			$this->load->library('form_validation');
			$this->load->library('pagination');
									
			$this->load->helper('movies');
			$this->data['secondary'] = array('Wszystkie'=>'movies', 'Najwy¿ej oceniane'=>'movies/top_rated');
			$this->sort_fields = array( '1' => 'MovieTitle', '2'=>'AvgRating', '3'=>'TotalReviews');
			$this->data['canEdit'] = FALSE;
		}
		function index()
		{
			$this->display();
		}
				
		
		function display($sort='1', $order='ASC', $how_many=30, $offset=0)
		{
			$params = array('sort'=>&$sort, 'order'=>&$order, 'number'=>&$how_many);
			$this->_parse_post($params);			

			$config['base_url'] = base_url() . "movies/display/{$sort}/{$order}/{$how_many}";
			$config['per_page'] = $how_many;
			$config['total_rows'] = $this->movies_model->count_movies();
			$config['uri_segment'] = 6;
			
			$this->pagination->initialize($config);	
											
			$this->data['data'] = $this->movies_model->get_movies($this->sort_fields["{$sort}"],$order,$how_many,$offset);
			$this->data['links'] =  $this->pagination->create_links();
			$this->data['title'] = 'Movies';
			$this->data['view'] = 'movies/display';
			$this->data['how_many'] = $how_many;
			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['body_id'] = 'movies_body';
			
			$this->load->view('main_view',$this->data);
		}
		
		function details($movieID)
		{			
			$this->session->set_flashdata('redirectToCurrent',current_url());
			
			$this->data['movie'] = $this->movies_model->get_movie($movieID);
			if( !$this->data['movie'] )
				redirect('notfound');
				
			$this->data['title'] = $this->data['movie']->MovieTitle; 
			$rating = $this->movies_model->get_movie_rating($movieID);
			$this->data['rating'] =( $rating == NULL )?  0:$rating->AvgRating;
			$this->data['reviews'] = $this->reviews_model->get_reviews($movieID,$this->reviews_model->count_reviews($movieID),0);
			
			$user_id = $this->session->userdata('user_id');
			$is_moderator = FALSE;

			if( $user_id )
			{
				$is_moderator = $this->users->is_moderator($user_id);
				$this->data['canEdit'] = TRUE;
			}
			foreach($this->data['reviews'] as $r )
			{
				if( $r->UserID == $user_id || $is_moderator )
					$r->CanEdit = TRUE;
				
				$r->Permalink = base_url()."movies/details/".$movieID."#".$r->PostID;
			}
			
			$this->data['view'] = 'movies/details';
			$this->data['body_id'] = 'movies_body';
			
			$this->load->view('main_view', $this->data);					
		}
		
		function top_rated($how_many=30, $offset=0)
		{
			$param = array('number'=>&$how_many);
			$this->_parse_post($param);
			$config['base_url'] = base_url()."movies/top_rated/{$how_many}";			
			$config['total_rows'] = $this->movies_model->count_top_rated();			
			$config['per_page'] = $how_many;
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config);
			
			$this->data['links'] = $this->pagination->create_links();
			$this->data['title'] = 'Najwy¿ej oceniane';
			$this->data['movies'] = $this->movies_model->get_top_rated($how_many, $offset);
			$this->data['how_many'] = $how_many;
			$this->data['view'] = 'movies/top_rated';
			
			$this->data['body_id'] = 'movies_body';
			$this->load->view('main_view',$this->data);
		}
		
		
		function error_submit()
		{			
			$reviewID= $this->input->post('error_post');
			$comment = $this->input->post('comment');
			$date = date('Y/n/j H:i:s');
			$this->reviews_model->add_bad_review($reviewID, $comment, $date);
			
			$this->data['title'] = 'Error submit';
			$this->data['view'] = 'error_submit';
			$this->data['body_id'] = 'error_submit_body';
			
			$this->load->view('main_view',$this->data);
		}
		
		function update_title()
		{				
			$movieID = $this->input->post('movieID');
			$this->form_validation->set_rules('movie_title', 'tytu³', 'trim|required');
			$this->load->model('gl_model','gl');
			
			if ($this->form_validation->run() == FALSE)			
					$this->details($movieID);			
			else
			{	
				$movie = $this->movies_model->get_movie($movieID);
				$p_movie_title = substr(strip_tags(trim($this->input->post('movie_title'))),0,100);
				$p_original_title = $this->input->post('original_title') ? substr(strip_tags(trim($this->input->post('original_title'))),0,100) : NULL;
				
				if( $p_movie_title != $movie->MovieTitle && $this->gl->contains_movie($p_movie_title))
					$this->session->set_flashdata('error','<p>Taki tytu³ ju¿ istnieje!</p>');
				else	
				{			
					$this->movies_model->update($movieID
									, $p_movie_title
									, $p_original_title
									);													
				}
				

				$this->details($movieID);
			}
		}
	}
?>
