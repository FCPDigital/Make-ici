	<?php /*
	Ce template est appelé juste pour les derniers produits afficher.
	il est utiliser dans la fonction :
	last_posts() dans functions.php
	*/ ?>

	<div class="carousel-item">
		<?php if(has_post_thumbnail($product)) : ?>
			<div class="crop-img">
				<img src="<?php echo get_the_post_thumbnail_url($product); ?>" alt="">
			</div>
		<?php endif; ?>
		<p class="title">
			<?php echo get_the_title($product); ?>
		</p>
		<p class="excerpt">
			<?php echo get_excerpt_truncate($product, 30); ?>
		</p>
		<a href="<?php echo get_permalink($product); ?>" data-by-xhr class="btn btn-light">En savoir plus</a>
	</div>
