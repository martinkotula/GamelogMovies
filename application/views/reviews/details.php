<div style="text-align:center">
<h1><?php echo ReviewCategoryIcon($movie->CategoryCode, $movie->MovieTitle); ?></h1>
<h2><?php echo $movie->OriginalTitle; ?></h2>
<h3>Średnia ocena: <?php echo $rating; ?></h3>
</div>

<div class="clearfix col-xs-12" style="padding-top:30px">
<?php foreach ( $reviews as $r ) : ?>	
<div class="row">
	<a name="<?php echo $r->PostID; ?>" ></a>
	
	<div class="review_content">		
		<h4 class="clearfix"><span class="pull-left"><?php echo anchor( "users/details/{$r->UserID}",$r->UserName);?></span><span class="pull-right small"><?php echo $r->DatePosted; ?></span></h4>
		<hr />
		<p class="review"><?php echo $r->Review; ?></p>
		
	
	
		
	</div>
	<div class="pull-left" style="width:80%">
		<?php ReviewRating($r->Rating); ?>
	</div>
	<div class="btn-group pull-right">			
		<a href="<?php echo $r->HomeLink; ?>" target="_blank" ><button type="button" class="btn btn-default" title="Zobacz oryginalną wiadomość"><span class="glyphicon glyphicon-home"></span></button></a>
<!--		<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-warning-sign" title="Zgłoś błąd"></span></button> -->
		<a href="<?php echo $r->Permalink ?>"><button type="button" class="btn btn-default" title="Permalink"><span class="glyphicon glyphicon-link" ></span></button></a>
	</div>

	
</div>
<?php endforeach ?>
</div>	