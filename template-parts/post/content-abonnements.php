<section id="item-<?php echo get_the_slug(); ?>" class=" perspective-corner  archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

  <div class="container">

    <div class="archive-main">

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

    <div class="archive-sidebar">

      <div class="cost_per_month">
        <i class="fa fa-eur" aria-hidden="true"></i>
        <p>Coût mensuel<br><?php echo get_field("cost_per_month"); ?></p>
      </div>

      <div class="cost_registration">
        <i class="fa fa-inscription" aria-hidden="true"></i>
        <p>Frais d'inscription<br><?php echo get_field("cost_registration"); ?></p>
      </div>

      <p class="mention">Durée minimale <?php echo get_field("duration_min");  ?> / Préavis <?php echo get_field("duration_preavis");  ?></p>
      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
      <?php echo get_field("mention_supplementaire"); ?>
      <?php if(get_field("form_code")){ ?>
        <?php echo do_shortcode("[form value=\"Je m'abonne\" class='btn btn-colored action-abonnement' action='abonnement_form' get='title=".get_the_title()."' param='".get_the_ID()."']"); ?>
      <?php } ?>

    </div>

  </div>

</section>
