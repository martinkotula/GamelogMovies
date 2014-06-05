<?php

	class Gl_repository extends CI_Model
	{
	
		function getReviewCategory($categoryCode)
		{
			$this->db->where("Code", "$categoryCode");
			$query = $this->db->get('ReviewCategories');
			

			return $query->row()->ReviewCategoryId;
		}
		
		function getLastReviewDateForCategory($categoryId)
		{
			$this->db->select_max("DatePosted", "LastPostDate");
			$this->db->where("ReviewCategoryId", "$categoryId");
			$this->db->where("IsNewForum", "1");
			$query = $this->db->get('Reviews');
			
			$row = $query->row();
			if( isset($row)){			
				return DateTime::createFromFormat('Y-m-d H:i:s', $row->LastPostDate);
			}
			return null; 
		}
		
		function tryToGetTitleId($categoryId, $title)
		{
			$this->db->where('MovieTitle',$title);
			$this->db->where("ReviewCategoryId", "$categoryId");
			$this->db->select('MovieID');
			$query = $this->db->get('Movies');
			
			if($query->num_rows()>0)
  			{
  				return $query->row()->MovieID;
  			}
  			return NULL;
		}
		
		function tryToGetUserId($nick)
		{
		
			$this->db->where('UserName',$nick);
			
			$this->db->select('UserId');
			$query = $this->db->get('GamelogUsers');
						
			if($query->num_rows()>0)
  			{				
  				return $query->row()->UserId;
  			}
  			return NULL;
		}
		
		function insertMovie($categoryId, $movieTitle, $originalTitle)
		{			
			return $this->db->insert('Movies', array('MovieTitle'=>$movieTitle,'OriginalTitle'=>$originalTitle, 'ReviewCategoryId' => $categoryId));			
		}
		
		function insertUser( $gamelogId, $nick )
		{
			return $this->db->insert('GamelogUsers', array('UserID'=>$gamelogId,'UserName'=>$nick));
		}
		
		function upsertReview($categoryId, $titleId, $userId, $review)
		{		
			$data = array('ReviewCategoryId' => $categoryId
								,'PostID'=>$review['postId']
								,'UserID'=>$userId
								,'MovieID'=>$titleId
								,'Review'=>$review['content']
								,'DatePosted'=>$review['published']->format('Y-m-d H:i:s')
								,'Rating'=>$review['rating']
								,'Is_Forum_Post'=>TRUE
								,'IsNewForum' => 1
								,'Source' => $review['source']
							);
			if( $review['reviewId'] == NULL)				
				$this->db->insert('Reviews', $data);
			else{
				$this->db->where('ReviewID', $review['reviewId']);
				$this->db->update('Reviews', $data);
			}
		}
		
		function reviewExists($postId)
		{
			$this->db->where('PostID',$postId);
			$this->db->where('IsNewForum', 1);
			$this->db->select('ReviewID');
			$query = $this->db->get('Reviews');
						
			if($query->num_rows()>0)
  			{ 	
  				return $query->row()->ReviewID;
  			}
  			return NULL;
		}
	}

?>