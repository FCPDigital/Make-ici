
<?php
global $product;
?>

<?php if( isset($style) && $style=="compact" ){ ?>

  <?php
  $product = get_post($product->ID);
  ?>

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
      <?php echo get_excerpt_truncate($product, 20); ?>
      <br><a href="<?php echo get_permalink($product) ?>">En savoir plus</a>
    </p>
    <?php
    $nextDate = get_next_date($product);
    if($nextDate){
      echo "<a href=\"".get_permalink($product)."\" data-by-xhr class=\"btn btn-colored\">Prochaine session le <br>".$nextDate->format("d/m/Y")."</a>";
    } else {
      echo "<p class='no-date'>Pas de session à venir.</p>";
    }
     ?>
  </div>


<?php } ?>
