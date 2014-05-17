<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">	

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->    
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/gmc.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/animation.css"><!--[if IE 7]><link rel="stylesheet" href="<?php echo base_url()?>assets/css/gmc-ie7.css"><![endif]-->
	<style type="text/css">
	body {
  
  padding-bottom: 20px;
}
	</style>
	<title><?php echo $title ?></title>
</head>
<body id="<?php echo $body_id; ?>" >
<div id="nav"><?php $this->load->view('nav'); ?></div>
<div class="container">			      
	<?php $this->load->view($view);?>	
	<hr />
	<footer>
	<p>
		<?php echo safe_mailto('gamelgmovies@gmail.com', 'Kontakt') ?>
	</p>	
	
	</footer>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url()?>/assets/js/bootstrap.min.js"></script>
	
</body>
</html>
