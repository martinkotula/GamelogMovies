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
			<li class="dropdown <?php if($activeLink == 'top') echo 'active' ?>"><?php echo anchor('reviews/top', '<span class="glyphicon glyphicon-star" ></span> Top <b class="caret"></b>', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown')) ?>
				<ul class="dropdown-menu">
					<li><?php echo anchor('reviews/top/films', 'Filmy') ?></li>
					<li><?php echo anchor('reviews/top/books', 'Książki') ?></li>
					<li><?php echo anchor('reviews/top/games', 'Gry') ?></li>
				</ul>
			</li>		          
        </li>
            <li class="<?php if($activeLink == 'films') echo 'active' ?>"><?php echo anchor('reviews/films', '<span class="glyphicon glyphicon-film" ></span> Filmy') ?></li>
			<li class="<?php if($activeLink == 'books') echo 'active' ?>"><?php echo anchor('reviews/books', '<span class="glyphicon glyphicon-book" ></span> Książki') ?></li>
			<li class="<?php if($activeLink == 'games') echo 'active' ?>"><?php echo anchor('reviews/games', '<div title="Code: 0xe803"><i class="icon-gamepad"></i>Gry</div>') ?></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="http://fsgk.pl" target="_blank" >FSGK</a></li>
			<li class="<?php if($activeLink == 'users') echo 'active' ?>"><?php echo anchor('users/display', 'Użytkownicy') ?></li>   
		</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>	