
<div class="item <?php echo $size; ?> <?php echo $class; ?>">
	<a href="<?php echo get_the_permalink($item) ?>">
	<div class="item__banner">
		<p class="item__title item__title--top-left"><?php echo get_the_title($item); ?></p>
		<span class="item__corner item__corner--bottom-right"><?php echo get_the_date('D M j', $item); ?></span>
	</div>
	</a>
	<div class="item__thumbnail">
		<img src="<?php echo get_the_post_thumbnail_url($item); ?>" alt="">
	</div>
	<div class="item__content">

		<?php 
		$truncValue = $size == 'item--wide' ? 300 : 100;

		echo truncate_content(get_the_content($item), $truncValue); 
		?>
	</div>
</div>
