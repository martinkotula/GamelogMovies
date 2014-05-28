<div id="main_content">
<h2><?php echo $user ?></h2>
<div>
<p>Liczba recenzji: <?php echo $reviews_count; ?></p>
<a href="http://www.gamelog.pl/forum2/profile.php?mode=viewprofile&amp;u=<?php echo $userID; ?>">Zobacz profil</a>
</div>
<div class="form-group">
<?php echo form_open("users/details/{$userID}/{$sort}/{$order}"); ?>
<label for="number">Liczba wyników na stronie: </label>
<input type="text" class="text" name="number" id="number" value="<?php echo $how_many; ?>" size="5" maxlength="15" />
<button type="submit" class="btn btn-default" name="submit" >Pokaż</button>
<?php echo form_close(); ?>
</div>
<div>
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
				<?php echo anchor(base_url()."users/details/{$userID}/1/{$order}/{$how_many}/", 'Tytuł', $attr1); ?>
				<?php SortIndicator($sort === '1' ? $order_class : null); ?>
			</th>
			<th>
				<?php echo anchor(base_url()."users/details/{$userID}/2/{$order}/{$how_many}/", 'Ocena', $attr2); ?>
				<?php SortIndicator($sort === '2' ? $order_class : null); ?>
			</th>
			<th>
				<?php echo anchor(base_url()."users/details/{$userID}/3/{$order}/{$how_many}/", 'Data umieszczenia', $attr3); ?>
				<?php SortIndicator($sort === '3' ? $order_class : null); ?>
			</th>
		</tr>
		<?php foreach ( $users_reviews as $r ): ?>
       	<tr>
       		<td>
       			<?php echo anchor(base_url()."reviews/details/{$r->MovieID}#{$r->PostID}",$r->MovieTitle); ?>
       		</td>
       		<td>
       			<small><?php echo ReviewRating($r->Rating); ?></small>
       		</td>
       		<td>
       			<small><?php echo $r->DatePosted; ?></small>
       		</td>			
       	</tr>
		<?php endforeach ?>
	<tr>
		<td colspan="4" class="links">			
			<?php echo $links; ?>
			
		</td>
	</tr>
	</table>
</div>
</div>
