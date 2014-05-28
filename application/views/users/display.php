<div id="main_content">
<h2>Użytkownicy</h2>
<div>
<div class="form-group"> 
<?php echo form_open("users/display/{$sort}/{$order}"); ?>
<label for="text">Liczba wyników na stronie: </label><input type="text" class="text" name="number" id="number" value="<?php echo $how_many; ?>" size="5" maxlength="15" />
<button type="submit" class="btn btn-default" name="submit" >Pokaż</button>
<?php echo form_close(); ?>
</div>
</div>
<table class="table table-hover">
	<tr class="table_header">
	<?php
		
		$order_class = ($order === '1')?'asc':'desc'; 
		$order = ( $order==='1' )? '2':'1';
		$attr1 = array(); $attr2 = array();
		if($sort==='1')
			$attr1['class'] = 'selected '.$order_class;
		else
			$attr2['class'] = 'selected '.$order_class ;									
	?>
		<th>
		<?php echo anchor(base_url()."users/display/1/{$order}/{$how_many}",'Nick',$attr1); ?>
		<?php SortIndicator($sort === '1' ? $order_class : null); ?>
		</th>
		<th>
		<?php echo anchor(base_url()."users/display/2/{$order}/{$how_many}",'Liczba recenzji',$attr2); ?>
		<?php SortIndicator($sort === '2' ? $order_class : null); ?>
		</th>
	</tr>
		<?php foreach ( $users as $user) : ?>
		<tr >
			<td>
				<?php echo anchor(base_url()."users/details/{$user->UserID}",$user->UserName); ?>
			</td>
			<td>
				<?php echo $user->ReviewsCount; ?>
			</td>
		</tr>
		<?php endforeach ?>
		<tr>
			<td colspan="2" class="links">
				
					<div class="pagination"><?php echo $links ?></div>
				
			</td>
		</tr>
</table>
</div>