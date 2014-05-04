<?php

	function movie_title($movieTitle, $movieID, $rating, $reviewsCount)
	{	
		return "<span class=\"movie_title\"><a href=\"". base_url() ."index.php/movies/details/{$movieID}\">{$movieTitle}</a></span> " .
				"<span class=\"details\"><span class=\"movie_rating\"> ¦rednia ocena: <strong>". round($rating,2) ."</strong></span><span class=\"movie_votes\"> liczba g³osów: <strong>{$reviewsCount}</strong></span></span>";
	}

?>
