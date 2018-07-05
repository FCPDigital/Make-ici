<?php get_header(); ?>

<?php
if ( function_exists( 'get_sites' )) {
	$original_blog_id = get_current_blog_id();
	$blog_list = get_sites( 0, 'all' );
	$residents = [];
	$residents_blogs = [];
	$residents_url = [];
	$blogs_info = [];
	foreach ($blog_list AS $blog) {
		switch_to_blog( (int) $blog->blog_id );

		if($blog->deleted == 0 && $blog->path != "/"){
			array_push($blogs_info, array(
					"name" => get_bloginfo( 'name' ),
					"path" => $blog->path,
					"id" => $blog->blog_id
			));
		}

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
?>
<main id="actus" class="site-main actus landing" role="main" style="background-image: url(http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/05/home-ici-montreuil.jpg);">
	<div id="residents-filter" class="wrapper container">
		<h1 class="text-center bold margin-bottom-medium">Nos résidents</h1>
		<div class="filter margin-bottom-big">
			<div class="filter__list text-center">
				<p class="inline">Filtres : </p>
				<select class="select select--light" name="blog" data-filters='{"modifier": "hidden", "value": false, "order": 1}'>
					<option value="false">Tous</option>
					<?php foreach($blogs_info as $key => $infos) { ?>
						<option <?php if($original_blog_id == $infos["id"]): echo "selected"; endif; ?> value="<?php echo $infos["id"]; ?>"><?php echo $infos["name"]; ?></option>
					<?php } ?>
				</select>
				<?php $field = get_field_object("savoirs_faires"); ?>
				<select class="select select--light" name="savoirs_faires" data-filters='{"modifier": "hidden", "value": false, "order": 2}'>
					<option value="false">Tous</option>
					<?php foreach($field["choices"] as $key => $value) { ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div id="residents-empty-message" class="hidden text-center">
			<p>Aucun résidents ne correspond à vos critères.</p>
		</div>
		<div id="masonry-resident">
			<?php

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
