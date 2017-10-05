<?php
/*
Contenu d'un produit simple : ex carte cadeau ou abonnement à la carte.
Appelé dans :
- product-other.php
*/
?>
<section id="item-<?php echo $slug; ?>" class=" perspective-corner	archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

		<div class="container">
			<div class="archive-main">

				<div class="archive-main-head">
					<h2 class="title">
						<?php echo get_the_title(); ?>
					</h2>
					<h3>
						<?php echo $category; ?>
					</h3>
				</div>

				<div class="archive-main-body">
					<?php setup_postdata(get_post()); ?>
					<?php the_content(); ?>
				</div>
			</div>

			<div class="archive-sidebar">

				<div class="cost_max fa-container">
					<i class="fa fa-eur" aria-hidden="true"></i>
					<p><?php echo $product->get_price_html() ?></p>
				</div>

				<?php if($brand) { ?>
			<!-- 		<div class="formator fa-container margin-bottom-small">
				<i class="fa fa-user" aria-hidden="true"></i>
				<p><strong>Le Formateur :</strong><br>
					<?php echo $brand[0]->description; ?></p>
			</div> -->
				<?php } ?>

				<?php
				//appelle de la fonction de woocommerce gérant l'affichage du panier et des variations
				do_action( 'woocommerce_single_product_summary' );
				?>
			</div>


		</div>
</section>
