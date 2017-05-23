<?php get_header(); ?>

<main id="abonnements-archive" class="site-main" role="main">
  <div class="landing">
    <div class="container left-border">
      <h1>Nos Abonnements</h1>
      <div class="archive-head flex">
        <?php  /* Start the Loop */
          while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/post/content-head', get_post_format() );
          endwhile;  ?>
      </div>
    </div>
  </div>
  <div class="body">
    <?php
    if ( have_posts() ) : ?>
      <?php
      /* Start the Loop */
      while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/post/content-abonnements', get_post_format() );

      endwhile;

      the_posts_pagination( array(
        'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
        'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>',
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
      ) );

    else :

      get_template_part( 'template-parts/post/content', 'none' );

    endif; ?>
  </div>

  <div class="timeline">
    <?php
    if ( have_posts() ) :  /* Start the Loop */
      while ( have_posts() ) : the_post(); ?>

      <a class="timeline-item" href="#item-<?php echo get_the_slug(); ?>">
        <?php echo get_the_title(); ?>
      </a>

      <?php endwhile;
    endif; ?>
  </div>

  <a href="#" class="scroll-manage" data-id=".item-scroll"></a>

</main>

<?php get_footer();
