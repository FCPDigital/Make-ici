<?php
/**
 * Template Name: MakeIci Homepage
 */

get_header(); ?>

<main id="page" class="site-main homepage make-ici-homepage" role="main">
	<div id="anchor-0" class="landing" style="background-image:url(<?php echo get_field('bg_main'); ?>);">
		<video muted loop autoplay poster="images/bg.png" id="bgvid">
			<source src="<?php echo get_template_directory_uri() ?>/assets/videos/bg.mp4" type="video/mp4">
		</video>
		<div class="container">
			<h3 class="landing-legend"><strong>Make ICI </strong> <br>est le premier réseau de manufactures<br> collaboratives et solidaires pour les artisans, artistes,<br> designers, startups et entrepreneurs du '<strong>FAIRE</strong>'</h3>
			<?php
			wp_nav_menu( array(
				'menu' => 'ici_sites',
				'depth' => 2,
				'container' => false,
				'menu_class' => 'nav  navbar-nav',
				'walker' => new wp_bootstrap_navwalker()
			));
			?>
		</div>
		<a id="scroll" href="#anchor-1" data-scroll>Détails</a>
	</div>
	<div id="anchor-1" class="section-post" style="background-image: url(<?php echo get_field('bg_presentation'); ?>);">
		<div class="container">
			<h2 class="left-full-border">Make ICI en quelques mots</h1>
			<div class="single-body">
				<?php echo get_field("presentation"); ?>
			</div>
		</div>
		
		<a class="scroll-btn" href="#anchor-2" data-scroll></a>
	</div>
	<div id="anchor-2" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_mission'); ?>);">
		<div class="container">
			<h2 class="left-full-border">Make ICI - Mission</h2>
			<div class="single-body">
				<?php echo get_field("mission"); ?>
			</div>
		</div>
		<a class="scroll-btn" href="#anchor-3" data-scroll></a>
	</div>
	<div id="anchor-3" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_chiffres'); ?>);">
		<div class="container">
			<h2 class="left-full-border">Make ICI en chiffres</h2>
			<div class="single-body">
				<?php echo get_field("chiffres"); ?>
			</div>
		</div>
		<a class="scroll-btn" href="#anchor-4" data-scroll></a>
	</div>
	<div id="anchor-4" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_staff'); ?>);">
		<div class="container">
			<h2 class="left-full-border">Make ICI - Staff</h2>
			<div class="single-body staff-container">
				<?php $posts = new WP_Query(array(
					'post_type'=> 'staff',
					'limit' => 5,
					'order'=> "ASC"
				)); ?>
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<div class="staff-item" id="post-<?php the_ID(); ?>">
						<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
						<div class="staff-item-content">
							<h3><?php echo get_the_title(); ?></h3>
							<p><?php the_content() ?></p>
							<a href="#"  data-getarg="contact=<?php echo get_field('e-mail'); ?>" data-wpxhr="contact_form" data-xhrarg="<?php echo get_the_ID(); ?>" class="btn btn-colored action-abonnement">Contactez le(a)</a>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
		<a class="scroll-btn" href="#anchor-5" data-scroll></a>
	</div>

	<div id="anchor-5" class="section-post map" >
		<?php echo do_shortcode(get_field("carte")); ?>
	</div>
</main>


<?php get_footer();
