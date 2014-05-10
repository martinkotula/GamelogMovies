<h2>Ostatnie recenzje</h2>
<ul>
<?php foreach( $recent_reviews as $r) : ?> 
	<li class="recent_review"><?php echo anchor("movies/details/{$r->MovieID}#{$r->PostID}",$r->MovieTitle) .  " <span class=\"rating\">{$r->Rating}/10</span> <span class=\"author\"> przez  {$r->UserName}</span><span class=\"date_posted\"> {$r->DatePosted}</span>"; ?></li>
<?php endforeach ?>
</ul>
<div class="pagination">
<? echo $links ?>
</div>
