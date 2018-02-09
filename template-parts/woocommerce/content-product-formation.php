<?php
/*
Contenu d'une page formation. Appelé dans :
- product-default.php
*/
?>

<section id="item-<?php echo $slug; ?>" class=" perspective-corner	archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

		<div class="container">
			<div class="archive-main">

				<div class="archive-main-head">
					<h1 class="title">
						<?php echo get_the_title(); ?>
					</h1>
					<h2 class="subtitle">
						<?php echo $category; ?>
					</h2>
				</div>

				<div class="archive-main-body">
					<?php setup_postdata(get_post()); ?>
					<?php the_content(); ?>
				</div>
				<div class="actions">
					<a href="<?php echo get_site_url()."/formations/"; ?>#item-<?php echo $slug; ?>"> < Retours aux formations</a>
				</div>
			</div>

			<div class="archive-sidebar">
				<?php if( get_field("duration") ){ ?>
					<div class="cost_per_month fa-container">
						<i class="fa fa-clock-o" aria-hidden="true"></i>
						<p>Durée :<br><?php echo get_field("duration"); ?></p>
					</div>
				<?php }
				
				if (get_field("display-price-abo") != "oui") { ?>
				
				<div class="cost_max fa-container">
					<i class="fa fa-eur" aria-hidden="true"></i>
					<?php
					$price = (int) $product->get_price();
					$reduc = (float) esc_attr( get_option('reduction_promo'));
					if($reduc){
						$abonnePrice = round($price*$reduc);
					} else {
						$abonnePrice = $price;
					}
					?>
					<p>Tarif abonnés :<br><?php echo $abonnePrice; ?> € TTC</p>

				</div>
				<?php } ?>

				<div class="cost_sale fa-container">
					<i class="fa fa-eur" aria-hidden="true"></i>
					<p>Tarif non abonnées :<br><?php echo $product->get_price() ?> € TTC</p>
				</div>

				<?php if($brand) { ?>
					<div class="formator fa-container margin-bottom-small">
						<i class="fa fa-user" aria-hidden="true"></i>
						<p><strong>Le Formateur :</strong><br>
							<?php echo $brand[0]->description; ?></p>
					</div>
				<?php } ?>
				<?php
				//appelle de la fonction de woocommerce gérant l'affichage du panier et des variations
				do_action( 'woocommerce_single_product_summary' );

				// Affiche un lien vers la page produit des cartes cadeaux ?>
				<a href="<?php echo get_permalink(esc_attr( get_option('gift_card_id'))); ?>" class="btn btn-colored gift-card-link">Achetez une carte cadeau</a>
			</div>

			<?php // Si le produit à une categorie, on affiche un carousel des autres produits de la categorie.
			if($category){ ?>
				<div class="related_products">
					<p class="bold">Autres formations	<?php echo $category; ?></p>
					<?php do_shortcode("[carousel category='".$category."' except='".$product->ID."' style='compact' ]") ?>
				</div>
			<?php } ?>
		</div>
</section>
