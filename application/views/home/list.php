<span class="pull-right"><?php echo anchor("home/index", '<button class="btn btn-default"><span class="glyphicon glyphicon-th-large" /></span></button>', 'title="Kafelki"'); ?></span>
<h1>Ostatnie recenzje</h1>

<div class="col-12-xs">
<div class="pagination"><?php echo $links ?></div>
<table class="table table-hover">
		<tr id="table_header">
			<th>			
					Tytuł
				</th>
				<th>
					Autor
				</th>
				<th>
					Ocena
				</th>
				<th>
					Data recenzji
				</th>
			</tr>
			<?php foreach($recent_reviews as $r) : ?>
				<tr>
					<td>
						<?php echo anchor("reviews/details/{$r->MovieID}#{$r->PostID}", $r->MovieTitle); ?> 
					</td>
					<td>
						<small><?php echo $r->UserName; ?></small>
					</td>
					<td>
						<small><?php echo ReviewRating($r->Rating) ?></small>
					</td>
					<td>
						<small><?php echo $r->DatePosted; ?></small>
					</td>
				</tr>
			<?php endforeach ?>
	</table>	
<div class="pagination"><?php echo $links ?></div>
</div>