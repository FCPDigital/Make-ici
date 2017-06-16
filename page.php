<?php get_header(); ?>

<main id="page" class="site-main" role="main">
  <div class="landing" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
    <div class="container">
			<?php
			while ( have_posts() ) : the_post(); ?>
			<h1 class="left-full-border"><?php echo get_the_title(); ?></h1>
			<div class="single-body">
				<?php the_content(); ?>
			</div>

			<?php endwhile; // End of the loop.
			?>


    </div>
  </div>
</main>

<?php get_footer();
