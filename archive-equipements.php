<?php
/*
Archive du custom-post equipements.
*/
get_header(); ?>

<main id="abonnements-archive" role="main">
	<div class="landing background background--mask" style='background-image: url("http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/10/ICIMontreuil_AtelierMe%CC%81tal.Soudure.jpg");'>
		<div class="container">
			<h1 class="left-full-border">Équipements et services</h1>
			<div class="margin-top-medium">
				<p>
					<strong>Dans nos 1.800m2,</strong> nous mettons à votre disposition <strong>des ateliers ultra équipés, des dizaines de machines professionnelles et d'outils électroportatifs.</strong> Des formations aux outils de conception et de fabrication sont organisées chaque semaine pour vous permettre d'acquérir de nouvelles compétences pour développer votre créativité et votre activité.
				</p>
			</div>
			<div id="main-carousel">
				<div class="">
					<div class="archive-head classic-list">
						<div class="archive-head flex-wrap-container flex-start">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="archive-head-item carousel-item flex-row-3-item">
									<a href="#item-<?php echo get_the_slug(); ?>" data-scroll data-target="#item-<?php echo get_the_slug(); ?>" >
										<div class="title-container">
											<p class="title"><?php echo get_the_title() ?></p>
										</div>
									</a>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="body loop-archive">
		<div>
			<?php
			//Parcours les abonnements
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/post/content-archive-item', get_post_format() );
			endwhile;
			the_posts_pagination( array(
				'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			));
			?>
		</div>
	</div>

	<?php //On reparcours les abonnements pour afficher la timeline ?>
	<div class="timeline hide-state">
		<?php
		if ( have_posts() ) :	/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>
			<a class="timeline-item" data-target="#item-<?php echo get_the_slug(); ?>" href="#item-<?php echo get_the_slug(); ?>">
				<?php echo get_the_title(); ?>
			</a>
			<?php endwhile;
		endif; ?>
		<span class="active-point"></span>
	</div>

</main>

<?php get_footer();
