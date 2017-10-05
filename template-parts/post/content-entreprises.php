<?php
/*
Contenu d'une section entreprise
Ce template est appelé notamment dans archive-entreprises.php
*/
 ?>

 <?php //L'id sert à identifier les section pour la navigation en timeline, le background sert à afficher l'image de fond ?>
<section id="item-<?php echo get_the_slug(); ?>" class=" perspective-corner	archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

	<div class="container">
			<div class="archive-main row">

				<?php //Contenu principale de la section ?>
				<div class="col-sm-8">
					<div class="archive-main-head">
							<h2 class="title">
								<?php echo get_the_title(); ?>
							</h2>
							<h3>
								<?php echo get_field("subtitle"); ?>
							</h3>
					</div>
					<div class="archive-main-body">
						<?php the_content(); ?>
					</div>
				</div>

				<?php //Sidebar de droite ?>
				<div class="col-sm-4">
					<img src="<?php echo get_field('image'); ?>" alt="">
				</div>
				<div>
					<?php echo get_field('lien_') ?>
				</div>
			</div>
	</div>


</section>
