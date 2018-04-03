<?php get_header(); ?>

<main id="single" class="single site-main" role="main">
	<div class="landing">
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-sm-12"> 
					<h1 class="single__title left-full-border actu"><?php echo get_the_title(); ?></h1>
					<div class="actions">
						<?php do_action("back_button"); ?>
					</div>
					<?php 
					$cat = get_the_category()[0]; 
					if($cat->category_nicename == "non-classe") {
						$catTitle = "Actualités";
					} else {
						$catTitle = $cat->cat_name;
					}

					$date = get_the_date("d.m.Y");
					?>
				
					<div class="single-body">
						<div class="row single__top">
							<div class="col-sm-8">
								<h2 class="single__subtitle"><?php echo $catTitle; ?></h2>	
							</div>
							<div class="col-sm-4">
								<?php if(get_post_type(get_post()) == 'events') { ?>
									<p  class="single__date"><?php the_field('date_event');?></p>
								<?php } else { ?>
									<p  class="single__date"><?php echo $date; ?></p>
								<?php } ?>
							</div>
						</div>
						
						<?php if (get_the_post_thumbnail_url()){ ?>
							<div class="single__thumbnail-container">
								<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="single__thumbnail" alt="">
							</div>
						<?php } ?>
						
						<div class="single__content">
							<?php the_content(); ?>
						</div>
						
					</div>
					<?php dynamic_sidebar( 'widget-post' ); ?>

				</div>


			<?php
			$next_post = get_next_post();
			$previous_post = get_previous_post();
			?>
			<div class="row col-sm-12 single__pagination">
				<?php if (!empty( $previous_post )): $post = $previous_post; setup_postdata($post) ?>
				<div class="col-xs-6 single__pagination-left">
					<a class="single__pagination-link" href="<?php echo get_permalink() ?>">< Article Précédent</a>
					<?php set_query_var( 'theme', "pagination" ); ?>
					<div class="hidden-sm-down">
						<?php get_template_part( "template-parts/post/content-head-actu" ); ?>
					</div>
				</div>
				<?php else: ?><div class="col-sm-6"></div><?php endif; ?>

				<?php if (!empty( $next_post )):  $post = $next_post; setup_postdata($post) ?>
				<div class="col-xs-6 single__pagination-right">
					<a class="single__pagination-link" href="<?php echo get_permalink() ?>">Article Suivant ></a>
					<?php set_query_var( 'theme', "pagination" ); ?>
					<div class="hidden-sm-down">
						<?php get_template_part( "template-parts/post/content-head-actu" ); ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
	
			<?php endwhile; // End of the loop. ?>
		</div>
	</div>
</main>

<?php get_footer();
