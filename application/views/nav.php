<div id="links">
	<ul>		
		<li class="movies"><a href="<?php echo base_url() . 'movies'; ?>" >Filmy</a></li>
		<li class="users"><a href="<?php echo base_url() . 'users/display'; ?>">U¿ytkownicy</a></li>
		<?php foreach( $main_nav as $link ) 
				echo $link;
		?>
		
	</ul>
	</div>
	<?php 
		if( isset($secondary) )
		{
			echo '<div id="secondary-links" class="clear"><ul>';
			foreach( $secondary as $key => $value )
				echo '<li>' . anchor($value,$key) .'</li>';
			echo '</ul></div>';
		}
	?>


