<?php
	
	require_once('application/libraries/GLParser/feedParser.php');
	
	class ReviewsSync extends CI_Controller
	{	

		public function __construct()
		{
			parent::__construct();						
			$this->load->model('gl_repository','db_manager');
		}
		
		public function index($key)
		{			
			if($key != $this->config->item('review_sync_key'))
				redirect('home');
			
			$parser = new FeedParser();
			$reviews = $parser->ParseReviewFeeds();
			
			if(!isset($reviews))
				return;

			$filmReviewsInserted =0; $gameReviewsInserted = 0; $bookReviewsInserted = 0;
			
			if( isset($reviews['FILMS']) && count($reviews['FILMS']) > 0){
				$filmCategoryId = $this->db_manager->getReviewCategory('FILMS');
				$filmReviewsInserted = $this->_insertReviews($filmCategoryId, $reviews['FILMS']); 
			}
			
			if( isset($reviews['GAMES']) && count($reviews['GAMES']) > 0){
				$gameCategoryId = $this->db_manager->getReviewCategory('GAMES');
				$gameReviewsInserted = $this->_insertReviews($gameCategoryId, $reviews['GAMES']); 
			}
			
			if( isset($reviews['BOOKS']) && count($reviews['BOOKS']) > 0){
				$booksCategoryId = $this->db_manager->getReviewCategory('BOOKS');
				$bookReviewsInserted = $this->_insertReviews($booksCategoryId, $reviews['BOOKS']); 
			}
			
			echo "{ filmReviews = ". $filmReviewsInserted ."; gameReviews =".$gameReviewsInserted."; bookReviews= ".$bookReviewsInserted."}";
		}
		
		function _insertReviews($reviewCategoryId, $reviews){			
			
			$reviewExists = array();
			foreach( $reviews as $r)
			{
				$reviewExists[$r['postId']] = $this->db_manager->reviewExists($r['postId']);
			}
			
			$i = 0;
			foreach( $reviews as $r)
			{		
				$r['reviewId'] = NULL;				
				if($reviewExists[$r['postId']] != NULL)
					continue;
				
				$titleId = $this->db_manager->tryToGetTitleId($reviewCategoryId, $r['title']);
				if(!isset($titleId)){
					$titleId = $this->db_manager->insertMovie($reviewCategoryId, $r['title'], $r['original_title']);
					$titleId = $this->db_manager->tryToGetTitleId($reviewCategoryId, $r['title']);
				}
				
				$userId = $this->db_manager->tryToGetUserId($r['author']);
				if(!isset($userId)){
					$userId = $this->db_manager->insertUser( $r['gamelogId'], $r['author']);
					$userId = $this->db_manager->tryToGetUserId($r['author']);
				}
				
				if(isset($titleId) && isset($userId)){					
					$this->db_manager->upsertReview($reviewCategoryId, $titleId, $userId, $r);
					$i++;
				}
				else{
					echo 'Nie udało się dodać recenzji:'.var_dump($r);
				}
				
			}
			
			return $i;
		}
	
	}	
	
?>
