<?php
	/*
	Template d'une formation
	*/
	$product = get_post();
	$terms = get_the_terms( $product->id, 'product_cat' );
	$brand = get_the_terms( $product->id, 'product_brand' );
	$category = $terms[0]->name;
	$slug = $terms[0]->slug;

?>
<main id="single-product" class="site-main" role="main">
	<?php //Affiche le produit ?>
	<div class="body loop-archive" id="looper-snap">
		<div id="scroll-container">
			<?php include( locate_template('template-parts/woocommerce/content-product-formation.php') ); ?>
		</div>
	</div>
</main>


<?php get_footer();
