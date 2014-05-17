    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url() ?>">GameLog Movies Corner</a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;">
          <ul class="nav navbar-nav">
			<li><?php echo anchor('reviews/top', 'Top') ?></li>
            <li><?php echo anchor('reviews/films', '<div title="Code: 0xe802"><i class="icon-video"></i>Filmy</div>') ?></li>
			<li><?php echo anchor('reviews/books', '<div title="Code: 0xe804"><i class="icon-book"></i>Książki</div>') ?></li>
			<li><?php echo anchor('reviews/games', '<div title="Code: 0xe803"><i class="icon-gamepad"></i>Gry</div>') ?></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="http://fsgk.pl" target="_blank" >FSGK</a></li>
			<li><?php echo anchor('users/display', 'Użytkownicy') ?></li>   
		</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>	