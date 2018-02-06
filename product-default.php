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

	<?php //Affiche la timeline ?>
	<div class="timeline no-hide">
		<?php
		$categories = get_woocommerce_categories();
		if ( count($categories) > 0 ) :
			for ( $i=0; $i<count($categories); $i++ ) :	$tmp_category = $categories[$i] ?>
			<a class="timeline-item prevent-timeline-action" data-target="#item-<?php echo get_category_slug($tmp_category); ?>" href="<?php echo get_site_url()."/formations/"; ?>#item-<?php echo get_category_slug($tmp_category); ?>">
				<?php echo get_category_title($tmp_category); ?>
			</a>
		<?php
		endfor;
		endif; ?>
		<span class="active-point"></span>
	</div>
</main>


<?php get_footer();
