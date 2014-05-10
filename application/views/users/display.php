<div id="main_content">
<h2>Gamelog users</h2>
<div id="navigation">
<?php echo form_open("users/display/{$sort}/{$order}"); ?>
Liczba wyników na stronie: <input type="text" class="text" name="number" id="number" value="<?php echo $how_many; ?>" size="5" maxlength="15" />
<input type="submit" class="submit button" name="sort" value="Go!" />
</div>
<?php echo form_close(); ?>
<table id="users">
	<tr class="table_header">
	<?php
		$count = 1;
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
		</th>
		<th>
		<?php echo anchor(base_url()."users/display/2/{$order}/{$how_many}",'Liczba recenzji',$attr2); ?>
		</th>
	</tr>
		<?php foreach ( $users as $user) : ?>
		<tr class="<?php if(($count++ & 1) == FALSE) echo 'even'; else echo 'odd';?> ">
			<td class="user_nickname" >
				<?php echo anchor(base_url()."users/details/{$user->UserID}",$user->UserName); ?>
			</td>
			<td class="user_reviews_count centered" >
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