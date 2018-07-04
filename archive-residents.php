<?php get_header(); ?>


<main id="actus" class="site-main actus landing" role="main" style="background-image: url(http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/05/home-ici-montreuil.jpg);">
	<div class="wrapper container">
		<h1 class="left-full-border main-title">Nos résidents</h1>
		<div class="filter">
			<div class="filter__list">
				<select name="blog" data-filters='{"modifier": "hidden", "value": false, "order": 1}'>
					<option value="false">Tous</option>
					<option value="">ICI Montreuil</option>
					<option value="">ICI Marseille</option>
					<option value="">ICI TheCamp</option>
				</select>
				<select name="savoir_faire" data-filters='{"modifier": "hidden", "value": false, "order": 2}'>
					<option value="false">Tous</option>
					<option value="bois">Bois</option>
					<option value="metal">Métal</option>
					<option value="numeric">Numérique</option>
				</select>
			</div>
		</div>
		<div id="value" class="masonry">
			<?php 
			if ( function_exists( 'get_sites' )) {
				$original_blog_id = get_current_blog_id();
				$blog_list = get_sites( 0, 'all' );
				$residents = [];
				foreach ($blog_list AS $blog) {
					switch_to_blog( $blog["blog_id"] ); 
					$posts = get_posts(array(
						'post_type'  => 'residents',
						'posts_per_page'=> -1,
						'post_status'=>'publish'
					));
					array_merge($residents, $posts);
				}
				switch_to_blog( $original_blog_id );
			} else {
				$residents = get_posts(array(
					'post_type'  => 'residents',
					'posts_per_page'=> -1,
					'post_status'=>'publish'
				));
			}

			for($i=0; $i<count($residents); $i++){
				setup_postdata($residents[$i]);
				set_query_var( 'theme', "normal" );
				get_template_part( "template-parts/post/content-head-actu" );
			}
			?>
		</div>			
	</div>
</main>


<?php get_footer();

