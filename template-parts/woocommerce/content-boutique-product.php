
<?php
if(!$product){
  $product = $products->get_post();
}
?>


<?php if( isset($style) && $style=="compact" ){ ?>


  <div class="carousel-item compact">

    <div class="title-container">
      <p class="title">
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


<?php } else { ?>


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


<?php } ?>
