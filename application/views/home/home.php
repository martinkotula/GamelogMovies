<h1>Ostatnie recenzje</h1>
	<?php function ReviewCategoryIcon($code, $title){
		if($code == 'FILMS')
			echo '<div title="Code: 0xe802"><i class="icon-video"></i>'.$title.'</div>';
		if($code == 'GAMES')
			echo '<div title="Code: 0xe803"><i class="icon-gamepad"></i>'.$title.'</div>';
		if($code == 'BOOKS')
			echo '<div title="Code: 0xe804"><i class="icon-book"></i>'.$title.'</div>';
	}
	?>

	<?php for($i = 0; $i<3; $i++) { ?>
	  <div class="row">
		
		<?php for($j = 0; $j<3; $j++) {
			$r = $recent_reviews[$i*3+$j];			
		?>	  
        <div class="col-md-4">
          <h2><?php ReviewCategoryIcon($r->Code, $r->MovieTitle); ?></h2>
		  <h4 class="clearfix"><span class="pull-left"><?php echo $r->UserName; ?></span><span class="pull-right small"><?php echo $r->DatePosted;?></span></h4>
		  <div class="clearfix">
          <p ><?php echo substr($r->Review, 0, 500) . '...'; ?></p>
		  </div>
		  <div class="clearfix" >
		  <div title="Code: 0xe801" class="pull-left"><i class="icon-thumbs-down"></i></div>	 
		  <div class="progress pull-left" style="width:86%">        
			<div class="progress-bar progress-bar-<?php if($r->Rating <= 3) echo 'danger'; else if($r->Rating <=7) echo 'warning'; else echo 'success'; ?> " role="progressbar" style="width: <?php echo $r->Rating*10?>%"><span><?php echo $r->Rating ?>/10</span></div>				        
		  </div>
		  <div title="Code: 0xe800" class="pull-left"><i class="icon-thumbs-up"></i></div>
		  </div>
          <?php echo anchor("movies/details/{$r->MovieID}#{$r->PostID}",'Więcej »','class="btn btn-default" role="button"') ?>
        </div>       

	  <?php } ?>
      </div>	  
	<?php } ?>
		