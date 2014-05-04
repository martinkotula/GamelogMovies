<?php
	class Users_model extends CI_Model
	{
		const D_ID_MODERATOR =  5;
		
		function get_users($sort, $order, $how_many, $offset)
		{
			$sql = "SELECT u.UserID, u.UserName, COUNT(*) AS ReviewsCount FROM GamelogUsers u" .
					" JOIN Reviews r ON r.UserID = u.UserID" .
					" GROUP BY u.UserID" .
					" ORDER BY ". $this->db->escape_str($sort) ." ". $this->db->escape_str($order) .
					" LIMIT ?,?";
			$query = $this->db->query($sql, array((int)$offset, (int)$how_many));
			
			$data = array();
			get_data($query,$data);
			return  $data;  
		}
		
		function get_users_reviews($userID, $sort, $order, $how_many, $offset)
		{
			$sql = "SELECT m.MovieID, m.MovieTitle, r.PostID, r.Rating, r.DatePosted, r.ReviewID FROM Reviews r" .  					
  					" JOIN Movies m ON r.MovieID = m.MovieID" .
  					" JOIN GamelogUsers u ON u.UserID = r.UserID" .
  					" WHERE u.UserID = ?" .
  					" ORDER BY ". $this->db->escape_str($sort) ." " . $this->db->escape_str($order)  .", MovieTitle" .
  					" LIMIT ?, ?";
			$query = $this->db->query($sql, array((int)$userID, (int)$offset, (int)$how_many));
			//echo $this->db->last_query();
//			if( $query->num_fields() > 0 )
//			{
//				foreach ( $query->result() as $r )
//				{
//       				$data[] = $r;
//				}
//			}
			$data = array();
			get_data($query,$data);
			return  $data; 
		}
		function get_user_nick($userID)
		{
			$this->db->where('UserID',$userID);
			$query = $this->db->get('GamelogUsers');
			if( $query->num_fields() > 0)
				return $query->row()->UserName;
				
			throw new Key_not_found_exception('User with the supplied ID doesn\'t exist');
		}
		function get_user_id($userName)
		{
			$this->db->select('UserID');
			$this->db->where('UserName',$userName);
			$query = $this->db->get('GamelogUsers');
			if( $query->num_rows() == 0)
				throw new Key_not_found_exception("User with name: {$userName} doesn't exist.");
			if( $query->num_rows() > 1 )
				throw new Key_not_found_exception("Ambigious user name: {$userName}.");
				
			return $query->row()->UserID;
		}
		
		function is_moderator($user_id)
		{			
			$this->db->select('UserGroup');
			$this->db->where('UserId',$user_id);
			$query = $this->db->get('GamelogUsers');
			if( $query->num_rows() == 0)
				throw new Key_not_found_exception("User with id: {$user_id} doesn't exist.");
			if( $query->num_rows() > 1 )
				throw new Key_not_found_exception("Ambigious user name: {$user_id}.");
			
			$row = $query->row();			
			
			return $row->UserGroup == self::D_ID_MODERATOR;
		}
		
		function count_user_reviews($userID)
		{
			$this->db->where('UserID',$userID);
			return $this->db->count_all_results('Reviews');
		}			
		
		function get_users_names()
		{
			$query = $this->db->get('GamelogUsers');
			$data = array();
			if( $query->num_rows() > 0)
			{
				foreach($query->result() as $r)
					$data[$r->UserID] = $r->UserName;
			}			
			return $data;	
		}
	
		function count_users()
		{
			return $this->db->count_all('GamelogUsers');
		}
				
	}
?>
