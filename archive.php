<?php get_header(); ?>

<main id="actus" class="site-main actus landing" role="main" style="background-image: url(http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/05/home-ici-montreuil.jpg);">
	<div class="wrapper container">
		<h1 class="left-full-border main-title">Evènements / Actu</h1>
		<div class="filter">
			<div class="filter__list">
				<button data-filter="actu,event,non-classe" class="filter__item filter__item--active">Tous</button>
				<button data-filter="actu" class="filter__item"><i class="ico-actu"></i>Actualités</button>
				<button data-filter="event" class="filter__item"><i class="ico-event"></i>Evènements</button>
			</div>
		</div>
		<div id="value" class="masonry">
			<?php $q = new WP_Query(array(
				'post_type'=>'post', 
				'post_status'=>'publish', 
				'posts_per_page'=>-1,
				'orderby' => 'date',
				'order' => 'DESC' 
			)); ?>
			<?php 
			if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post(); 			
				set_query_var( 'theme', "normal" );
				get_template_part( "template-parts/post/content-head-actu" );
			endwhile; else : ?>
				<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
			<?php endif; ?>
		</div>			
	</div>
</main>


<?php get_footer();
