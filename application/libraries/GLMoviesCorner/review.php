<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Review
	{
		public function __construct( $postID, $userID, $review, $date_posted, $rating)
		{
			$this->set_postID($postID);
			$this->set_userID($userID);
			$this->set_review_content($review);
			$this->set_date_posted($date_posted);
			$this->set_rating($rating); 
		}

		
		public function get_postID() { return $this->postID; }
		public function get_userID() { return $this->userID; }
		public function get_review_content() { return $this->review_content; }
		public function get_date_posted() { return $this->date_posted; }
		public function get_rating() { return $this->rating; }
		
		public function set_postID( $value ) { $this->postID = (int)trim($value); }
		public function set_userID( $value ) { $this->userID = (int)trim($value); }
		public function set_review_content( $value ) 
		{ 
			$this->review_content = $value; 
			$this->strip_img_tags();
		}
		public function set_date_posted( $value ) { $this->date_posted = $value; }
		public function set_rating($value) { $this->rating = (int)trim($value); }
		 
		public function strip_img_tags()
		{
			$img_pattern =	'/<img.*?\/>/';
			$this->review_content = preg_replace($img_pattern, '',$this->review_content);
		}
		
		public function __toString()
		{
			return "<p>" . get_class($this) ." postID: {$this->postID} userID: {$this->userID} datePosted: {$this->date_posted} " .
					"rating: {$this->rating}<br/>Content: {$this->review_content}</p>";
		}
		
		private $postID;
		private $userID;
		private $review_content;
		private $date_posted;
		private $rating;
	}
	
?>
