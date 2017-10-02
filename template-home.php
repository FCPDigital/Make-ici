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
				<?php the_content($postCur); ?>
			</div>
		</div>
		<a class="scroll-btn" href="#anchor-2" data-scroll></a>
	</div>
	
	<div id="anchor-2" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_equipement', $postCur); ?>);">
		<div class="container">
			<h2 class="left-full-border">Equipements et services</h2>
			 <?php echo get_field("equipement", $postCur); ?>
			 <div class="single-body equipements-container">
			 	<?php 
				$equipements = get_posts( array('post_type' => 'equipements'));
				foreach($equipements as $equipement){ setup_postdata( $equipement ); ?>
					<div class="equipements-item" id="post-<?php echo get_the_ID($equipement); ?>">
						<div class="equipements-item-content">
							<div class="equipements-title-container">
								<p class="equipements-title"><?php echo get_the_title($equipement); ?></p>
							</div>
							<div class="equipements-content">
								<?php the_content() ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<a class="scroll-btn" href="#anchor-3" data-scroll></a>
		</div> 
	</div>
	<div id="anchor-3" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_last_posts', $postCur); ?>);">
		<div class="container">
			<h2 class="left-full-border">Prochaines formations</h2>
			<?php get_last_posts(); ?>
			<div class="clr"></div>
		</div>
	</div>
</main>

<?php endwhile; // End of the loop. ?>
<?php get_footer();?>
