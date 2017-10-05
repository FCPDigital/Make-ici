<?php
/*
Contenu d'une section d'abonnement
Ce template est appelé notamment dans archive-abonnement.php
*/
 ?>

<?php //L'id sert à identifier les section pour la navigation en timeline, le background sert à afficher l'image de fond ?>
<section id="item-<?php echo get_the_slug(); ?>" class="archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

	<div class="container">

		<?php //Contenu central de la section ?>
		<div class="archive-main archive-main--fullsize">
			<div class="archive-main-head">
				<h2 class="title">
					<?php echo get_the_title(); ?>
				</h2>
				<h3>
					<?php echo get_field("subtitle"); ?>
				</h3>
			</div>
			<div class="archive-main-body flex-wrap-container flex-start">
				<?php the_content(); ?>
			</div>
		</div>

	</div>

</section>
