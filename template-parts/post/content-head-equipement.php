<?php /*

Correspond à un des carré situé en entête de page.
Ce template est appelé pour les fichiers :
- archive.php
- archive-abonnement.php
- archive-entreprises.php

On retrouve un comportement analogue dans woocommerce/template-product.php
*/ ?>
<div class="archive-head-item carousel-item">
  <div class="title-container">
    <p class="title">
      <?php echo get_the_title(); ?>
    </p>

    <p class="subtitle">
      <?php echo get_field("subtitle"); ?>
    </p>
  </div>


  <?php if (get_post_type() == "abonnements"): ?>
    <p class="excerpt">
      <?php echo get_the_excerpt(); ?>
    </p>
  <?php endif;  ?>

  <?php //Le href correspond à l'id des section utiliser pour la timeline, data-scroll spécifie que la transition sera en scroll  ?>
  <a href="#item-<?php echo get_the_slug(); ?>" data-scroll data-target="#item-<?php echo get_the_slug(); ?>" class="btn btn-light">En savoir plus</a>
</div>
