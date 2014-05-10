<?php
	class FeedParser{
	
		private function stripQuotes($input)
		{
			$quote_pattern = "{(?si)<div class=\"quotecontent\">.*?<\/div>}";
			return preg_replace($quote_pattern,'',$input);
		}
		
		private function parseTitles($title)
		{
			$original_title_pattern = "{(?si)\((?P<original1>.*?)\)|\/(?P<original2>.*)}";

			$original_title = array();
			$org ='';
			if( preg_match_all($original_title_pattern,$title,$original_title) > 0)
			{								
				$org = ($original_title['original2'][0] !== "" )? $original_title['original2'][0]:$original_title['original1'][0];								 						
				//Remove eventual original title from the parsed title
				$title=preg_replace($original_title_pattern,'',$title);								
			}
			
			$titles = array();
			$titles['title'] = $title;
			$titles['original_title'] = trim($org);
			
			return $titles;
		}
		
		private function parsePostId($id)
		{
			$postId_pattern = "{(?si)#p(?P<postId>\d+)}";
			$postId = array();
			preg_match($postId_pattern, $id, $postId);
			
			return $postId['postId'];
		}
		
		private function parseUserId($content)
		{
			$userId_pattern = "{(?si)viewprofile&amp;u=(?P<gamelogId>\d+)}";
			$gamelogId = array();
			preg_match($userId_pattern, $content, $gamelogId );
			
			return $gamelogId['gamelogId'];
		}
		
		private function parseDate($date){
			$date = preg_replace("{(?si)\+\d+:\d+}",'',$date);
			$date = str_replace('T',' ',$date);
			
			
			return DateTime::createFromFormat('Y-m-d H:i:s',$date);
		}
		
		private function parseReviews($forumId, $topicId)
		{
			//result
			$reviews = array();
			
			$feedUrl = 'http://www.fsgk.pl/feed.php?f='.$forumId .'&t='.$topicId;
			$feed = file_get_contents($feedUrl);
			$posts = new SimpleXMLElement($feed, LIBXML_NOCDATA);
			
			$review_pattern =  "{(?si)<strong>(?P<title>.*?)<\/strong>(?P<review>.*?)<strong>\s*(?P<rating>\d+).*?/\d+\s*<\/strong>}";
					
			//Iterate over topic entries
			for($i = 0; $i < count($posts->entry); $i++)
			{
				$entry = $posts->entry[$i];
				$review_matches = array();
				
				//Remove quotes - if someone quoted whole review signature it would duplicate the review but with quoter as the author			
				$postBody = $this->stripQuotes($entry->content);
				preg_match_all($review_pattern,$postBody,$review_matches);
				
				//foreach review match
				for( $k=0; $k < count($review_matches[0]); $k++)
				{
					$review = array();
					$review['author'] = (string)$entry->author->name;
					$review['gamelogId'] = $this->parseUserId($entry->content);
					$review['published'] = $this->parseDate($entry->published);
					
					$titles = $this->parseTitles(trim($review_matches['title'][$k]));
					
					$review['title'] = strip_tags($titles['title']);
					$review['original_title'] = strip_tags($titles['original_title']);
					$review['content'] = strip_tags($review_matches['review'][$k]);
					$review['rating'] = $review_matches['rating'][$k];
					$review['postId'] = $this->parsePostId($entry->id);
					$review['id'] = (string)$entry->id;
					
					array_push($reviews,$review);
				}		
			}
			
			return $reviews;
		}
		
		public function ParseReviewFeeds(){
			$reviews = array();
	
			$reviews['FILMS'] = $this->parseReviews(9,4);
			$reviews['GAMES'] = $this->parseReviews(4,2);
			//$reviews['BOOKS'] = $this->parseReviews(8,4);
						
			
			return $reviews;
		}

	}
?>