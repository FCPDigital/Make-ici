<?php get_header(); ?>

<main id="single" class="single site-main" role="main">
	<div class="landing">
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-sm-12"> 
					<h1 class="single__title left-full-border actu"><?php echo get_the_title(); ?></h1>
					<div class="actions">
						<?php do_action("back_button"); ?>
					</div>
		
					<div class="single-body">
						<?php if (get_the_post_thumbnail_url()){ ?>
							<div class="single__thumbnail-container">
								<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="single__thumbnail" alt="">
							</div>
						<?php } ?>
						
						<div class="single__content article">
							<?php the_content(); ?>
						</div>				
					</div>
					<?php dynamic_sidebar( 'widget-post' ); ?>
				</div>
			<?php endwhile; // End of the loop. ?>
		</div>
	</div>
</main>

<?php get_footer();
