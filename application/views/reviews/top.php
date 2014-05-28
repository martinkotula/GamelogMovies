
<h2><?php echo $title; ?></h2>
	<div id="navigation">
		<?php echo form_open("reviews/top/{$activeLink}", array('class'=>'form-inline', 'role'=>'form')); ?>
		<div class="form-group">
			<label for="number">Liczba wyników na stronie:</label>
			<input type="text" class="text" name="number" value="<?php echo $pageSize;?>"  />
		</div>
		<button type="submit" class="btn btn-default" name="sort" >Pokaż</button>
		<?php echo form_close(); ?>
	</div>
	<p>Wszystkie filmy które uzyskały co najmniej 5 głosów</p>
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
			</div>
			<?php foreach($titles as $r) : ?>
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