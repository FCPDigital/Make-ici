<?php
/**
 * Template Name: Page formulaire
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<main id="single-product single-product-pro" class="site-main container-fluid" role="main">
	<!-- Landing -->
	<div class="row section background background--mask" style="background-image: url(<?php echo get_template_directory_uri().'/assets/images/bg-1.jpg' ?> ); ">
		<div class="container">
			<div class="row margin-bottom-small">
				<div class="col-sm-12">
					<h1 class="title margin-top-big bold text-center"><?php echo get_the_title(); ?></h1>
					<?php echo get_field("additionnal_bloc"); ?>
					<div class="text-center margin-top-big">
						<a href="#form-section" data-scroll class="btn btn-colored"><?php echo get_field("call_to_action_title"); ?></a>	
					</div>	
				</div>
			</div>
		</div>
	</div>
	
	<!-- Description -->
	<div class="row section background--white">
		<div class="container margin-bottom-big">
			<div class="row">
				<?php the_content(); ?>
			</div>
		</div>
	</div>

	<div id="form-section" class="row section background background--mask" style="background-image: url(<?php echo get_template_directory_uri().'/assets/images/bg-1.jpg' ?> ); ">
		<div class="center container">
			<h2 class="title bold text-center color-white margin-bottom-big"><?php echo get_field("title_formulaire") ?></h2>
			<?php echo do_shortcode(get_field("formulaire_shortcode")); ?>
		</div>
	</div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
