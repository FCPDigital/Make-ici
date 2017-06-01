<section id="item-<?php echo get_category_slug($category); ?>" class=" perspective-corner  archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_category_thumbnail($category); ?>')">
  <div class="container">
    <div class="archive-main">
      <div class="archive-main-head">
        <h2 class="title">
          <?php echo get_category_title($category); ?>
        </h2>
      </div>
      <div class="archive-main-body">
        <?php $products = get_products_from_category($category);
        $count = $products->post_count;?>
        <div class="product-carousel carousel <?php if($count > 4){echo 'active-control';} ?>">
          <div class="carousel-body">
            <div class="archive-head carousel-container">
              <?php  /* Start the Loop */
                while ( $products->have_posts() ) :  $products->the_post();
                  include( locate_template('template-parts/woocommerce/content-boutique-product.php') );
                  $count++;
                endwhile;  ?>
            </div>
          </div>
          <div class="carousel-control">
            <p class="carousel-control-mention">Voir d'autres abonnements</p>
            <a href="#" class="carousel-control-btn" data-direction="left"></a>
            <a href="#" class="carousel-control-btn" data-direction="right"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>