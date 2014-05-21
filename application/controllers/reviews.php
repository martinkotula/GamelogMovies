<?php
	require_once 'movies_corner.php';
	class Reviews extends Movies_corner
	{		 		
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('movies_model');
			$this->load->model('reviews_model');
			
			$this->load->library('pagination');
									
			$this->load->helper('movies');
			
			$this->sort_fields = array( '1' => 'MovieTitle', '2'=>'AvgRating', '3'=>'TotalReviews');
			$this->categoryCodes = array( 'films' => 'Filmy', 'books' => 'Książki', 'games' => 'Gry');
		}
		
		function index($categoryCode, $sort='1', $order='ASC', $pageSize=30, $offset=0)
		{
			$params = array('sort'=>&$sort, 'order'=>&$order, 'number'=>&$pageSize);
			
			$this->_parse_post($params);
			
			
			$config['base_url'] = base_url() . "reviews/{$categoryCode}/{$sort}/{$order}/{$pageSize}";
			$config['per_page'] = $pageSize;
			$config['total_rows'] = $this->movies_model->count_movies($categoryCode);
			$config['uri_segment'] = 6;
			$this->pagination->initialize($config);
											
			$this->data['data'] = $this->movies_model->get_movies($categoryCode, $this->sort_fields["{$sort}"], $order, $pageSize, $offset);
			$this->data['links'] =  $this->pagination->create_links();
			$this->data['title'] = $this->categoryCodes["{$categoryCode}"];
			
			$this->data['view'] = 'reviews/index';
			$this->data['pageSize'] = $pageSize;
			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['body_id'] = 'reviews';
			$this->data['activeLink'] = $categoryCode;
			
			$this->load->view('main_view',$this->data);
		}				
		
		function details($movieID)
		{									
			$this->data['movie'] = $this->movies_model->get_movie($movieID);
			if( !$this->data['movie'] )
				redirect('notfound');
				
			$this->data['title'] = $this->data['movie']->MovieTitle; 
			$rating = $this->movies_model->get_movie_rating($movieID);
			$this->data['rating'] =( $rating == NULL )?  0:round($rating->AvgRating,2);
			$this->data['reviews'] = $this->reviews_model->get_reviews($movieID,$this->reviews_model->count_reviews($movieID),0);
						
			foreach($this->data['reviews'] as $r )
			{											
				$r->Permalink = base_url()."reviews/details/".$movieID."#".$r->PostID;
				
				if($r->IsNewForum == 0)
					$r->HomeLink = 'http://gamelog.pl/forum2/viewtopic.php?p='.$r->PostID;
				else
					$r->HomeLink = 'http://fsgk.pl/viewtopic.php?p='.$r->PostID;
			}
			
			$this->data['view'] = 'reviews/details';
			$this->data['body_id'] = 'movies_body';
			
			$this->load->view('main_view', $this->data);					
		}
		
		function top($categoryCode, $pageSize=30, $offset=0)
		{
			$param = array('number'=>&$pageSize);
			$this->_parse_post($param);
			
			$config['base_url'] = base_url()."reviews/top/{$categoryCode}/{$pageSize}";			
			$config['total_rows'] = $this->movies_model->count_top_rated($categoryCode);			
			$config['per_page'] = $pageSize;
			$config['uri_segment'] = 5;
			
			$this->pagination->initialize($config);
			
			$this->data['links'] = $this->pagination->create_links();
			$this->data['title'] = 'Najwyżej oceniane';
			$this->data['titles'] = $this->movies_model->get_top_rated($categoryCode, $pageSize, $offset);
			$this->data['pageSize'] = $pageSize;
			$this->data['view'] = 'reviews/top';			
			$this->data['body_id'] = 'top';
			$this->data['activeLink'] = 'top';
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
	}
?>
