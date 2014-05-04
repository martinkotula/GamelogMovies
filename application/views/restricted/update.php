<div id="main_content">
	<?php echo form_open('moderator/update');?>
	<p>Wczytaj ostatnie recenzje: </p><?php echo form_submit('Update','RegularUpdate'); ?>
	<p>Wczytaj adres: </p><?php echo form_input('target_url','URL', array('maxlength'=>250));
	echo form_submit('Update','TargetUrl'); ?>
	</form>
	<br />
	<br />
	<?php if( ISSET($error)) echo $error;?>

	<?php echo form_open_multipart('moderator/do_upload');?>
		<input type="file" name="userfile" size="20" />
		<br /><br />
		<input type="submit" value="upload" />
	</form>
	
	<?php 
		echo form_open('moderator/clear');
		echo form_submit('clear', 'Usuñ puste tytu³y');
		echo form_close(); 
	?>
</div>
