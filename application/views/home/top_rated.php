<h3>Najwy¿ej oceniane</h3>
<ul>
<?php foreach( $top_rated_films as $r) : ?> 
	<li><?php echo anchor("movies/details/{$r->MovieID}",$r->MovieTitle . ' - <strong>' . round($r->AvgRating,2) . '</strong>') ; ?></li>
<?php endforeach ?>
</ul>
<span class="see_more"><?php echo anchor("movies/top_rated/",'Zobacz wiêcej');?></span>
