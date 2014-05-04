<div id="main_content">
	<h1 id="movie_title"><?php echo $movie->MovieTitle?></h1>
	<h1 id="original_title"><?php echo $movie->OriginalTitle; ?></h1>
	
	<?php if($canEdit )
	{
		echo '<div  id="errors">'. validation_errors(). $this->session->flashdata('error') .'</div>';
		echo '<div id="info">'. $this->session->flashdata('info'). '</div>';
		echo  '<a id="edit_title" href="" title="Dodaj"  class="toggle right" ></a>'
			. '<div class="toggle-one" id="t_edit_title">' 
			. form_open('movies/update_title/' )
			.form_hidden('movieID', $movie->MovieID)
			. '<p class="left">Modyfikuj tytu³: ' . form_input('movie_title',set_value('movie_title',$movie->MovieTitle),'maxlength="100" class="required"')
			. ' Oryginalny tytu³: '
			. form_input('original_title', set_value('original_title', $movie->OriginalTitle), 'maxlength="100"')
			. '</p><input type="image" src="'.base_url().'/assets/images/check32.png" alt="Zapisz" name="title_edit" title="Zapisz" class="left"/>'		
			. form_close()
			. '</div>';
			
	}
	?>
	<p id="movie_rating" class="clear">¦rednia ocena: <span><?php echo round($rating,2); ?></span></p>
	<?php foreach ( $reviews as $r ) : ?>	

			<a name="<?php echo $r->PostID; ?>" ></a>
			
					<div class="review_content">		
						<p class="author"><?php echo anchor( base_url()."users/details/{$r->UserID}",$r->UserName);?></p>
						<p class="date_posted"><?php echo $r->DatePosted; ?></p>		
						<p class="review"><?php echo $r->Review; ?></p>
						<p class="rating">Ocena: <span><?php echo $r->Rating; ?></span></p>
						<div class="review_nav clear">
							<ul>
								<li><a class="go_to_source" href="http://www.gamelog.pl/forum2/viewtopic.php?p=<?php echo $r->PostID .'#'.$r->PostID ?>"title="Zobacz oryginaln± wiadomo¶æ"></a></li>
								<li><a class="error_report" id="<?php echo $r->ReviewID ?>" href="" title="Zg³o¶ b³±d"></a></li>		
								<?php if( $r->CanEdit): ?>
									<li><?php echo anchor('edit/review/'.$r->ReviewID,' ', array('class'=>'edit', 'title'=>'Edit')); ?></li>
								<?php endif; ?>
								<li><a class="toggle" id="<?php echo $r->PostID ?>" href="" title="Permalink" ></a></li>
								<li><input class="permalink" id="t_<?php echo $r->PostID ?>"  value="<?php echo $r->Permalink ?>" size="75" /></li>
							<ul> 
						</div>
					</div>				
					
										
		

	<?php endforeach ?>       
	

	<div id="dialog" title="Zg³o¶ b³±d">
			<div id="loading">
			</div>
			<div id="result">
			<p>Dziêkujê za zg³oszenie b³êdu</p>
			</div>
			<form>				
				<input type="hidden" id="postID" name="postID" value="value" />
				<textarea name="comment" id="comment" rows="5" cols="40" wrap="off">Co jest nie tak?</textarea>
			</form>
	</div>	
	
</div>