<?php
/**
 * Template Name: EcoSystème
 */

get_header(); ?>

<main id="page" class="site-main homepage" role="main">
  <div id="anchor-0" class="section-post" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);">
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
  <div id="anchor-1" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_residents'); ?>);">
    <div class="container">
      <h2 class="left-full-border">Résidents</h2>
      <?php echo get_field("residents"); ?>
      <div class="clr"></div>
    </div>
  </div>
  <div id="anchor-2" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_hand_made'); ?>);">
    <div class="container">
      <h2 class="left-full-border">Hand Made ICI</h2>
      <?php echo get_field("hand_made"); ?>
      <div class="clr"></div>
    </div>
  </div>
  <div id="anchor-3" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_partenaires'); ?>);">
    <div class="container">
      <h2 class="left-full-border">Partenaires</h2>
      <?php echo get_field("partenaires"); ?>
      <div class="clr"></div>
    </div>
  </div>
</main>

<?php get_footer();
