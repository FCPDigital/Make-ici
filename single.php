<?php get_header(); ?>

<main id="single" class="site-main" role="main">
	<div class="landing">
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<h1 class="left-full-border actu"><?php echo get_the_title(); ?></h1>
				<div class="col-sm-8"> 
					<div class="single-body">
						<div class="actions">
							<a href="<?php wp_get_referer() ?>"> &lt; Retours</a>
						</div>
						<?php if(get_post_type(get_post()) == 'events') { ?>
							<p class="date-actu"><? the_field('date_event');?></p>
						<?php } else { ?>
							<p class="date-actu"><? echo get_the_date();?></p>
						<?php } ?>
						
						<?php the_content(); ?>
					</div>
				</div>
			<div class="col-sm-4 ">
				<div class="rest-img"><?php echo the_post_thumbnail('large');?></div>
				<?php dynamic_sidebar( 'below-post' ); ?>
			</div>
			<?php endwhile; // End of the loop. ?>
		</div>
	</div>
</main>

<?php get_footer();
