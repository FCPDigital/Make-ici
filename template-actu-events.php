<?php
/**
 * Template Name: Actualité / Events
 */

get_header(); ?>

<main id="page" class="site-main actu-events" role="main" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>)">
	<div class="wrapper container">
		<div class="flex-big main-part">
			<h1 class="main-title">Actualités</h1>
			
			<div class="items">
				<?php $actus = get_posts([ "limit" => 4 ]); 
				set_query_var("item", $actus[0]);
				set_query_var("size", "item--wide");
				get_template_part( 'template-parts/post/content', "head-post");
				?>

				<div class="item item--tall item--small item--border">
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
				get_template_part( 'template-parts/post/content', "head-post");
		
				set_query_var("item", $actus[2]);
				set_query_var("size", "item--small");
				get_template_part( 'template-parts/post/content', "head-post");
				
				set_query_var("item", $actus[3]);
				set_query_var("size", "item--wide");
				get_template_part( 'template-parts/post/content', "head-post");
				?>
				<div class="clr"></div>
			</div>

		</div>
		<div class="flex-small second-part">
			<h2 class="main-title">Evenements</h2>
			<div class="items">
				<div class="item item--border item--no-limit">
					<div class="item__banner item__banner--dark">
						<p class="item__title item__title--top-left">Prochains évènements</p>
					</div>
					<div class="item__content item__content--no-pad events">
						<div class="events-item">
							<p class="events-item__content">Ouverture du Restaurant d'ICI Montreuil Mardi 26 Janvier à 12h30</p>
							<div class="item__thumbnail">
								<img src="http://a.dilcdn.com/bl/wp-content/uploads/sites/6/2017/05/yoda-advice-always-in-motion-is-the-future.jpg" alt="">
							</div>
						</div>
						<div class="item__action">
							<a href="" class="btn btn--light">Tous les évenements</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php get_footer();
