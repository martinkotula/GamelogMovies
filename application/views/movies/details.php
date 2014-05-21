<h1><?php echo $movie->MovieTitle?></h1>
<h2><?php echo $movie->OriginalTitle; ?></h2>
	
<p id="movie_rating" class="clear">Średnia ocena: <span><?php echo  ?></span></p>

		  <div class="clearfix" >
			<div title="Code: 0xe801" class="pull-left"><i class="icon-thumbs-down"></i></div>	 
			<div class="progress pull-left" style="width:86%">        
				<div class="progress-bar progress-bar-<?php if($rating <= 3) echo 'danger'; else if($rating <=7) echo 'warning'; else echo 'success'; ?> " role="progressbar" style="width: <?php echo $rating*10?>%"><span><?php echo $rating ?>/10</span></div>				        
			</div>
			<div title="Code: 0xe800" class="pull-left"><i class="icon-thumbs-up"></i></div>
		  </div>
		  
<?php foreach ( $reviews as $r ) : ?>	

	<a name="<?php echo $r->PostID; ?>" ></a>
	
	<div class="review_content">		
		<p class="author"><?php echo anchor( base_url()."users/details/{$r->UserID}",$r->UserName);?></p>
		<p class="date_posted"><?php echo $r->DatePosted; ?></p>		
		<p class="review"><?php echo $r->Review; ?></p>
		<p class="rating">Ocena: <span><?php echo $r->Rating; ?></span></p>
		<div class="review_nav clear">
			<ul>
				<li><a class="go_to_source" href="http://www.gamelog.pl/forum2/viewtopic.php?p=<?php echo $r->PostID .'#'.$r->PostID ?>"title="Zobacz oryginaln± wiadomo¶ć"></a></li>
				<li><a class="error_report" id="<?php echo $r->ReviewID ?>" href="" title="Zgło¶ bł±d"></a></li>		
				<?php if( $r->CanEdit): ?>
					<li><?php echo anchor('edit/review/'.$r->ReviewID,' ', array('class'=>'edit', 'title'=>'Edit')); ?></li>
				<?php endif; ?>
				<li><a class="toggle" id="<?php echo $r->PostID ?>" href="" title="Permalink" ></a></li>
				<li><input class="permalink" id="t_<?php echo $r->PostID ?>"  value="<?php echo $r->Permalink ?>" size="75" /></li>
			<ul> 
		</div>
	</div>	
<?php endforeach ?>