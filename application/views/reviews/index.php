<div id="navigation">
	<?php 
		echo form_open("reviews/{$activeLink}", array('class'=>'form-inline', 'role'=>'form'));
		$selected = 'selected="TRUE"';
	 ?>
	
	<div class="form-group">
		<label for="number">Liczba wyników na stronie:</label>
		<input type="text" class="text" name="number" value="<?php echo $pageSize;?>"  />
	</div>
	<button type="submit" class="btn btn-default" name="submit" >Sortuj »</button>
	<?php echo form_close(); ?>
</div>
<div class="pagination"><?php echo $links ?></div>	
<?php	
	$order_class = ($order === '1')?'asc':'desc'; 
	$order = ( $order==='1' )? '2':'1';
	$attr1 = array(); $attr2 = array(); $attr3 = array();
	$class = 'selected '.$order_class;
	switch($sort)
	{
		case '1': 
			$attr1['class'] = $class;
			break;
		case '2':
			$attr2['class'] = $class;
			break;
		case '3':
			$attr3['class'] = $class;
	} 
?>
	<table class="table table-hover">
		<tr id="table_header">
			<th>
				<?php echo anchor(base_url()."reviews/index/{$activeLink}/1/{$order}/{$pageSize}/", 'Tytuł', $attr1); ?>
				<?php SortIndicator($sort === '1' ? $order_class : null); ?>
			</th>
			<th>
				<?php echo anchor(base_url()."reviews/index/{$activeLink}/2/{$order}/{$pageSize}/", 'Średnia ocena', $attr2); ?>
				<?php SortIndicator($sort === '2' ? $order_class : null); ?>
			</th>
			<th>
				<?php echo anchor(base_url()."reviews/index/{$activeLink}/3/{$order}/{$pageSize}/", 'Liczba recenzji', $attr3); ?>
				<?php SortIndicator($sort === '3' ? $order_class : null); ?>
			</th>
		</tr>
			<?php foreach($data as $r) : ?>
				<tr>
					<td>
						<?php echo anchor("reviews/details/{$r->MovieID}", $r->MovieTitle); ?>
					</td>
					<td>
						<small><?php echo ReviewRating($r->AvgRating) ?></small>
					</td>
					<td>
						<strong><?php echo $r->TotalReviews; ?></strong>
					</td>
				</tr>
			<?php endforeach ?>
	</table>
<div class="pagination"><?php echo $links ?></div>
