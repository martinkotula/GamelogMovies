<?php
require_once('movies_corner.php');
	class Edit extends Movies_corner
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('movies_model','movies');
			$this->load->model('reviews_model','reviews');
			
			$this->load->helper('form');			
			$this->data['body_id'] = '';	
			$this->data['movieID'] = '';
			if( !$this->_is_logged_in() )
			{
				$this->session->set_flashdata('redirectToCurrent', current_url());
				redirect('login');
			}
			
			$this->session->keep_flashdata('redirectToCurrent');
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_message('required', 'Pole %s jest wymagane!');
			
			
			
		}
		public function index()
		{
			$user_id = $this->session->userdata('user_id');
						
			
			if( !$user_id )
				redirect('restricted');
			else
			{
				$this->data['view'] = 'new_review';
				$movies = $this->movies->get_movies_titles();
				$user = $this->users->get_user_nick($user_id);
				
				$this->data['title'] = 'Nowa recenzja';
				$this->data['movies'] = $movies;
				$this->data['user'] = $user;				
				$this->load->view('main_view', $this->data);
			}
		}
		
		public function review($reviewID)
		{
		try
		{
			$review = $this->reviews->get_review($reviewID);
			$user_id = $this->session->userdata('user_id');
			if( $review->UserID != $user_id && !$this->users->is_moderator($user_id))
				redirect('restricted');
			else
			{
				$this->data['view'] = 'edit_review';
				$movie_title = $this->movies->get_movie($review->MovieID);
				$movies = $this->movies->get_movies_titles();
				$user = $this->users->get_user_nick($review->UserID);
				
				$this->data['title'] = 'Editing review: '.$reviewID;
				if( !$this->data['movieID'] )				
					$this->data['movieID']=$review->MovieID;
				
				$this->data['review'] = $review;			
				$this->data['movies'] = $movies;
				$this->data['user'] = $user;
				$this->data['movie_title'] = $movie_title;	
				$this->load->view('main_view', $this->data);
			}
		}
		catch(Exception $e)
		{
			redirect('notfound');
		}
		}
		
		
		
		public function insert_title( $reviewID=0 )
		{	
			$this->form_validation->set_rules('movie_title', 'tytu³', 'trim|required');
			$movie_title = substr(strip_tags(trim($this->input->post('movie_title'))),0,100);
			$original_title = $this->input->post('original_title') ? substr(strip_tags(trim($this->input->post('original_title'))),0,100) : NULL;
			$result = FALSE;
			
			if ($this->form_validation->run() == FALSE)
			{
				if( $reviewID > 0 )
					$this->review($reviewID);
				else
					$this->index();
			}
			else
			{	
				$movieID = $this->movies->get_movie_id($movie_title);
				if( !$movieID )
				{
					$this->movies->insert($movie_title
										, $original_title
										);										
					$result = TRUE;
					$movieID = $this->movies->get_movie_id($movie_title);
				}					
				else					
					$this->session->set_flashdata('error','<p>Tytu³ ju¿ istnieje!</p>');					
				
				$this->data['movieID'] = $movieID;
			}
			
			return $result;
		}
		
		public function new_title_edit($reviewID)
		{			
			$this->insert_title($reviewID);
			$this->review($reviewID);
		}
		
		public function new_title_insert()
		{
			$this->insert_title();
			$this->index();
		}
		
		public function delete_bad_review($review_id)
		{
			$this->reviews->delete_bad_review($review_id);
			redirect(htmlspecialchars($_SERVER['HTTP_REFERER']));
		}
		
		public function delete($review_id)
		{
			
			$review = $this->reviews->get_review($review_id);
			$user_id = $this->session->userdata('user_id');
			
			if( $review->UserID != $user_id && !$this->users->is_moderator($user_id))
				redirect('restricted');
			else
			{				
				
					$this->reviews->delete($review_id);					
					redirect($this->session->flashdata('redirectToCurrent'));
				
			}
		}
		
		public function update()
		{
			
			$reviewID = $this->input->post('reviewID');
			$review = $this->reviews->get_review($reviewID);
			$user_id = $this->session->userdata('user_id');

			if( $review->UserID != $user_id && !$this->users->is_moderator($user_id))
				redirect('restricted');
			else
			{						
				
					$this->form_validation->set_rules('review_content', 'tre¶æ', 'trim|required');
					if ($this->form_validation->run() == FALSE)
					{
						$this->review($reviewID);
					}
					else
					{
						$movieID = $this->input->post('titles');
						$this->reviews->update(
										  $reviewID		
										, $movieID
										, str_replace("\n",'<br />',strip_tags($this->input->post('review_content')))
										, $this->input->post('rating')
										);
						$this->reviews->delete_bad_review_by_revID($this->input->post('reviewID'));
						
						redirect(base_url().'movies/details/'.$movieID);					
					}					
				
			}
		}
		
		public function update_movie($reviewID)
		{			
			$this->reviews->update_review_movie(
				$reviewID
				, $this->input->post('titles'));
			
			redirect(htmlspecialchars($_SERVER['HTTP_REFERER']));
		}

		function insert()
		{
			$user_id = $this->session->userdata('user_id');
			
			if( !$user_id)
				redirect('restricted');
			else
			{
				$this->form_validation->set_rules('review_content', 'tre¶æ', 'trim|required');
				if ($this->form_validation->run() == FALSE)				
					$this->index();				
				else
				{
					$max_post_id = $this->reviews->max_post_id();
					$this->reviews->insert(
						$max_post_id+1
					   ,$user_id
					   ,$this->input->post('movieID')
					   ,str_replace("\n",'<br />',strip_tags($this->input->post('review_content')))
					   , date('Y-m-d H:i:s')
					   ,$this->input->post('rating')
					   ,'N'
					);
					redirect($this->session->flashdata('redirectToCurrent'));					
				}
			}
		}
		
	}
	
?>
