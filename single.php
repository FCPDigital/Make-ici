<?php get_header(); ?>

<main id="single" class="site-main" role="main">
	<div class="landing">
		<div class="container">
			<h1 class="left-full-border"><?php echo get_the_title(); ?></h1>
			<div class="single-body">
				<?php echo get_the_content(); ?>
			</div>
		</div>
	</div>
</main>

<?php get_footer();
