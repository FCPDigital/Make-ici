<?php
/*
Template Name: Boutique
*/

get_header();
$categories = get_woocommerce_categories();

?>

<main id="boutique" class="site-main" role="main">
  <div class="landing">
    <div class="container left-border">
      <h1>Formations</h1>
      <?php
      while ( have_posts() ) : the_post();
        the_content();
      endwhile; // End of the loop.
      ?>

      <div id="main-carousel" class="">
        <div class="">
          <div class="archive-head classic-list">
            <?php for($i=0 ; $i< count($categories); $i++) { ?>
              <?php $category = $categories[$i]; ?>
              <div class="archive-head-item carousel-item">
                <div class="title-container">
                  <p class="title"><?php echo get_category_title($category); ?></p>
                </div>
                <?php $thumbnail = get_category_thumbnail($category) ?>
                <?php if($thumbnail){ ?>
                  <div class="crop-img">
                    <img src="<?php echo $thumbnail; ?>" alt="">
                  </div>
                <?php } ?>
                <a href="#item-<?php echo get_category_slug($category); ?>" data-scroll data-target="#item-<?php echo get_category_slug($category); ?>" class="btn btn-light">En savoir plus</a>
              </div>
            <?php } ?>
            <?php if (count($categories) % 4 == 3) { ?>
              <div class="archive-head-item carousel-item text-item">
                <div class="content">
                  <p>
                    Tous les jeudis, visite de nos ateliers, rencontre avec le staff et les résidents
                  </p>
                </div>
                <a href="#" data-wpxhr="visite_form" data-xhrarg="<?php echo get_the_ID(); ?>" class="btn btn-colored action-abonnement">Inscrivez vous</a>
              </div>
            <?php } ?>
          </div>
        </div>

      </div>

    </div>
  </div>
  <div class="body loop-archive" id="looper-snap">
    <div id="scroll-container">
      <?php
      if ( count($categories) > 0 ) :
        /* Start the Loop */
        for ( $i=0; $i<count($categories); $i++ ) : $category=$categories[$i];

          include( locate_template('template-parts/woocommerce/content-boutique.php') );
        endfor;
      else:
        get_template_part( 'template-parts/post/content', 'none' );
      endif; ?>
    </div>

  </div>

  <div class="timeline hide-state">
    <?php
    if ( count($categories) > 0 ) :
      /* Start the Loop */
      for ( $i=0; $i<count($categories); $i++ ) :  $category = $categories[$i] ?>

      <a class="timeline-item" data-target="#item-<?php echo get_category_slug($category); ?>" href="#item-<?php echo get_category_slug($category); ?>">
        <?php echo get_category_title($category); ?>
      </a>

    <?php
    endfor;
    endif; ?>
    <span class="active-point"></span>
  </div>

</main>

<?php get_footer();
