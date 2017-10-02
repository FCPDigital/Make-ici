<?php
/*
Contenu d'une section correspondant à une categorie de formation
Affiche le nom du categorie et un carousel des produits y correspondant
*/
?>


<section id="item-<?php echo get_category_slug($category); ?>" class=" perspective-corner	archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_category_thumbnail($category); ?>')">
	<div class="container">
		<div class="archive-main">
			<div class="archive-main-head">
				<h2 class="title">
					<?php echo get_category_title($category); ?>
				</h2>
			</div>
			<div class="archive-main-body">
				<?php
				//Récupère les produit pour une categorie et les trie par leurs date
				$products = get_products_from_category($category);
				$count = $products->post_count;
				$products_sort = sort_by_date($products);
				//Si le compte est superieur à 3 on active les fleche de direction
				?>
				<div class="product-carousel carousel <?php if($count > 3){echo 'active-control';} ?>">
					<div class="carousel-body">
						<div class="archive-head carousel-container">
							<?php	/* Start the Loop */
							foreach ($products_sort as $product){
								//Inclue l'item de carousel
								include( locate_template('template-parts/woocommerce/content-boutique-product.php') );
							}
							?>
						</div>
					</div>
					<div class="carousel-control">
						<a href="#" class="carousel-control-btn" data-direction="left"></a>
						<a href="#" class="carousel-control-btn" data-direction="right"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
