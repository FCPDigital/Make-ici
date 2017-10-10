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
    <a class="scroll-btn" href="#anchor-1" data-scroll></a>
  </div>
  <div id="anchor-1" class="section-post" style="background-image: url(<?php echo get_field('bg_residents'); ?>);">
    <div class="container">
		<h2 class="left-full-border margin-bottom-medium">La communauté ICI</h2>
      <?php echo get_field("residents"); ?>
      <div class="clr"></div>
    </div>
    <a class="scroll-btn" href="#anchor-2" data-scroll></a>
  </div>
  <div id="anchor-2" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_hand_made'); ?>);">
    <div class="container">
      <h2 class="left-full-border margin-bottom-medium">Hand Made ICI</h2>
      <?php echo get_field("hand_made"); ?>
      <div class="clr"></div>
    </div>
    <a class="scroll-btn" href="#anchor-3" data-scroll></a>
  </div>
  <div id="anchor-3" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_partenaires'); ?>);">
    <div class="container">
      <h2 class="left-full-border margin-bottom-medium">Partenaires</h2>
      <?php echo get_field("partenaires"); ?>
      <div class="clr"></div>
    </div>
  </div>
</main>

<?php get_footer();
