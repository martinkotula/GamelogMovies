<div id="main_content">
<table>
	<tr>
		<th>Akcja</th>
		<th>Komentarz</th>
		<th>Data zg³oszenia</th>
	</tr>
	<?php foreach( $bad_reviews as $bad_review): ?>
	<tr>
		<td class="centered">
			<ul>
			<li><?php echo anchor('edit/review/'.$bad_review->ReviewID,'Edytuj');?><li>
			<li><?php echo anchor('edit/delete_bad_review/'.$bad_review->ID,'Usuñ');?></li>
			</ul> 
		</td>
		<td class="centered bad-review-comment">
			<?php echo $bad_review->Comment; ?>
		</td>
		<td class="centered">
			<?php echo $bad_review->CommentDate; ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
</div>