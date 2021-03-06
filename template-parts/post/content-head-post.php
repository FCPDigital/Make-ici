
<div class="item item--animate <?php if($heightAuto) echo "item--height-auto"; ?> <?php echo $size; ?> <?php echo $class; ?>">
	<a class="item__link" href="<?php echo get_the_permalink($item) ?>">
		<div class="item__banner">
			<p class="item__title item__title--left"><?php echo truncate_content(get_the_title($item), 70); ?></p>
			<span class="item__corner item__mention item__mention--right">
				<?php if($date) { 
					$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
					$formatter->setPattern('E d M');
					echo $formatter->format($date);

					//echo $date->format("D j M"); 
				} else { 
					echo get_the_date('D. j M', $item);
				}; ?>	
			</span>
		</div>
		<div class="item__thumbnail">
			<img src="<?php echo get_the_post_thumbnail_url($item); ?>" alt="">
		</div>
		<div class="item__content">

			<?php 
			$truncValue = $size == 'item--wide' ? 300 : 100;
			if($limit) {
				$truncValue = $limit;
			}
			echo truncate_content(get_the_content($item), $truncValue, '...'); 
			?>

			<?php if ($callback) { ?>
				<a href="<?php echo $callback["url"] ?>" data-by-xhr class="btn btn-light item__callback"><?php echo $callback["content"] ?></a>
			<?php } ?>
		</div>
	</a>
</div>
