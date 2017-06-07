<?php
/**
 * Template Name: Visite guidée
 */

get_header(); ?>

<main id="visite" class="site-main" role="main">
  <div class="landing">
    <div class="container left-border">

      <div class="plan-container">
        <div class="stage" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/images/plan-opacity.png')">
        </div>
        <div class="stage" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/images/plan-opacity.png')">
        </div>
        <div class="stage" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/images/plan-opacity.png')">
          <div class="pointer" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/images/bg.png')"></div>
          <div class="pointer" data-label="Salon"></div>
          <div class="pointer" data-label="Pièce du turfu"></div>
          <div class="pointer" data-label="Autre pièce"></div>
          <div class="pointer" data-label="Toto"></div>
        </div>
        <div id="path" class="hide">
          <p>Test</p>
        </div>
      </div>

    </div>
  </div>
</main>

<?php get_footer();
