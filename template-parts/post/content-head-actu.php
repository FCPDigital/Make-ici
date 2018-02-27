<?php 

if( $theme == "pagination" ){
	$config = [
		"content" => false,
		"btn-style" => false,
		"crop-image" => true
	]; 
} else {
	$config = [
		"content" => true,
		"btn-style" => true,
		"crop-image" => false
	]; 
}


$cat = get_the_category()[0]->category_nicename;
	if($cat == "non-classe") { $cat = "actu"; }

	$date = get_the_date("U");
	if(get_field("date_event")){
		$date = get_field("date_event");
	}
?>

<div class="masonry__item" data-filter-ref="<?php echo $cat; ?>" data-date="<?php echo $date; ?>">
	<div class="actu__item">
		<span class="actu__item-ref actu__item-ref--<?php echo $cat ?>"></span>
		<?php $url = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri()."/assets/images/bg-2.jpg"; ?>
		<div class="actu__item-thumbnail-container <?php if($config["crop-image"]) { ?>actu__item-thumbnail-container--crop<?php } ?>">
			<img class="actu__item-thumbnail" src="<?php echo  $url; ?>" alt="">	
		</div>
		
		<div class="actu__item-content">
			<p class="actu__item-title"><?php echo get_the_title(); ?></p>
			<?php if($config["content"] == true) { ?>
				<p class="actu__item-excerpt">
					<?php echo get_excerpt_truncate(get_post(), 20); ?>
				</p>
			<?php } ?>
			

			<div class="actu__item-actions">
				<?php if($config["btn-style"] == true) { ?>
					<a href="<?php echo get_post_permalink(get_post()) ?>" class="btn btn--light">Lire plus</a>
				<?php } else { ?>
					<a href="<?php echo get_post_permalink(get_post()) ?>" class="inline-block">Lire plus</a>
				<?php } ?>
			</div>
			<?php if (get_field("date_event")) { ?>
				<div class="actu__info">
					<p><?php echo get_field("date_event"); ?></p>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
