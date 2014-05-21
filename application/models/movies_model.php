<?php

	class Movies_model extends CI_Model
	{
		function getAll()
		{
			$query = $this->db->get('movies',10);
			return $query->result_array();
		}
		
		function get_top_rated($categoryCode, $how_many, $offset=0)
		{
			$sql = "SELECT Reviews.MovieID, MovieTitle, AVG(Rating) AS AvgRating, COUNT(*) AS TotalReviews FROM Movies"
  							." JOIN Reviews ON Movies.MovieID = Reviews.MovieID"
							." JOIN ReviewCategories rc ON Movies.ReviewCategoryId = rc.ReviewCategoryId"
							." WHERE UPPER(rc.Code) = UPPER(?)"
  							." GROUP BY Reviews.MovieID"
  							." HAVING TotalReviews > 4"
  							." ORDER BY AvgRating DESC, TotalReviews DESC"
  							." LIMIT ?,?";
			$query = $this->db->query($sql, array( $categoryCode, (int)$offset, (int)$how_many) );					
			
  			$data = array();
  			get_data($query, $data);
  			return $data;
		}
		
		function count_top_rated($categoryCode)
		{
			$query = $this->db->query("SELECT COUNT(*) AS TopRatedCount FROM " .
					" (SELECT COUNT(*) AS nr FROM Reviews r JOIN ReviewCategories rc ON r.ReviewCategoryId = rc.ReviewCategoryId" .
					" WHERE UPPER(rc.Code) = UPPER(?)".
					" GROUP BY MovieID" .
					" HAVING nr > 4) AS tmp", array($categoryCode));
			
			return $query->row()->TopRatedCount;
		}
		
		function movies_with_no_reviews()
		{
			$sql = "SELECT MovieID FROM Movies where MovieID NOT IN (SELECT MovieID FROM Reviews GROUP BY MovieID)";
			$query = $this->db->query($sql);
			$data = array();
			foreach( $query->result() as $movie)
				$data[] = $movie;
			return $data;			
		}
		
		function search_movie($key_word)
		{
			$sql = "SELECT m.MovieID, MovieTitle, OriginalTitle FROM Movies m JOIN Reviews r ON m.MovieID=r.MovieID " .								
					" WHERE MovieTitle = ? OR MovieTitle LIKE '%". $this->db->escape_str($key_word) ."%'" .
					" OR OriginalTitle = ? OR OriginalTitle LIKE '%". $this->db->escape_str($key_word) ."%'" .
					" GROUP BY m.MovieID";
			$query = $this->db->query($sql, array($key_word,$key_word));
			$data = array();
			get_data($query, $data);
			return $data;
		}
		
		function get_movies( $categoryCode, $sortBy, $order, $pageSize, $offset)
		{
			$sql = "SELECT m.MovieID, MovieTitle, OriginalTitle, ROUND(AVG(Rating),2) AS AvgRating, COUNT(*) AS TotalReviews"			
  				." FROM Movies m JOIN Reviews r ON m.MovieID = r.MovieID"
				." JOIN ReviewCategories rc ON m.ReviewCategoryId = rc.ReviewCategoryId"
				." WHERE UPPER(rc.Code) = UPPER(?)"
				." GROUP BY m.MovieID"
				." ORDER BY ". $this->db->escape_str($sortBy) . ' ' . $this->db->escape_str($order) .", MovieTitle ASC" 
				." LIMIT ?,?";
			$query = $this->db->query($sql, array($categoryCode, (int)$offset, (int)$pageSize));
  			
  			$data = array();
  			get_data($query, $data);
  			return $data;			
		}
		
		function count_movies($categoryCode)
		{
			$sql = "SELECT m.MovieID"			
  				." FROM Movies m JOIN Reviews r ON m.MovieID = r.MovieID"
				." JOIN ReviewCategories rc ON m.ReviewCategoryId = rc.ReviewCategoryId"
				." WHERE UPPER(rc.Code) = UPPER(?)"
				." GROUP BY m.MovieID";
				
			$query = $this->db->query($sql, array((string)$categoryCode));
			return count($query->result());
		}
		
		function get_movie($movieID)
		{
			$sql = "SELECT m.MovieID, MovieTitle, OriginalTitle, rc.Code as CategoryCode"
  				." FROM Movies m"
				." JOIN ReviewCategories rc ON m.ReviewCategoryId = rc.ReviewCategoryId"
				." WHERE m.MovieID = ?";
				
			$query = $this->db->query($sql, array((int)$movieID));

			if($query->num_fields()>0)
  			{  				  				
  				return $query->row();
  			}
  			return NULL;
  			
		}
		
		function get_movie_id($movieTitle)
		{
			$this->db->where('MovieTitle',$movieTitle);
			$this->db->select('MovieID');
			$query = $this->db->get('Movies');
						
			if($query->num_fields()>0)
  			{  				  				
  				return $query->row()->MovieID;
  			}
  			return NULL;
  			
		}
		
		function get_movie_rating($movieID)
		{
			$sql = "SELECT AVG(Rating) AS AvgRating FROM Movies m" .
					" JOIN Reviews r ON m.MovieID = r.MovieID" .
					" WHERE m.MovieID = ?" .					
					" GROUP BY m.MovieID";
					
			$query = $this->db->query($sql, array((int)$movieID));
			
			if($query->num_fields()>0)
  			{
  				return $query->row();
  			}
  			return NULL;
		}
		
		function get_movies_titles()
		{
			$this->db->order_by('MovieTitle');
			$query = $this->db->get('Movies');
			
			if( $query->num_rows() > 0 )
			{
				foreach( $query->result() as $r )
				{
					$orig = '';
					if( $r->OriginalTitle != '')
						$orig = "({$r->OriginalTitle})"; 
					$data[$r->MovieID] = $r->MovieTitle . $orig;
				} 
			} 
			return $data;
		}
		function delete($movieID)
		{
			$this->db->where('MovieID',"$movieID");
			$this->db->delete('Movies');
		}
		
		function update($movieID, $title, $original_title)
		{		
		
			$this->db->update('Movies',array('MovieTitle'=>$title, 'OriginalTitle'=>$original_title),array('MovieID'=>$movieID));
		}
		
		function insert($movieTitle, $originalTitle)
		{			
			
			$this->db->insert('Movies', array('MovieTitle'=>$movieTitle,'OriginalTitle'=>$originalTitle));			
		}
		
		
		function delete_models_with_no_reviews()
		{
			$this->db->select('COUNT(*) as ReviewsCount');
			$this->db->group_by('MovieID');
			$this->db->from('Reviews');
			$this->db->where('ReviewsCount',0);
			$this->db->delete();
		}
		
	} 
	
?>
