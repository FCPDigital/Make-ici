<?php get_header(); ?>


<main id="actus" class="site-main actus landing" role="main" style="background-image: url(http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/05/home-ici-montreuil.jpg);">
	<div id="residents-filter" class="wrapper container">
		<h1 class="bold text-center margin-bottom-medium">Nos résidents</h1>
		<div class="filter">
			<div class="filter__list text-center margin-bottom-big">
				<select class="select select--light" name="blog" data-filters='{"modifier": "hidden", "value": false, "order": 1}'>
					<option value="false">Tous</option>
					<option value="">ICI Montreuil</option>
					<option value="">ICI Marseille</option>
					<option value="">ICI TheCamp</option>
				</select>
				<select class="select select--light" name="savoirs_faires" data-filters='{"modifier": "hidden", "value": false, "order": 2}'>
					<option value="false">Tous</option>
					<option value="bois">Bois</option>
					<option value="metal">Métal</option>
					<option value="numeric">Numérique</option>
				</select>
			</div>
		</div>
		<div id="masonry-resident">
			<?php
			if ( function_exists( 'get_sites' )) {
				$original_blog_id = get_current_blog_id();
				$blog_list = get_sites( 0, 'all' );
				$residents = [];
				$residents_blogs = [];
				$residents_url = [];
				foreach ($blog_list AS $blog) {
					switch_to_blog( (int) $blog->blog_id );
					$posts = get_posts(array(
						'post_type'  => 'residents',
						'posts_per_page'=> -1,
						'post_status'=>'publish'
					));
					if(is_array($posts)){
						for($i=0; $i<count($posts); $i++){
							array_push($residents, $posts[$i]);
							array_push($residents_blogs, $blog);
							array_push($residents_url, get_post_permalink($posts[$i]));
						}
					}
				}
				restore_current_blog();
			} else {
				$residents = get_posts(array(
					'post_type'  => 'residents',
					'posts_per_page'=> -1,
					'post_status'=>'publish'
				));
			}

			for($i=0; $i<count($residents); $i++){
				$post = $residents[$i];
				$blog = $residents_blogs[$i];
				setup_postdata($post);
				set_query_var( 'theme', "normal" );
				set_query_var( 'post_url', $residents_url[$i]);
				set_query_var( 'blog',  $residents_blogs[$i]);
				get_template_part( "template-parts/post/content-head-resident" );
			}
			?>
		</div>
	</div>
</main>


<?php get_footer();
