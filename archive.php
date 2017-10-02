<?php get_header(); ?>

<main id="archive" class="site-main" role="main">
	<div class="landing">
		<div class="container">
			<h1 class="left-full-border"><?php echo single_cat_title(); ?></h1>

			<?php $count = $GLOBALS['wp_query']->post_count; ?>
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
</main>

<?php get_footer();
