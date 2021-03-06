<?php
/*
Archive du custom-post entreprise.
*/
get_header(); ?>

<main id="entreprise-archive" role="main">
	<div class="landing background background--mask">
		<div class="container">
			<h1 class="left-full-border">Entreprise</h1>

			<?php $count = wp_count_posts('entreprises')->publish; ?>
			<div id="main-carousel" class="carousel <?php if($count > 4){echo 'active-control';} ?>">
				<div class="carousel-body">
					<div class="archive-head carousel-container">
						<?php	/* Start the Loop */
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/post/content-head', get_post_format() );
							$count++;
						endwhile; ?>
					</div>
				</div>

				<div class="carousel-control">
					<p class="carousel-control-mention">Voir plus</p>
					<a href="#" class="carousel-control-btn" data-direction="left"></a>
					<a href="#" class="carousel-control-btn" data-direction="right"></a>
				</div>
			</div>

		</div>
	</div>
	<div class="body loop-archive">
		<div>
			<?php
			if ( have_posts() ) : ?>
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content-entreprises', get_post_format() );

				endwhile;

				the_posts_pagination( array(
					'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>',
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
				) );

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif; ?>
		</div>

	</div>

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
