<h1>Ostatnie recenzje</h1>

	<?php for($i = 0; $i<3; $i++) { ?>
	  <div class="row">
		
		<?php for($j = 0; $j<3; $j++) {
			$r = $recent_reviews[$i*3+$j];			
		?>	  
        <div class="col-md-4">
          <h2><?php ReviewCategoryIcon($r->Code, anchor("reviews/details/{$r->MovieID}",$r->MovieTitle)); ?></h2>
		  <h4 class="clearfix"><span class="pull-left"><?php echo $r->UserName; ?></span><span class="pull-right small"><?php echo $r->DatePosted;?></span></h4>
		  <div class="clearfix">
          <p ><?php echo substr($r->Review, 0, 500) . '...'; ?></p>
		  </div>
		  	<?php ReviewRating($r->Rating); ?>
          <?php echo anchor("reviews/details/{$r->MovieID}#{$r->PostID}",'Więcej »','class="btn btn-default" role="button"') ?>
        </div>       

	  <?php } ?>
      </div>	  
	<?php } ?>