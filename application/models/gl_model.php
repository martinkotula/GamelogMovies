<?php
	class Gl_model extends CI_Model
	{
		function get_last_post_ID()
		{			
			$this->db->select_max('PostID','last_post');
			$this->db->where('Is_Forum_Post', 'Y');
			$query = $this->db->get('Reviews');
			
			return $query->row()->last_post;
		}
		
		function insert_movie( Movie $movie)
		{			
			$this->db->insert('Movies', array('MovieTitle'=>$movie->get_movie_title(),'OriginalTitle'=>$movie->get_original_title()));			
		}
		
		
		function contains_post( $postID, $movieID )
		{						
			$this->db->where("MovieID", $movieID);
			$this->db->where("postID", $postID);
			$query = $this->db->get('Reviews');			
			return  $query->num_rows() > 0;
		}
		function insert_review( $title, Review $review )
		{
			$movieID = $this->get_movie_id($title);					
			if( $this->contains_post($review->get_postID(), $movieID) )
			{								
				return 0;
			}						
			$date = preg_split('{/|\s}',$review->get_date_posted());
			$mysql_date = "{$date[2]}/{$date[1]}/{$date[0]} {$date[3]}";			 
			$insert_data = array( 
									'postID'=>$review->get_postID(),
									'UserID'=>$review->get_userID(), 
									'MovieID'=>$movieID, 
									'Review'=>$review->get_review_content(),
									'DatePosted'=>$mysql_date,
									'Rating'=>$review->get_rating()
								);
			$this->db->insert('Reviews', $insert_data);

			return 1;
		}
		
		function get_movie_id($movieTitle)
		{
			$this->db->where('MovieTitle',$movieTitle);
			$this->db->select('MovieID');
			$query = $this->db->get('Movies');
			
			if( $query->num_rows() == 0)
				throw new key_not_found_exception("The movie title: {$movieTitle} doesn't exist in database");
							
			return $query->row()->MovieID;
		}
		
		function insert_user( GamelogUser $user )
		{
			$this->db->insert('GamelogUsers', array('UserID'=>$user->get_gamelogID(),'UserName'=>$user->get_nick()));
		}
		
		function contains_user($userID)
		{
			$this->db->where('UserID',(int)$userID);
			$this->db->from('GamelogUsers');
			$query = $this->db->get();
			
			return $query->num_rows()>0;
		}
		
		function contains_movie($movieTitle)
		{
			$this->db->where('MovieTitle',$movieTitle);
			$query = $this->db->get('Movies');
			
			return $query->num_rows()>0;			
		}
	
		function get_version()
		{		
			$query = $this->db->get('adm_system_info');
			foreach ( $query->result() as $r ) 
				return $r->version;
		}
		
		function get_last_pub_date()
		{		
			$query = $this->db->get('adm_system_info');
			foreach ( $query->result() as $r ) 
				return $r->Last_pub_date;
		}
		
		function get_last_update_date()
		{		
			$query = $this->db->get('adm_system_info');
			foreach ( $query->result() as $r ) 
				return $r->Last_update_date;
		}
		
		function set_version($version)
		{		
			$data = array('version' => $version );
			$this->db->where('id',1);
			$this->db->update('adm_system_info',$data);
			
		}
		
		function set_last_pub_date($date)
		{		
			$data = array('last_pub_date' => $date );
			$this->db->where('id',1);
			$this->db->update('adm_system_info',$data);
		}
		
		function set_last_update_date($date)
		{		
			$data = array('last_update_date' => $date );
			$this->db->where('id',1);
			$this->db->update('adm_system_info',$data);
		}
	}
?>
