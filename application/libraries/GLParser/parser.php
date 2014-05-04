<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');		
	require_once('application/libraries/GLMoviesCorner/gamelogUser.php');
	require_once('application/libraries/GLMoviesCorner/movie.php');
	require_once('application/libraries/GLMoviesCorner/review.php');
	require_once('endOfDataException.php');
	
	class Parser
	{			
		function get_parsed_users() { return $this->parsed_users; }
		function get_parsed_movies() { return $this->parsed_movies; }
		function get_parsed_reviews() { return $this->parsed_reviews; }
		
		function parse_page($input, $lastPostID)
		{
				$this->resetArrays();
				$bodies_matches = array();
				preg_match_all($this->post_body,$input,$bodies_matches);
				for( $i = count($bodies_matches[0])-1; $i >=0 ; $i-- )
				{
					$post_matches = array();
					preg_match_all($this->post_content, $bodies_matches[0][$i], $post_matches);
					for( $j = 0; $j < count($post_matches[0]); $j++ )
					{
						if( $post_matches['postID'][$j] <= $lastPostID )
							throw new EndOfDataException('No more data to read');
						$post_matches['postBody'][$j] = $this->strip_quotes($post_matches['postBody'][$j]);
						$review_matches = array();
						preg_match_all($this->review_pattern, $post_matches['postBody'][$j], $review_matches);
						for( $k=0; $k < count($review_matches[0]); $k++)
						{
							if( !array_key_exists($bodies_matches['gamelogID'][$i],$this->parsed_users))
								$this->parsed_users[$bodies_matches['gamelogID'][$i]] = new GamelogUser($bodies_matches['gamelogID'][$i],$bodies_matches['nick'][$i]);
							$title = trim($review_matches['title'][$k]);
							$original_title = array();
							$org ='';
							if( preg_match_all($this->original_title,$title,$original_title) > 0)
							{								
								$org = ($original_title['original2'][0] !== "" )? $original_title['original2'][0]:$original_title['original1'][0];								 						
								$title=preg_replace($this->original_title,'',$title);								
							}
							if( !array_key_exists(strtoupper($title),$this->parsed_movies))
								$this->parsed_movies[strtoupper($title)] = new Movie($title, $org);
							$this->parsed_reviews[] = array($title, new Review($post_matches['postID'][$j],$bodies_matches['gamelogID'][$i],$review_matches['review'][$k],$post_matches['datePosted'][$j],$review_matches['rating'][$k] ));
						}						
					}
				}
		
		}
		
		public function get_last_page_nr($input)
		{
			$pattern = "{start=(?P<nr>\d+)}";
			$matches = array();
			preg_match_all($pattern, $input, $matches);			
			rsort($matches['nr']);			
			return $matches['nr'][0];
		}
		
		private $parsed_users;
		private $parsed_movies;
		private $parsed_reviews;
		
		private function resetArrays()
		{
			$this->parsed_users = array();
			$this->parsed_movies = array();
			$this->parsed_reviews = array();
		}
		
		private function strip_quotes($input)
		{
			return preg_replace($this->quote_pattern,'',$input);
		}
		
		
		private $original_title = "{(?si)\((?P<original1>.*?)\)|\/(?P<original2>.*)}";
		private $quote_pattern = "{(?si)<td class=\"quote\">.*?<\/td>}";
		private $post_body = '{(?si)\[b\](?P<nick>.*?)\[\/b\].*?viewprofile&amp;u=(?P<gamelogID>\d+)}';
		private $post_content = "{(?si)viewtopic.php\?p=(?P<postID>\d+).*?(?P<datePosted>[0-9]+\/[0-9]+\/[0-9]{4}\s*[0-9]+:[0-9]+).*?class=\"postbody\".*?<hr \/>(?P<postBody>.*)}";
		private $review_pattern =  "{(?si)<span style=\"font-weight: bold\">(?P<title>.*?)<\/span>(?P<review>.*?)<span style=\"font-weight: bold\">\s*(?P<rating>\d+).*?/\d+\s*<\/span>}";
	}	
?>
