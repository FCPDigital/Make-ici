<?php
/**
 * Template Name: Accueil
 */

get_header();
while ( have_posts() ) : the_post();
$postCur = get_post(); // On stocke le post courant pour éviter le bug de la boucle get_last_posts() qui écrase le post_data principale.

?>


<main id="page" class="site-main homepage" role="main">

	<div class="landing" style="background-image:url(<?php echo get_field('bg_main', $postCur); ?>);">	 
	 <div class="container">
			<div class="landing-legend">
				<h2>ICI MONTREUIL</h2> est une manufacture collaborative et solidaire pour les artisans, artistes,<br> designers, startups et entrepreneurs du “Faire”
			</div>
		</div>
		<a id="scroll" href="#anchor-1" data-scroll>Découvrez ICI Montreuil</a>
	</div>
	<div id="anchor-1" class="section-post" style="background-image: url(<?php echo get_the_post_thumbnail_url($postCur); ?>);">
		<div class="container">
			<h1 class="left-full-border"><?php echo get_the_title(); ?></h1>
			<div class="single-body">
				<div class="flex-wrap-container margin-top-big">
					<?php the_content($postCur); ?>
				</div>
				<div class="center margin-top-big">
					<a href="" class="btn btn--light">ICI Montreuil en images</a>
				</div>
			</div>
		</div>

	<!-- <div class="scroll-btn">
	<span>Evenements à venir</span> -->
			<a class="scroll-btn scroll-btn--content" href="#anchor-2" data-scroll></a>
		<!-- </div> -->
		
	</div>
	
	<div id="anchor-2" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_equipement', $postCur); ?>);">
		<div class="container">
			<h2 class="left-full-border">Prochains évènements</h2>
			<?php last_posts(); ?>
			<div class="scroll-btn-container">
				<span class="scroll-btn__title">Les formations</span>
				<a class="scroll-btn" href="#anchor-3" data-scroll></a>
			</div>
			
		</div> 
	</div>
	<div id="anchor-3" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_last_posts', $postCur); ?>);">
		<div class="container">
			<h2 class="left-full-border">Prochaines formations</h2>
			<?php last_products(); ?>
			<div class="clr"></div>
		</div>
	</div>
</main>

<?php endwhile; // End of the loop. ?>
<?php get_footer();?>
