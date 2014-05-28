<?php
	class Reviews_model extends CI_Model
	{		
		function get_review( $reviewID )
		{															
			$this->db->where('ReviewID',$reviewID);
			$query = $this->db->get('Reviews');
			
			if( $query->num_rows() == 0 )
				throw new key_not_found_exception("The review with id {$reviewID} doesn't exits'");
				
			return $query->row(); 
		}		
		
		function update( $reviewID,$movieID, $content, $rating)
		{						
			$this->db->where('ReviewID',$reviewID);
			$this->db->update('Reviews',array( 'MovieID'=>$movieID, 'Review'=>$content, 'Rating'=>$rating));					
		}
		
		function update_review_movie( $reviewID, $movieID)
		{						
			$this->db->where('ReviewID',$reviewID);
			$this->db->update('Reviews',array( 'MovieID'=>$movieID));					
		}
		
		function delete( $reviewID )
		{
			$this->db->where('ReviewID',$reviewID);
			$this->db->delete('Reviews');
		}
		
		function get_reviews($movieID, $how_many, $offset)
		{
			$sql = "SELECT r.Review, r.DatePosted, r.Rating, r.UserID, r.ReviewID, r.PostID, u.UserName, r.IsNewForum, NULL Permalink, NULL HomeLink FROM Reviews r"
										." JOIN GamelogUsers u ON u.UserID = r.UserID"
										." WHERE r.MovieID = ?"
										." ORDER BY r.DatePosted ASC"
										." LIMIT ?, ?";
			$query = $this->db->query($sql, array((int)$movieID, (int)$offset, (int)$how_many));

  			$data = array();
  			get_data($query, $data);
  			return $data;
		}
		
		function count_reviews($movieID)
		{
			$this->db->where('MovieID',$movieID);			
			return $this->db->count_all_results('Reviews');			
		}
		
		function get_bad_reviews()
		{
			$this->db->order_by('CommentDate');
			$query = $this->db->get('BadReviews');
			$data = array();
			get_data($query,$data);
			return $data;					
		}
		
		function delete_bad_review($id)
		{
			$this->db->where('id',$id);
			$this->db->delete('BadReviews');
		}
		
		function delete_bad_review_by_revID( $reviewID)
		{
			$this->db->where('ReviewID',$reviewID);
			$this->db->delete('BadReviews');
		}
				
		function get_recent($how_many,$offset=0)
		{
			$sql = "SELECT r.MovieID
					     , r.PostID
						 , r.DatePosted
						 , r.Rating
						 , r.Review
						 , rc.Code
						 , m.MovieTitle
						 , u.UserName FROM Reviews r" .
    				" JOIN Movies m ON m.MovieID = r.MovieID" .
					" JOIN ReviewCategories rc ON rc.ReviewCategoryId = r.ReviewCategoryId" .
    				" JOIN GamelogUsers u ON u.UserID = r.UserID" .
    				" ORDER BY r.DatePosted DESC, m.MovieTitle " .
    				" LIMIT ?,?";
    		$query = $this->db->query($sql, array((int)$offset,(int)$how_many));
    		
    		if( $query->num_fields() > 0 )
				foreach ( $query->result() as $r ) 
				{					
					if( strlen($r->MovieTitle) > 30 )
						$r->MovieTitle = substr_replace($r->MovieTitle ,'...',27);
				}
    		
    		$data = array();    		    		
  			get_data($query, $data);
  			return $data;
		}
		
		function count_all_reviews()
		{
			return $this->db->count_all('Reviews');
		}
		
		function add_bad_review($postID, $comment, $date)
		{
			$data = array('ReviewID'=>$postID, 'Comment'=>$comment, 'CommentDate'=>$date);
			$this->db->insert('BadReviews',$data);
		}
		
		function get_recent_feed($last_pub_date)
		{
			$sql = "select r.PostID
					     , r.MovieID
						 , r.Review
						 , r.DatePosted
						 ,r.Rating
						 , m.MovieTitle
						 , m.OriginalTitle
						 , u.UserName
					  from Reviews r
						 , Movies m
						 , GamelogUsers u 
					Where r.MovieId = m.MovieId 
					  and u.userID = r.userID 
					  and r.DatePosted > '" . $last_pub_date ."' 
					order by r.datePosted desc";
					
			$query = $this->db->query($sql);
    		    	
    		$data = array();    		    		
  			get_data($query, $data);
  			return $data;
		}
		
		function max_post_id()
		{
			$this->db->select_max('PostID');
			$query = $this->db->get('Reviews');
			
			return $query->row()->PostID;
		}
		
		function insert( $postID, $userID, $movieID, $reviewContent,$datePosted, $reviewRating, $isForumPost, $source)
		{
			
			$insert_data = array( 
									'postID'=>$postID
									,'UserID'=>$userID 
									,'MovieID'=>$movieID
									,'Review'=>$reviewContent
									,'DatePosted'=>$datePosted
									,'Rating'=>$reviewRating
									,'Is_Forum_Post'=>$isForumPost
									, 'Source' => $source
								);
			$this->db->insert('Reviews', $insert_data);

			return 1;
		}
	}
?>
