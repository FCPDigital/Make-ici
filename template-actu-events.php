<?php
/**
 * Template Name: Actualité / Events
 */

get_header(); ?>

<main id="actu-event" class="site-main actu-events landing" role="main" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>)">
	<div class="wrapper container">
		<div class="flex-big main-part">
			<h1 class="main-title">Actualités</h1>
			
			<div class="items">
				<?php $actus = get_posts([ "limit" => 4 ]); 
				set_query_var("item", $actus[0]);
				set_query_var("size", "item--wide");
				setup_postdata($actus[0]);
				get_template_part( 'template-parts/post/content', "head-post");
				?>

				<div class="item item--tall item--small item--border twitter-part">
					<div class="item__banner item__banner--dark">
						<p class="item__title item__title--top-left">Derniers tweets</p>
					</div>
					<div class="item__content">
						<div class="twitter-widget">
						<?php dynamic_sidebar( 'actue-event' ); ?>
						</div>
						<div class="item__action">
							<a href="twitter url" class="btn btn--light">Tous les tweets</a>
						</div>
					</div>
				</div>
				
				<?php 
				set_query_var("item", $actus[1]);
				set_query_var("size", "item--small");
				setup_postdata($actus[1]);
				get_template_part( 'template-parts/post/content', "head-post");
		
				set_query_var("item", $actus[2]);
				set_query_var("size", "item--small");
				setup_postdata($actus[2]);
				get_template_part( 'template-parts/post/content', "head-post");
				
				set_query_var("item", $actus[3]);
				set_query_var("size", "item--wide");
				setup_postdata($actus[3]);
				get_template_part( 'template-parts/post/content', "head-post");
				?>
				<div class="clr"></div>
			</div>

		</div>
		<div class="flex-small second-part">
			<h2 class="main-title">Evenements</h2>
			<div class="items">
				<div class="item item--border item--wide item--no-limit">
					<div class="item__banner item__banner--dark">
						<p class="item__title item__title--top-left">Prochains évènements</p>
					</div>
					<div class="item__content item__content--no-pad events">
						<?php $events = new WP_Query([ 
							"posts_per_page" => 4,
							"post_type" => "events"
						]); 
						while ( $events->have_posts() ) : $events->the_post(); ?>
						
						<div class="events-item">
							<a href="<?php echo get_the_permalink($item) ?>">
							<p class="events-item__content"><?php echo get_the_title(); ?><br><?php the_field("date_event"); ?></p>
							<div class="item__thumbnail">
								<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
							</div>
							</a>
						</div>

						<?php endwhile; ?>
						<div class="item__action">
							<a href="<?php echo get_post_type_archive_link('events'); ?>" title="Tous les évènements" class="btn btn--light">Tous les évenements</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="full-width center">
			<a class="btn btn--light" href="<?php echo get_category_link(get_cat_ID( 'Non classé' )); ?>">Tous les articles</a>
		</div>
	</div>
</main>

<?php get_footer();
