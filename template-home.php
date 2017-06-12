<?php
/**
 * Template Name: Accueil
 */

get_header(); ?>

<main id="page" class="site-main homepage" role="main">
  <div class="landing">

  </div>
  <div class="section-post" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
    <div class="container">
			<?php
			while ( have_posts() ) : the_post(); ?>
			<h1 class="left-full-border"><?php echo get_the_title(); ?></h1>
			<div class="single-body">
				<?php the_content(); ?>
			</div>
			<?php endwhile; // End of the loop. ?>
    </div>
  </div>
  <div class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_last_posts'); ?>);">
    <div class="container">
      <h2 class="left-full-border">Prochaines formations</h2>
      <?php get_last_posts(); ?>
      <div class="clr"></div>
    </div>
  </div>
  <div class="section-post equipements" style="background-image:url(<?php echo get_field('bg_equipement'); ?>);">
    <div class="container">
      <h2 class="left-full-border">Équipements</h2>
      <div class="center">
        <?php echo get_field("equipement"); ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer();
