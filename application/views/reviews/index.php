<div id="navigation">
	<?php 
		echo form_open("reviews/{$activeLink}", array('class'=>'form-inline', 'role'=>'form'));
		$selected = 'selected="TRUE"';
	 ?>
	<div class="form-group"> 
	 <label>Opcje sortowania:</label>
		<select name="sort" size="1">
			<option value="1" <?php if( $sort === '1' ) echo $selected; ?> >Tytuł</option>
			<option value="2" <?php if( $sort === '2' ) echo $selected; ?> >Ocena</option>
			<option value="3" <?php if( $sort === '3' ) echo $selected; ?> >Liczba recenzji</option>			
		</select>
		<select name="order" size="1">
			<option value="ASC" <?php if( $order === 'ASC' ) echo $selected; ?> >rosnąco</option>
			<option value="DESC" <?php if( $order === 'DESC' ) echo $selected; ?> >malejąco</option>	
		</select>
	</div>
	<div class="form-group">
		<label for="number">Liczba wyników na stronie:</label>
		<input type="text" class="text" name="number" value="<?php echo $pageSize;?>"  />
	</div>
	<button type="submit" class="btn btn-default" name="submit" >Sortuj></button>
	<?php echo form_close(); ?>
</div>
<div class="col-12-xs">
<div class="pagination"><?php echo $links ?></div>	
			<div class="row">
				<div class="col-xs-6">
					<strong>Tytuł</strong>
				</div>
				<div class="col-xs-4">
					<strong>Średnia ocena</strong>
				</div>
				<div class="col-xs-2">
					<strong>Liczb recenzji</strong>
				</div>
			</div
			<?php foreach($data as $r) : ?>
				<div class="row">
					<div class="col-xs-6">
						<?php echo anchor("reviews/details/{$r->MovieID}", $r->MovieTitle); ?>
					</div>
					<div class="col-xs-4">
						<small><?php echo ReviewRating($r->AvgRating) ?></small>
					</div>
					<div class="col-xs-2">
						<strong><?php echo $r->TotalReviews; ?></strong>
					</div>
				</div>
			<?php endforeach ?>
		
<div class="pagination"><?php echo $links ?></pagination>	
</div>