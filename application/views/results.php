<div id="main_content">
<h2>Wyniki dla: <?php echo $search_phrase?></h2>
<p>znaleziono: <?php echo  count($results); ?> pasuj±cych tytu³ów</p> 
<ul>
<?php foreach ( $results as $r ) : ?>
	<li><?php $title=$r->MovieTitle; if( $r->OriginalTitle!='' ) $title .= " ({$r->OriginalTitle})"; echo anchor(base_url()."movies/details/{$r->MovieID}",$title);?></li>
<?php endforeach ?>
</ul>
</div>