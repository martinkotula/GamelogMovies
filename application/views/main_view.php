<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
	<meta http-equiv="Content-Language" content="pl" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/gl-theme/jquery-ui-1.7.2.custom.css" />
	<link rel="alternate" type="application/rss+xml" href="<?php echo base_url()?>feeds/rss.xml" title="Reviews" />
	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js'></script>
	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js'></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/moviesCorner.js" ></script>
	
	
	<title><?php echo $title ?></title>
</head>
<body id="<?php echo $body_id; ?>" >
<div id="container">
	<div id="header"><?php $this->load->view('header'); ?></div>
	<div id="nav"><?php $this->load->view('nav'); ?></div>
	<div id="content"><?php $this->load->view($view);?></div>
	<div id="footer"><?php $this->load->view('footer');?></div>
</div>

</body>
</html>
