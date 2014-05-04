<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Movie
	{			
		public function __construct( $title, $original_title)
		{
			$this->set_movie_title($title);
			$this->set_original_title($original_title);
		}
		
		public function get_movie_title() { return $this->movie_title; }
		public function set_movie_title($value) { $this->movie_title = trim($value); }
		
		public function get_original_title() { return $this->original_title; }
		public function set_original_title($value) { $this->original_title = trim($value); }
		
		public function __toString()
		{
			return "<p>" . get_class($this) ." Title: {$this->movie_title} Original title: {$this->original_title} </p>";
		}
		
		private $movie_title;
		private $original_title; 
	}
	
?>
