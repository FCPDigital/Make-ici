<?php get_header(); ?>

<main id="archive" class="site-main" role="main">
		<div class="container">
			<?php 
			$title = single_cat_title( '', false );
			if ($title == "") $title = "Evenements";
			if ($title == "Non classé") $title = "Articles";
			 ?>
			<h1 class="main-title left-full-border"><?php echo $title ?></h1>
			<div class="items">
				<?php	/* Start the Loop */
				$count = 0;
				while ( have_posts() ) : the_post();
					set_query_var("item", get_post());
					$size = ($count % 5 == 0) ? 'item--wide' : 'item--small';
					set_query_var("size", $size);
					get_template_part( 'template-parts/post/content', "head-post" );
					$count++;
				endwhile;	?>
			</div>
			
		</div>
</main>

<?php get_footer();
