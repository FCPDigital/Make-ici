<?php get_header(); ?>

<main id="single" class="site-main" role="main">
  <div class="landing">
    <div class="container left-border">
      <h1><?php echo get_the_title(); ?></h1>
			<div class="single-body">
				<?php echo get_the_content(); ?>
			</div>
    </div>
  </div>
</main>

<?php get_footer();
