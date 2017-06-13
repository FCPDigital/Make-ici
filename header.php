<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	</head>

	<body <?php body_class(); ?>>
		<header id="main-header" class="transparent">
			<nav id="navbar" class="navbar navbar-default navbar-fixed-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<i class="fa fa-bars" aria-hidden="true"></i>
						</button>
						<a class="navbar-brand" href="<?php bloginfo('url')?>"><?php display_website_logo(); ?></a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<?php /* Primary navigation */
						wp_nav_menu( array(
							'menu' => 'Header',
							'depth' => 2,
							'container' => false,
							'menu_class' => 'nav  navbar-nav',
							//Process nav menu using our custom nav walker
							'walker' => new wp_bootstrap_navwalker())
						);
						?>
					</div>
				</div>
			</nav>
			<!--<a href="#" id="newDevis" class="btn btn-light">Demande de devis</a>-->
	</header>
	<div id="popin" class="hide">
		<span class="close-popin">X</span>
		<div class="content-popin"></div>
	</div>
