<?php
$config = [
	"content" => true,
	"btn-style" => true,
	"crop-image" => false
];
?>

<div class="masonry__item" data-filters-terms='{"savoirs_faires": <?php echo json_encode(array(get_field("savoirs_faires"))) ?>, "blog": <?php echo json_encode(array($infos["blog"]->blog_id)); ?>}'>
	<div class="actu__item">
		<span class="actu__item-ref"></span>
		<?php $url = $infos["thumbnail"] ? $infos["thumbnail"] : get_template_directory_uri()."/assets/images/bg-2.jpg"; ?>
		<div class="actu__item-thumbnail-container <?php if($config["crop-image"]) { ?>actu__item-thumbnail-container--crop<?php } ?>">
			<img class="actu__item-thumbnail" src="<?php echo  $url; ?>" alt="">
		</div>

		<div class="actu__item-content">
			<p class="actu__item-title"><?php echo get_the_title($post); ?></p>
			<p class="actu__item-excerpt">
				<?php echo $infos["excerpt"]  ?>
			</p>

			<div class="actu__item-actions">
				<a href="<?php echo $post_url; ?>" class="btn btn--light">Lire plus</a>
			</div>
		</div>
	</div>
</div>
