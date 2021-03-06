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

				<div class="archive-main-body article">
					<?php setup_postdata(get_post()); ?>
					<?php the_content(); ?>
				</div>
				<div class="actions">
					<a href="<?php echo get_permalink( get_page_by_title("Formations") ) ?>#item-<?php echo $slug; ?>"> < Retours aux formations</a>
				</div>
			</div>

			<div class="archive-sidebar">
				<?php if( get_field("duration") ){ ?>
					<div class="cost_per_month fa-container">
						<i class="fa fa-clock-o" aria-hidden="true"></i>
						<p>Durée :<br><?php echo get_field("duration"); ?></p>
					</div>
				<?php } ?>

				<?php if($brand) { ?>
					<div class="formator fa-container margin-bottom-small">
						<i class="fa fa-user" aria-hidden="true"></i>
						<p><strong>Le Formateur :</strong><br>
							<?php echo $brand[0]->description; ?></p>
					</div>
					<style type="text/css">
					#single-product .loop-archive .single_add_to_cart_button {display:none;}
					#single-product .loop-archive .single_variation_wrap {padding: 0px;}
					.woocommerce-variation.single_variation p {display:none;}
					</style>
				<?php } ?>
				<?php
				//appelle de la fonction de woocommerce gérant l'affichage du panier et des variations
				// do_action( 'woocommerce_single_product_summary' );

				echo do_shortcode(get_field("short_code_formulaire"));

				if( get_field("gift_card_active") ) {
					// Affiche un lien vers la page produit des cartes cadeaux ?>
					<a href="<?php echo get_permalink(esc_attr( get_option('gift_card_id'))); ?>" class="btn btn-colored gift-card-link">Achetez une carte cadeau</a>

				<?php } ?>

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
