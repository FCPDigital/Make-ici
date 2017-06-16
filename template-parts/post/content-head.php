<div class="archive-head-item carousel-item">
  <div class="title-container">
    <p class="title">
      <?php echo get_the_title(); ?>
    </p>

    <p class="subtitle">
      <?php echo get_field("subtitle"); ?>
    </p>
  </div>


  <?php if(has_post_thumbnail()) : ?>
    <div class="crop-img">
      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
    </div>
  <?php endif; ?>

  <?php if (get_post_type() == "abonnements" || get_post_type() == "entreprises"): ?>
    <p class="excerpt">
      <?php echo get_the_excerpt(); ?>
    </p>
  <?php endif;  ?>

  <a href="#item-<?php echo get_the_slug(); ?>" data-scroll data-target="#item-<?php echo get_the_slug(); ?>" class="btn btn-light">En savoir plus</a>
</div>
