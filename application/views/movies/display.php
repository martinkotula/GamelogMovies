<div id="main_content">
	<div id="navigation">
		<?php 
			echo form_open('movies/display', array('class'=>'sorter', 'id'=>'data_sorter'));
			$selected = 'selected="TRUE"';
		 ?>
		 Opcje sortowania:
			<select name="sort" size="1">
				<option value="1" <?php if( $sort === '1' ) echo $selected; ?> >Tytu³</option>
				<option value="2" <?php if( $sort === '2' ) echo $selected; ?> >Ocena</option>
				<option value="3" <?php if( $sort === '3' ) echo $selected; ?> >Liczba recenzji</option>
				
			</select>
			<select name="order" size="1">
				<option value="ASC" <?php if( $order === 'ASC' ) echo $selected; ?> >rosn±co</option>
				<option value="DESC" <?php if( $sort === 'DESC' ) echo $selected; ?> >malej±co</option>	
			</select>
			<br />
			Liczba wyników na stronie: <input type="text" class="text" name="number" value="<?php echo $how_many;?>"  />
			<input type="submit" class="submit button" name="submit" value="Sortuj" />
		<?php echo form_close(); ?>
	</div>
	<div id="movies">
		<div class="pagination"><?php echo $links ?></div>
			<ul>
				<?php foreach($data as $r) : ?>
					<li class="movie">
						<?php echo movie_title($r->MovieTitle, $r->MovieID, $r->AvgRating, $r->TotalReviews); ?>
					</li>
				<?php endforeach ?>
			</ul>
		<div class="pagination"><?php echo $links ?></pagination>	
	</div>
</div>
