<div id="main_content">
	<div id="edit_review">
	<?php 
		$rating = array(
						'1'=>1 , '2'=>2,'3'=>3, '4'=>4,'5'=>5,'6'=>6,'7'=> 7,'8'=>8,'9'=>9,'10'=>10
						);

		echo '<div  id="errors">'. validation_errors(). $this->session->flashdata('error') .'</div>';
		echo '<div id="info">'. $this->session->flashdata('info'). '</div>';
		echo '<div class="clear toggle-one" id="t_insert_title">' 
		  . form_open('edit/new_title_edit/'.$review->ReviewID) 
		  . '<p class="left">Nowy tytuł: ' . form_input('movie_title','','maxlength="100" class="required"'). ' Oryginalny tytuł: '
		  . form_input('original_title', '', 'maxlength="100"')
		  . '</p><input type="image" src="'.base_url().'/assets/images/check32.png" alt="Dodaj" name="title_insert" title="Dodaj" class="left"/>'
		  . form_close(). '</div>';	
		
		
		echo form_open('edit/update') 
		.  '<div class="clearfix">'	
		. form_dropdown('titles', $movies, $movieID, 'class="left" id="titles_select"')		
		. '<a id="insert_title" href="" title="Dodaj"  class="toggle left" ></a>'		
		. '</div>';
			
		echo '<div class="clearfix" id="review_details">' 		
		.'<p id="author">Autor: ' . $user .'</p>'
		.'<p id="date_posted" class="right">'. form_label( $review->DatePosted). '</p>'
		.'<p class="clear"><label for="review_content">Treść:</label><br />'. form_textarea(array ('name'=>'review_content', 'id'=>'review_content', 'value'=>$review->Review, 'rows'=>15)). '</p> ' 
		.'<p class="left">Ocena: '. form_dropdown('rating', $rating, $review->Rating). '</p>'
		.'<p><a class="right" href="http://www.gamelog.pl/forum2/viewtopic.php?p='.$review->PostID.'#'.$review->PostID.'">Zobacz oryginaln± wiadomość</a></p>'
		. form_hidden('reviewID', $review->ReviewID)
		. form_hidden('movieID', $movieID)
		. '<input type="image" src="'.base_url().'/assets/images/check32.png" alt="Zapisz" name="Save" value="Save" title="Zapisz" class="clear left"/>'		
		. form_close()
		. form_open('edit/delete/'.$review->ReviewID)
		.'<input type="image" src="'.base_url().'/assets/images/stop32.png" alt="Usuń" name="Delete" id="delete" value="Delete" title="Usuń" class="right"/>'		
		. form_close();
		
	?>
	
	<div id="confirm" title="Usunięcie recenzji">
			<div id="loading">
			</div>			
			<div>
				<p>Czy na pewno chcesz usun±ć recenzję?</p>
			</div>
	</div>	
	</div>
</div>
