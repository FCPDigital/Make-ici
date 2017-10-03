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

				<div class="item item--wide">
					<div class="item__banner">
						<p class="item__title item__title--top-left">Incubateur de Made in france</p>
						<span class="item__corner item__corner--bottom-right">20 juin 2017</span>
					</div>
					<div class="item__thumbnail">
						<img src="http://a.dilcdn.com/bl/wp-content/uploads/sites/6/2017/05/yoda-advice-always-in-motion-is-the-future.jpg" alt="">
					</div>
					<div class="item__content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus assumenda optio esse eaque rem veniam et nostrum, distinctio animi. Dolorum a atque distinctio molestiae pariatur neque inventore quod cum, reprehenderit!</p>
					</div>
				</div>

				<div class="item item--tall item--small item--border">
					<div class="item__banner item__banner--dark">
						<p class="item__title item__title--top-left">Derniers tweets</p>
					</div>
					<div class="item__content">
						<div class="twitter-widget">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident nam a, excepturi explicabo obcaecati saepe facilis? Atque error deserunt molestias quo quia animi recusandae. Fugit pariatur odio totam sunt maxime.
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis voluptates veniam qui aliquam, dolorem atque laborum laudantium blanditiis quisquam minus quas ea labore itaque illo iusto ipsam tenetur nostrum excepturi.
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim sapiente excepturi deleniti provident, ad quaerat commodi adipisci, consectetur beatae nesciunt perspiciatis odio dicta ipsam, facilis et vero! Magnam, distinctio saepe!
						</div>
						<div class="item__action">
							<a href="twitter url" class="btn btn--light">Tous les tweets</a>
						</div>
					</div>
				</div>
				
				<div class="item item--small">
					<div class="item__banner">
						<p class="item__title item__title--top-left">Incubateur de Made in france</p>
						<span class="item__corner item__corner--bottom-right">20 juin 2017</span>
					</div>
					<div class="item__thumbnail">
						<img src="http://a.dilcdn.com/bl/wp-content/uploads/sites/6/2017/05/yoda-advice-always-in-motion-is-the-future.jpg" alt="">
					</div>
					<div class="item__content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus assumenda </p>
					</div>
				</div>

				<div class="item item--small">
					<div class="item__banner">
						<p class="item__title item__title--top-left">Incubateur de Made in france</p>
						<span class="item__corner item__corner--bottom-right">20 juin 2017</span>
					</div>
					<div class="item__thumbnail">
						<img src="http://a.dilcdn.com/bl/wp-content/uploads/sites/6/2017/05/yoda-advice-always-in-motion-is-the-future.jpg" alt="">
					</div>
					<div class="item__content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus assumenda </p>
					</div>
				</div>

				<div class="item item--wide">
					<div class="item__banner">
						<p class="item__title item__title--top-left">Incubateur de Made in france</p>
						<span class="item__corner item__corner--bottom-right">20 juin 2017</span>
					</div>
					<div class="item__thumbnail">
						<img src="http://a.dilcdn.com/bl/wp-content/uploads/sites/6/2017/05/yoda-advice-always-in-motion-is-the-future.jpg" alt="">
					</div>
					<div class="item__content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus assumenda optio esse eaque rem veniam et nostrum, distinctio animi. Dolorum a atque distinctio molestiae pariatur neque inventore quod cum, reprehenderit!</p>
					</div>
				</div>
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
