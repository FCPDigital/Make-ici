<?php
/**
 * Template Name: Accueil - The Camp
 */

get_header(); ?>

<main id="page" class="site-main homepage" role="main">
	<div id="anchor-1" class="section-post" style="background-image: url(<?php echo get_field('bg_presentation'); ?>);">
		<div class="container">
			<h2 class="left-full-border">ICI thecamp - Présentation</h2>
			<div class="single-body">
				<?php echo get_field("presentation"); ?>
		</div>
		</div>
		<a class="scroll-btn" href="#anchor-2" data-scroll></a>
	</div>
	<div id="anchor-2" class="body loop-archive" id="looper-snap">
		<div id="scroll-container">
				<?php 
				$posts = new WP_Query(array(
					'post_type'=> 'abonnements',
					'limit' => 5,
					'order'=> "ASC"
				)); 
				while ( $posts->have_posts() ) : $posts->the_post(); 
					get_template_part( 'template-parts/post/content-abonnements-the-camp', get_post_format() );
				endwhile; 
				wp_reset_query(); 
				?>
			</div>
			</div>
		<a class="scroll-btn" href="#anchor-3" data-scroll></a>
	</div>
	<div id="anchor-3" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_equipement'); ?>);">
		<div class="container">
			<h2 class="left-full-border">Equipements</h2>
			<?php echo get_field("equipement"); ?>
		 		<div class="single-body equipements-container">
				<?php $posts = new WP_Query(array(
					'post_type'=> 'equipements',
					'limit' => 5,
					'order'=> "ASC"
				)); 
				while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<div class="equipements-item thecamp" id="post-<?php the_ID(); ?>">
						<div class="equipements-item-content">
							 <div class="equipements-title-container">
								<p class="equipements-title"><?php echo get_the_title();?></p></div>
							<div class="equipements-content"><?php the_content() ?></div>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
		<a class="scroll-btn" href="#anchor-4" data-scroll></a>
	</div>
	<div id="anchor-4" class="section-post map" >
		<?php echo do_shortcode(get_field("carte")); ?>
	</div>
</main>

<?php get_footer();
