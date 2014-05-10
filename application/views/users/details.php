<div id="main_content">
<h2><?php echo $user ?></h2>
<div id="user_details">
<p>Liczba recenzji: <?php echo $reviews_count; ?></p>
<a href="http://www.gamelog.pl/forum2/profile.php?mode=viewprofile&amp;u=<?php echo $userID; ?>">Zobacz profil</a>
</div>
<div id="navigation">
<?php echo form_open("users/details/{$userID}/{$sort}/{$order}"); ?>
Liczba wyników na stronie: <input type="text" class="text" name="number" id="number" value="<?php echo $how_many; ?>" size="5" maxlength="15" />
<input type="submit" class="submit button" name="sort" value="Go!" />
<?php echo form_close(); ?>
</div>
<div id="user_reviews">
<?php
	$count = 1;
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
	<table>
		<tr id="table_header">
			<th>
				<?php echo anchor(base_url()."users/details/{$userID}/1/{$order}/{$how_many}/", 'Tytuł', $attr1); ?>
			</th>
			<th>
				<?php echo anchor(base_url()."users/details/{$userID}/2/{$order}/{$how_many}/", 'Ocena', $attr2); ?>
			</th>
			<th>
				<?php echo anchor(base_url()."users/details/{$userID}/3/{$order}/{$how_many}/", 'Data umieszczenia', $attr3); ?>
			</th>
			<?php if( $canEdit ) : ?>
				<th></th>
			<?php endif ?>
		</tr>
		<?php foreach ( $users_reviews as $r ): ?>
       	<tr class="<?php if(($count++ & 1) == FALSE) echo 'even'; else echo 'odd';?>">
       		<td>
       			<?php echo anchor(base_url()."movies/details/{$r->MovieID}#{$r->PostID}",$r->MovieTitle); ?>
       		</td>
       		<td class="centered">
       			<?php echo $r->Rating; ?>
       		</td>
       		<td class="centered">
       			<?php echo $r->DatePosted; ?>
       		</td>
			<?php if( $canEdit ) : ?>
				<td>
					<a href="<?php echo base_url()."edit/".$r->ReviewID ?>" class="edit" title="Edytuj"> </a>
				</td>
			<?php endif ?>
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
