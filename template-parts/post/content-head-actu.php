

<div class="archive-head-item carousel-item">
  <div class="title-container">
    <p class="title"><?php echo get_the_title(); ?>  
    </p>
     <p class="subtitle">
       <? echo get_the_date();?>
    </p>
      

  </div>

  <?php if(has_post_thumbnail()) : ?>
    <div class="crop-img">
      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
    </div>
  <?php endif; ?>
   <p class="excerpt">
      <?php echo get_excerpt_truncate($product, 30); ?>
    </p>
  <a href="<?php the_permalink();?>" class="btn btn-light">Lire la suite</a>
</div>
