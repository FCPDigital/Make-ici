<?php
/*
Template d'un item de carousel affichant un produit
Le shortcode appelant ce template permet différent style :
- compact
- detail
Ce template est appelé dans les pages :
- woocommerce/single-product.php
- template-parts/woocommerce/content-boutique.php
*/
global $product;

// STYLE compact
if( isset($style) && $style=="compact" ){
	$product = get_post($product->ID); ?>

	<div class="carousel-item compact">
		<div class="title-container">
			<p class="title">
				<span class="upper bold"><?php echo get_field("formation_type", $product); ?></span><br>
				<?php echo get_the_title($product); ?>
			</p>
		</div>
		<?php if(has_post_thumbnail($product)) : ?>
			<div class="crop-img">
				<img src="<?php echo get_the_post_thumbnail_url($product); ?>" alt="">
			</div>
		<?php endif; ?>
		<a href="<?php echo get_permalink($product); ?>" data-by-xhr class="btn btn-light">En savoir plus</a>
	</div>


<?php // STYLE compact ?>
<?php } else { ?>


	<div class="carousel-item">
		<div class="title-container">
			<p class="title">
			<span class="upper bold"><?php echo get_field("formation_type", $product); ?></span><br>
			<?php echo get_the_title($product); ?>
		</p>
		</div>

		<?php if(has_post_thumbnail($product)) : ?>
			<div class="crop-img">
				<img src="<?php echo get_the_post_thumbnail_url($product); ?>" alt="">
			</div>
		<?php endif; ?>

		<p class="excerpt">
			<?php echo get_excerpt_truncate($product, 20); ?>
		</p>
		<p>
			<p><a href="<?php echo get_permalink($product); ?>" data-by-xhr class="center color-black block">En savoir plus</a></p>
		</p>
		
		<?php $countDate = count(get_all_dates($product)); ?>
		<?php $nextDate = get_next_date($product);
		if($nextDate){
			echo "<a href=\"".get_permalink($product)."\" data-by-xhr class=\"btn btn-light\">Inscription<br>Prochaine session le <br>".$nextDate->format("d/m/Y")."</a>";
		} 
		?>
	</div>

	
<?php } ?>
