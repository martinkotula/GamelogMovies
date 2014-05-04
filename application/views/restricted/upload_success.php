<div id="main_content">
<h3>Your file was successfully uploaded!</h3>
 
<?php if( isset($error)) :?>
	<p><?php echo $error; ?></p>
<?php endif ?>
<ul>
<?php foreach($movies as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
<ul>
<?php foreach($reviews as $item => $value):?>

<li><?php echo $item;?>: <?php echo $value[0];?><br /><?php echo $value[1]; ?> <br /></li>
<?php endforeach; ?>
</ul>
<p>Wczytano <?php echo $parsed_reviews_count; ?></p> 
<p><?php echo anchor('update', 'Upload Another File!'); ?></p>
</div>
