<?php
/*
Contenu d'une section d'abonnement
Ce template est appelé notamment dans archive-abonnement.php
*/
 ?>

<?php //L'id sert à identifier les section pour la navigation en timeline, le background sert à afficher l'image de fond ?>
<section id="item-<?php echo get_the_slug(); ?>" class=" perspective-corner	archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

	<div class="container">

		<?php //Contenu central de la section ?>
		<div class="archive-main">
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

		<?php // Sidebar de droite ?>
		<div class="archive-sidebar">
			
			<?php if (get_field("cost_per_month") && get_field("cost_per_month") != "") { ?>
			<div class="fa-container">
				<i class="fa fa-eur" aria-hidden="true"></i>
				<p>Coût mensuel :<br><?php echo get_field("cost_per_month"); ?></p>
			</div>
			<?php } ?>
			
			<?php if (get_field("cost_registration") && get_field("cost_registration") != "") { ?>
			<div class="cost_registration fa-container">
				<i class="fa fa-inscription" aria-hidden="true"></i>
				<p>Frais d'inscription :<br><?php echo get_field("cost_registration"); ?></p>
			</div>
			<?php } ?>
	
			<?php if (get_field("cost_registration") && get_field("cost_registration") != "") { ?>
			<div class="fa-container">
				<i class="fa fa-calendar" aria-hidden="true" style="font-size: 25px;"></i>
				<p>Durée minimale :<br><?php echo get_field("duration_min");	?> / Préavis <?php echo get_field("duration_preavis");	?></p>
			</div>
			<?php } ?>

			<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
			<?php echo get_field("mention_supplementaire"); ?>

			<?php
			if(get_field("form_code")){
				//Si l'abonnement est lié à un produit (comme l'abonnement à la carte) on affiche le lien vers ce produit
				if(get_field("is_product")){
					echo "<a class='btn btn-colored action-abonnement' href='".get_the_permalink(get_field("form_code"))."'>Je m'abonne</a>";
				} elseif (get_field("link")) {
					echo "<a class='btn btn-colored action-abonnement' href='".get_field("link")."'>Je m'abonne</a>";
				} else {
					//Sinon on appelle le shortcode du formulaire ajax
					echo do_shortcode("[form value=\"Je m'abonne\" class='btn btn-colored action-abonnement' action='abonnement_form' get='title=".get_the_title()."' param='".get_the_ID()."']");
				}
			}
			?>

		</div>

	</div>

</section>
