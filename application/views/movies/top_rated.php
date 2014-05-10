<div id="main_content">
<h2>Najwyżej oceniane</h2>
	<div id="navigation">
		<?php echo form_open("movies/top_rated"); ?>
		Liczba wyników na stronie: <input type="text" class="text" name="number" id="number" value="<?php echo $how_many; ?>" size="5" maxlength="15" />
		<input type="submit" class="submit button" name="sort" value="Go!" />
		<?php echo form_close(); ?>
	</div>
	<p>Wszystkie filmy które uzyskały co najmniej 5 głosów</p>
	<ul>
	<div class="pagination"><?php echo $links ?></div>
	<?php foreach ( $movies as $m ) : ?>
		<li class="movie">
			<?php echo movie_title($m->MovieTitle, $m->MovieID, $m->AvgRating, $m->ReviewsCount); ?>
		</li>
	<?php endforeach ?>
	</ul>
	<div class="pagination"><?php echo $links; ?></div>
</div>