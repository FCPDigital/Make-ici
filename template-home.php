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
				<h2 class="size-extra margin-bottom-medium"><?php echo strtoupper(get_bloginfo("name")); ?></h2> 
				<?php echo get_bloginfo("description"); ?>
			</div>
			<div class="center margin-top-medium">
				<a href='<?php echo get_permalink(get_page_by_title("Visite Guidée")) ?>' class="btn btn--light">Visiter ICI Montreuil</a>
			</div>
		</div>
		<a id="scroll" href="#anchor-1" data-scroll>Découvrez <?php echo get_bloginfo("name"); ?></a>
	</div>
	<div id="anchor-1" class="section-post" style="background-image: url(<?php echo get_the_post_thumbnail_url($postCur); ?>);">
		<div class="container">
			<h1 class="left-full-border"><?php echo get_the_title(); ?></h1>
			<div class="single-body">
				<div class="flex-wrap-container margin-top-big">
					<?php the_content($postCur); ?>
				</div>
				<div class="center margin-top-big">
					<a href="https://www.instagram.com/icimontreuil" class="btn btn--light"><i class="fa fa-instagram btn__fa" aria-hidden="true"></i><?php echo get_bloginfo("name"); ?> en images</a>
				</div>
			</div>
			<div class="scroll-btn-container margin-top-medium">
				<span class="scroll-btn__title">L'actualité</span>
				<a class="scroll-btn" href="#anchor-2" data-scroll></a>
			</div>
		</div>	
	</div>
	
	<div id="anchor-2" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_equipement', $postCur); ?>);">
		<div class="container">
			<h2 class="left-full-border">L'actualité</h2>
			<?php last_posts(); ?>
			<div class="scroll-btn-container">
				<span class="scroll-btn__title">Prochaines formations</span>
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
