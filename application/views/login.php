<div id="main_content">
<div id="login-form">
<?php
	echo form_open('login/validate');	
	echo form_input(array('name'=>'user_name','value'=>'User name', 'class'=>'default-value'));
	echo form_password(array('name'=>'user_password', 'value'=>'Password', 'class'=>'default-value'));
	echo form_submit('login', 'Log me in!');
	echo '<p class=\"error_message\">'. $error .'</p>';
	echo form_close();		
?>
</div>
</div>
