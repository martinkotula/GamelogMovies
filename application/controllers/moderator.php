<?php
	require_once('movies_corner.php');
	require_once('application/libraries/GLParser/parser.php');
	
	class Moderator extends Movies_corner
	{
		private $topic_url = "http://www.gamelog.pl/forum2/viewtopic.php?t=47";
		private $posts_per_page = 50;
		private $counter;
		
		public function __construct()
		{
			parent::__construct();
			
			$this->_authorize_user();
						
			$this->load->model('movies_model','movies');
			$this->load->model('reviews_model','reviews');
			$this->load->model('gl_model','db_manager');
			
			$this->data['body_id'] = 'moderator_body';
			$this->data['secondary'] = array(  'Bad Reviews' => 'moderator/bad_reviews', 'Reviews'=>'moderator/reviews', 'Update'=>'moderator/update');
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
		
		public function update()
		{			
			try
			{
			$this->data['title'] = 'Update';
			
			$this->data['view'] = 'restricted/update';
			if( $this->input->post('Update') == 'RegularUpdate')
				$this->_regular_update();
			else if( $this->input->post('Update') == 'TargetUrl')
				$this->_parse_page();
				
			$this->load->view('main_view',$this->data);		
			}
			Catch(Exception $e)
			{
			 var_dump($e);
			}
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
		
		function do_upload()
		{
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'txt';
			$config['max_size']	= '2048';
			$config['overwrite'] = true;	
			$this->data['title'] = 'Upload';
			$this->load->library('upload', $config);
			$this->load->helper('file');
			if ( ! $this->upload->do_upload())
			{
				$this->data['error'] = $this->upload->display_errors();
				$this->data['view'] = 'restricted/update';				
			}	
			else
			{
				$this->_upload_successful();
			}
			delete_files('./uploads');
			$this->load->view('main_view', $this->data);
		}	
		
		public function import()
		{
			$this->data['title'] = 'Import recenzji';
			
			$this->data['view'] = 'restricted/update';
			
			$this->_regular_update2();
			
			$this->load->view('main_view',$this->data);		
		}
		
		function _upload_successful()	
		{
				require_once('application/libraries/GLMoviesCorner/review.php');
				require_once('application/libraries/GLMoviesCorner/movie.php');
				$this->load->model('users_model','users');
				
				$upload_data = $this->upload->data();
				$this->data['view'] = 'restricted/upload_success';
				$userID = -1;
				try
				{
					$userID = $this->users->get_user_id($upload_data['raw_name']);
				}
				catch(Key_not_found_exception $e)
				{
					$this->data['error'] = $e->getMessage();
					$this->data['view'] = 'restricted/update';
					
					return;
				}
								
				
				$file = read_file($upload_data['full_path']);
				$file = trim($file);				
				$rows = preg_split('{#}',$file);
				$this->data['reviews'] = array();
				$movies = array();
				$reviews = array();			 
				foreach( $rows as $item => $value)
				{
					$this->_parse_review($userID, $value, $movies, $reviews);		
				}				
				$this->_update_data($movies, array(), $reviews);
				$this->data['parsed_reviews_count'] = $this->counter;
				$this->data['reviews'] = $reviews;
				$this->data['movies'] = $movies;
								
				
		}
		
		function _parse_review($id,$source,&$movies, &$reviews)
		{
			if( $source == "")
				return;
			$review = preg_split('{\|}',$source);
			if( count($review) == 5 ) 					
			{						
				$original_title = array();
				$org ='';
				$original_title_reg = "{(?si)\((?P<original>.*?)\)}";
				$review[0] = trim($review[0]);			
				if( preg_match_all($original_title_reg,$review[0],$original_title) > 0)
				{					
					$org = $original_title['original'][0];								 						
					$review[0]=preg_replace($original_title_reg,'',$review[0]);
				}
				$movies[] = new Movie($review[0],$org);					
				$reviews[] = array($review[0] , new Review($review[1],$id,$review[4],$review[2],$review[3]));
			}
			else
			{
				if( isset($this->data['error']))
					$this->data['error'] += "Failed to parse entry: {$review} <br />";
				else
					$this->data['error'] = "Failed to parse entry: {$review} <br />";
			}		
		}	
		function _parse_page()
		{
			$this->counter = 0;											
			$this->parser = new Parser();	
			$this->_parse_addr($this->input->post('target_url'),0);										
			$this->_update_data($this->parser->get_parsed_movies(), $this->parser->get_parsed_users(), $this->parser->get_parsed_reviews());			
			$this->data['result'] = "<p>Wczytano : {$this->counter} recenzji</p>";
			$this->data['view'] = 'restricted/update_results';
		}
		function _regular_update2()
		{
			$this->load->helper('file');
			$this->counter = 0;											
			$this->parser = new Parser();
			$this->finish = FALSE;
			$lastPost = $this->db_manager->get_last_post_ID();
			$this->_read_page($lastPost);	
			$this->_update_data($this->parser->get_parsed_movies(), $this->parser->get_parsed_users(), $this->parser->get_parsed_reviews());				
				
			$this->data['result'] = "<p>Wczytano : {$this->counter} recenzji</p>";
			$this->data['view'] = 'restricted/update_results';			
		}
		
		function _regular_update()
		{
			
			$this->counter = 0;											
			$this->parser = new Parser();
			$this->finish = FALSE;
			$lastPost = $this->db_manager->get_last_post_ID();
			$lastPage = $this->parser->get_last_page_nr($this->_get_page($this->topic_url));			
			$page = $lastPage;
			$i = 0;
			while( $page > 0 && !$this->finish)
			{
				$this->_parse_addr($this->_get_addr($page),$lastPost);
				$page = $lastPage - $i * $this->posts_per_page;
				$i++;
				$this->_update_data($this->parser->get_parsed_movies(), $this->parser->get_parsed_users(), $this->parser->get_parsed_reviews());				
			}			
			$this->data['result'] = "<p>Wczytano : {$this->counter} recenzji</p>";
			$this->data['view'] = 'restricted/update_results';			
		}
		
		function _update_data($movies, $users, &$reviews)
		{
			foreach ( $movies as $m )
			{				
				if( !$this->db_manager->contains_movie($m->get_movie_title()))
					$this->db_manager->insert_movie($m);
			}				       
			foreach ( $users as $m )			
			{
				if( !$this->db_manager->contains_user($m->get_gamelogID()))
					$this->db_manager->insert_user($m);					
			}
			foreach ($reviews as $r )
			{
				try
				{
				$ret = $this->db_manager->insert_review($r[0],$r[1]);		
				}
				catch(Exception $e)
				{					
					echo $e->getMessage();	
				}
				$this->counter += $ret;
				$r['updated'] = $ret == 1 ? true : false;				
			}			
			
			$this->db_manager->set_last_update_date(date('Y-m-d'));
		}
		function _read_page($last_post)
		{			
			try
			{
			$content = read_file('./uploads/page');
			$this->parser->parse_page($content,$last_post);
			}
			catch( endOfDataException $e)
			{
				$this->finish = TRUE;	
			}
		}
		function _get_page( $url )
		{
		
//			 create curl resource 
        		$ch = curl_init(); 

  //      	 set url 
        	curl_setopt($ch, CURLOPT_URL, $url); 

	//        return the transfer as a string 
    	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        	// $output contains the output string 
        	$content = curl_exec($ch); 
	        // close curl resource to free up system resources 
    	    curl_close($ch);
    	
	
			
			
    	    return $content;
		}
		function _parse_addr($url, $last_post)
		{			
			try
			{
			     
			$content = $this->_get_page($url);				
			$this->parser->parse_page($content,$last_post);
			}
			catch( endOfDataException $e)
			{
				$this->finish = TRUE;	
			}
		}
		
		function _get_addr($page)
		{
			return $this->topic_url . "&start={$page}";
		}		
		
		private $parser;
		private $finish;
		

		
		
		
	}
	
?>
