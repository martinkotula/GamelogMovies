<div>
<a href="<?php echo base_url();?>"><h1 id="logo">GameLog - movies corner</h1></a>

</div>
<div id="search_box" >
	<?php echo form_open('search'); ?>
		<input type="text" class="text default-value" name="search" id="search" value="Szukaj" size="25" maxlength="100" />
		<input type="submit" id="search_button" class="submit button" name="submit" value="" />
	<?php echo form_close(); ?>
</div>
<a name="top" ></a>	
<a href="<?php echo base_url();?>feeds/rss.xml" class="rss" title="RSS"></a>