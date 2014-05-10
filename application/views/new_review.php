<div id="main_content">
	<div id="edit_review">
	<?php 
		$rating = array(
						'1'=>1 , '2'=>2,'3'=>3, '4'=>4,'5'=>5,'6'=>6,'7'=> 7,'8'=>8,'9'=>9,'10'=>10
						);

		echo '<div id="errors">'. validation_errors(). $this->session->flashdata('error') .'</div>';
		echo '<div id="info">'. $this->session->flashdata('info'). '</div>';
		
		echo '<div class="clear toggle-one" id="t_insert_title">' 
		  . form_open('edit/new_title_insert/') 
		  . '<p class="left">Nowy tytuł: ' . form_input('movie_title','','maxlength="100" class="required"'). ' Oryginalny tytuł: '
		  . form_input('original_title', '', 'maxlength="100"')
		  . '</p><input type="image" src="'.base_url().'/assets/images/check32.png" alt="Dodaj" name="title_insert" title="Dodaj" class="left"/>'
		  . form_close(). '</div>';	
		echo '<div class="clearfix">'	
		. form_open('edit/insert/')  
		. form_dropdown('movieID', $movies, $movieID ? $movieID : 0, 'class="left"')		
		. '<a id="insert_title" href="" title="Dodaj"  class="toggle left" ></a>'				
		. '</div>';
					
		
			
		echo '<div class="clear" id="review_details">' 		
		.'<p id="author">Autor: ' . $user .'</p>'		
		.'<p class="clear"><label for="review_content">Tre¶ć:</label><br />'. form_textarea(array ('name'=>'review_content', 'id'=>'review_content',  'rows'=>15)). '</p> ' 
		.'<p class="left">Ocena: '. form_dropdown('rating', $rating, '5'). '</p>'				
		. '<input type="image" src="'.base_url().'/assets/images/check32.png" alt="Zapisz" name="Save" value="Save" title="Zapisz" class="clear left"/>'		
		. form_close().'</div>';
	?>
	</div>
</div>
