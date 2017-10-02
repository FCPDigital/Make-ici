<?php get_header(); ?>

<main id="single" class="site-main" role="main">
	<div class="landing">
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<h1 class="left-full-border actu"><?php echo get_the_title(); ?></h1>
				<div class="col-sm-8"> 
					<div class="single-body">
						<div class="actions">
							<a href="http://makeici.org/icimontreuil/category/event-act/"> &lt; Retours</a>
						</div>
						<p class="date-actu"><? echo get_the_date();?></p>
						<?php the_content(); ?>
					</div>
				</div>
			<div class="col-sm-4 ">
				<div class="rest-img"><?php echo the_post_thumbnail('large');?></div>
			</div>
			<?php endwhile; // End of the loop. ?>
		</div>
	</div>
</main>

<?php get_footer();
