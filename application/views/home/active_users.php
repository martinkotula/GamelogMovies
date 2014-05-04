<h3>Najaktywniejsi u¿ytkownicy</h3>
<ul>
<?php foreach( $most_active_users as $r) : ?> 
	<li><?php echo anchor("users/details/{$r->UserID}",$r->UserName . ' - ' . "<strong>{$r->ReviewsCount}</strong>" . ' recenzji'); ?></li>	
<?php endforeach ?>
</ul>
<?php echo "<span class=\"see_more\">". anchor("users/display/2/2","Zobacz wiêcej")."</span>" ?>