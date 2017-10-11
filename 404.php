<?php get_header(); ?>


<main id="page404" role="main">
	<div class="landing background background--mask center" style="background-image:url(http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/05/home-ici-montreuil.jpg);">	 
	 	<div class="container-404 container">
	 		<p class="container-404__title">Erreur</p>
			<div class="code">
				<span class="code__letter">4</span>
				<img class="code__anim" src="<?php echo get_template_directory_uri().'/assets/images/circular-saw.png'; ?>" alt="">
				<span class="code__letter">4</span>
			</div>
			<p class="code__message">La page que vous recherchez n'existe pas.</p>
			<div class="center margin-top-medium">
				<a href="<?php 	echo get_site_url(); ?>" class="btn btn--light">Revenir à l'accueil</a>
			</div>
		</div>
	</div>
</main>

<?php get_footer();?>
