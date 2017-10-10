<?php
/*
Template Name: Boutique
*/

get_header();
$categories = get_woocommerce_categories();

?>

<main id="boutique" class="site-main" role="main">
	<div class="landing">
		<div class="container">
			<h1 class="left-full-border">Formations</h1>
			<?php
			while ( have_posts() ) : the_post();
				the_content();
			endwhile; // End of the loop.
			?>

			<div id="main-carousel" class="">
				<div class="">
					<div class="archive-head classic-list">
						<?php for($i=0 ; $i< count($categories); $i++) { ?>
							<?php $category = $categories[$i]; ?>
							<div class="archive-head-item carousel-item">
								<div class="title-container">
									<p class="title"><?php echo get_category_title($category); ?></p>
								</div>
								<?php $thumbnail = get_category_thumbnail($category) ?>
								<?php if($thumbnail){ ?>
									<div class="crop-img">
										<img src="<?php echo $thumbnail; ?>" alt="">
									</div>
								<?php } ?>
								<a href="#item-<?php echo get_category_slug($category); ?>" data-scroll data-target="#item-<?php echo get_category_slug($category); ?>" class="btn btn-light">En savoir plus</a>
							</div>
						<?php } ?>
						<?php if (count($categories) % 4 == 3) { ?>
							<div class="archive-head-item carousel-item text-item">
								<div class="content">
									<p>
										Offrez une expérience unique dans nos ateliers équipés. Nos cartes cadeaux sont valables pour tous nos stages et formations bouton.
									</p>
								</div>
								<a href="<?php echo get_permalink(esc_attr( get_option('gift_card_id'))); ?>" class="btn btn-colored">Offres une carte cadeau</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="body loop-archive" id="looper-snap">
		<div id="scroll-container">
			<?php
			if ( count($categories) > 0 ) :
				/* Start the Loop */
				for ( $i=0; $i<count($categories); $i++ ) : $category=$categories[$i];

					include( locate_template('template-parts/woocommerce/content-boutique.php') );
				endfor;
			else:
				get_template_part( 'template-parts/post/content', 'none' );
			endif; ?>
		</div>

	</div>

	<div class="timeline hide-state">
		<?php
		if ( count($categories) > 0 ) :
			/* Start the Loop */
			for ( $i=0; $i<count($categories); $i++ ) :	$category = $categories[$i] ?>

			<a class="timeline-item" data-target="#item-<?php echo get_category_slug($category); ?>" href="#item-<?php echo get_category_slug($category); ?>">
				<?php echo get_category_title($category); ?>
			</a>

		<?php
		endfor;
		endif; ?>
		<span class="active-point"></span>
	</div>

</main>

<?php get_footer();
