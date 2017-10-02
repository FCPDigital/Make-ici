<?php
/*
Archive du custom-post abonnement.
*/
get_header(); ?>

<main id="abonnements-archive" class="site-main" role="main">
	<div class="landing">
		<div class="container">
			<h1 class="left-full-border">Abonnements</h1>


			<?php //Carousel
			$count = wp_count_posts('abonnements')->publish; ?>
			<div id="main-carousel" class="carousel <?php if($count > 4){echo 'active-control';} ?>">
				<div class="carousel-body">
					<div class="archive-head carousel-container">
						<?php	/* Start the Loop */
							while ( have_posts() ) : the_post();
								get_template_part( 'template-parts/post/content-head', get_post_format() );
								$count++;
							endwhile;	?>
					</div>
				</div>

				<div class="carousel-control">
					<p class="carousel-control-mention">Voir d'autres abonnements</p>
					<a href="#" class="carousel-control-btn" data-direction="left"></a>
					<a href="#" class="carousel-control-btn" data-direction="right"></a>
				</div>
			</div>

		</div>
	</div>

	<div class="body loop-archive" id="looper-snap">
		<div id="scroll-container">
			<?php
			//Parcours les abonnements
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/post/content-abonnements', get_post_format() );
			endwhile;
			the_posts_pagination( array(
				'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			));
			?>
		</div>
	</div>

	<?php //On reparcours les abonnements pour afficher la timeline ?>
	<div class="timeline hide-state">
		<?php
		if ( have_posts() ) :	/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>
			<a class="timeline-item" data-target="#item-<?php echo get_the_slug(); ?>" href="#item-<?php echo get_the_slug(); ?>">
				<?php echo get_the_title(); ?>
			</a>
			<?php endwhile;
		endif; ?>
		<span class="active-point"></span>
	</div>

</main>

<?php get_footer();
