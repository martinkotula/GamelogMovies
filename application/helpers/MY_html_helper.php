	<?php function ReviewCategoryIcon($code, $title){
		if($code == 'FILMS')
			echo '<span class="glyphicon glyphicon-film" ></span> '.$title;
		if($code == 'GAMES')
			echo '<div title="Code: 0xe803"><i class="icon-gamepad"></i>'.$title.'</div>';
		if($code == 'BOOKS')
			echo '<span class="glyphicon glyphicon-book" ></span> '.$title;	
	}
	
	function ReviewRating($rating){
		
		$type = 'success';
		if( $rating <= 3)
			$type = 'danger';
		else if( $rating <= 7)
			$type = 'warning';
		
		echo '<div class="progress">        
				<div class="progress-bar progress-bar-'.$type .'" role="progressbar" style="width: '. $rating*10 .'%"><span>' .$rating. '/10</span></div>
			  </div>';
	}
	
	function SortIndicator($order)
	{
		if($order == 'asc')
			echo '<span class="glyphicon glyphicon-chevron-up" /></span>';
			
		if($order == 'desc')
			echo '<span class="glyphicon glyphicon-chevron-down" /></span>';
	}
	?>

	