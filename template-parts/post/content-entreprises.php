<section id="item-<?php echo get_the_slug(); ?>" class=" perspective-corner  archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

  <div class="container">
      <div class="archive-main row">
        <div class="col-sm-8">
          <div class="archive-main-head">
              <h2 class="title">
                <?php echo get_the_title(); ?>
              </h2>
              <h3>
                <?php echo get_field("subtitle"); ?>
              </h3>
          </div>
          <div class="archive-main-body">
            <?php the_content(); ?>
          </div>
        </div>
        <div class="col-sm-4">
          <img src="<?php echo get_field('image'); ?>" alt="">
        </div>
      </div>
  </div>


</section>
