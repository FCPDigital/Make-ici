<?php


require_once('helpers/wp_bootstrap_navwalker.php');



//////////////////////////////////////////////////////
//
//						TEMPLATING CUSTOM POST
//
//////////////////////////////////////////////////////


/** Custom Post Type Template Selector **/
function cpt_add_meta_boxes() {
	$post_types = get_post_types();
	foreach( $post_types as $ptype ) {
		if ( $ptype !== 'page') {
			add_meta_box( 'cpt-selector', 'Attributes', 'cpt_meta_box', $ptype, 'side', 'core' );
		}
	}
}
add_action( 'add_meta_boxes', 'cpt_add_meta_boxes' );

function cpt_remove_meta_boxes() {
	$post_types = get_post_types();
	foreach( $post_types as $ptype ) {
		if ( $ptype !== 'page') {
			remove_meta_box( 'pageparentdiv', $ptype, 'normal' );
		}
	}
}
add_action( 'admin_menu' , 'cpt_remove_meta_boxes' );

function cpt_meta_box( $post ) {
	$post_meta = get_post_meta( $post->ID );
	$templates = wp_get_theme()->get_page_templates();

	$post_type_object = get_post_type_object($post->post_type);
	if ( $post_type_object->hierarchical ) {
		$dropdown_args = array(
			'post_type'			=> $post->post_type,
			'exclude_tree'		=> $post->ID,
			'selected'			=> $post->post_parent,
			'name'				=> 'parent_id',
			'show_option_none' 	=> __('(no parent)'),
			'sort_column'		=> 'menu_order, post_title',
			'echo'				=> 0
		);

		$dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
		$pages = wp_dropdown_pages( $dropdown_args );

		if ( $pages ) {
			echo "<p><strong>Parent</strong></p>";
			echo "<label class=\"screen-reader-text\" for=\"parent_id\">Parent</label>";
			echo $pages;
		}
	}

	// Template Selector
	echo "<p><strong>Template</strong></p>";
	echo "<select id=\"cpt-selector\" name=\"_wp_page_template\"><option value=\"default\">Default Template</option>";
	foreach ( $templates as $template_filename => $template_name ) {
		if ( $post->post_type == strstr( $template_filename, '-', true) ) {
			if ( isset($post_meta['_wp_page_template'][0]) && ($post_meta['_wp_page_template'][0] == $template_filename) ) {
				echo "<option value=\"$template_filename\" selected=\"selected\">$template_name</option>";
			} else {
				echo "<option value=\"$template_filename\">$template_name</option>";
			}
		}
	}
	echo "</select>";

	// Page order
	echo "<p><strong>Order</strong></p>";
	echo "<p><label class=\"screen-reader-text\" for=\"menu_order\">Order</label><input name=\"menu_order\" type=\"text\" size=\"4\" id=\"menu_order\" value=\"". esc_attr($post->menu_order) . "\" /></p>";
}

function save_cpt_template_meta_data( $post_id ) {

		if ( isset( $_REQUEST['_wp_page_template'] ) ) {
				update_post_meta( $post_id, '_wp_page_template', $_REQUEST['_wp_page_template'] );
		}
}
add_action( 'save_post' , 'save_cpt_template_meta_data' );

function custom_single_template($template) {
		global $post;

		$post_meta = ( $post ) ? get_post_meta( $post->ID ) : null;
		if ( isset($post_meta['_wp_page_template'][0]) && ( $post_meta['_wp_page_template'][0] != 'default' ) ) {
				$template = get_template_directory() . '/' . $post_meta['_wp_page_template'][0];
		}

		return $template;
}
add_filter( 'single_template', 'custom_single_template' );
/** END Custom Post Type Template Selector **/


//////////////////////////////////////////////////////
//
//						HELPERS
//
//////////////////////////////////////////////////////


////////////////////////////////
//				Woocommerce
////////////////////////////////


/* Afficher "À partir de" pour les produits variables */
add_filter( 'woocommerce_variable_sale_price_html', 'wpm_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wpm_variation_price_format', 10, 2 );

function wpm_variation_price_format( $price, $product ) {
	//On récupère le prix min et max du produit variable
	$min_price = $product->get_variation_price( 'min', true );
	$max_price = $product->get_variation_price( 'max', true );

	// Si les prix sont différents on affiche "À partir de ..."
	if ($min_price != $max_price){
		$price = sprintf( __( 'A partir de %1$s', 'woocommerce' ), wc_price( $min_price ) );
		return $price;
	// Sinon on affiche juste le prix
	} else {
		$price = sprintf( __( '%1$s', 'woocommerce' ), wc_price( $min_price ) );
		return $price;
	}
}

// Retourne la liste des catégories de woocommerce
function get_woocommerce_categories(){
	$taxonomy		 = 'product_cat';
	$orderby			= 'name';
	$show_count	 = 0;			// 1 for yes, 0 for no
	$pad_counts	 = 0;			// 1 for yes, 0 for no
	$hierarchical = 1;			// 1 for yes, 0 for no
	$title				= '';
	$empty				= 0;
	$args = array(
		'taxonomy'		 => $taxonomy,
		'orderby'			=> $orderby,
		'show_count'	 => $show_count,
		'pad_counts'	 => $pad_counts,
		'hierarchical' => $hierarchical,
		'title_li'		 => $title,
		'hide_empty'	 => $empty
	);
	return get_categories( $args );
}

// Retourne la photo de backgroup d'une categorie woocommerce
function get_category_thumbnail($category){
	$id = $category->term_id;
	$thumbnail_id = get_woocommerce_term_meta( $id, 'thumbnail_id', true );
	$image = wp_get_attachment_url( $thumbnail_id );
	if($image){
		return $image;
	}
}

// Récupérer les produits d'une categorie
function get_products_from_category($category){
	$productArgs = array( 'post_type' => 'product', 'posts_per_page' => -1, 'product_cat' => $category->name, 'orderby' => 'post_date', 'order' => "DESC" );
	$products = new WP_Query( $productArgs );
	return $products ;
}

add_filter( 'woocommerce_payment_complete_order_status', 'rfvc_update_order_status', 10, 2 );
function rfvc_update_order_status( $order_status, $order_id ) {
  $order = new WC_Order( $order_id );
  if ( 'processing' == $order_status && ( 'on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status ) ) {
    return 'completed';
  }
  return $order_status;
}


////////////////////////////////
//				Générique
////////////////////////////////

// Renvoi les derniers produits sous la forme d'un carousel
function last_products(){

	$meta_query = array();
	$args = array();

	$meta_query[] = array(
			'key' => '_wp_page_template',
			'value' => "default",
			'compare' => 'LIKE'
	);
	// The Query
	$args['post_type'] = "product";
	$args['meta_query'] = $meta_query;
	$args['posts_per_page'] = -1;

	$products = new WP_Query($args);
	$products = sort_by_date($products);
	$products = array_slice($products, 0, 5);
	$limit = count($products);
	$activeControl = ($limit>3) ?	"active-control" : "";

	?>
	<div class="archive-main-body">
		<div class="product-carousel carousel <?php echo $activeControl; ?>">
			<div class="carousel-body">
				<div class="archive-head carousel-container">
					<?php
					$count = 0;
					foreach ( $products as $product ) : setup_postdata( $product );
					if($count < $limit){
						set_query_var("item", $product);
						set_query_var("size", "item--small");
						set_query_var("class", "carousel-item");
						set_query_var("limit", 80);
						set_query_var("heightAuto", true);
						set_query_var("callback", [
							"content" => "En savoir plus",
							"url" => get_permalink($product)
						]);
						get_template_part( 'template-parts/post/content', "head-post");
						$count++;
					}
				 	endforeach;
					?>
				</div>
			</div>
			<div class="carousel-control">
				<p class="carousel-control-mention"></p>
				<a href="#" class="carousel-control-btn" data-direction="left"></a>
				<a href="#" class="carousel-control-btn" data-direction="right"></a>
			</div>
		</div>
	</div>
	<?php
}


function last_posts(){

	$meta_query = array();
	$args = array();

	$posts_query = new WP_Query( [
		'post_type' => "post",
		'posts_per_page' => 8	
	] );	
	$limit = count($posts_query->posts);
	$activeControl = ($limit>3) ?	"active-control" : "";

	?>
	<div class="archive-main-body">
		<div class="product-carousel carousel <?php echo $activeControl; ?>" >
			<div class="carousel-body">
				<div class="archive-head carousel-container">
					<?php
					$count = 0;
					while ( $posts_query->have_posts() ) {	
						$posts_query->the_post();	
						if($count < $limit){
							set_query_var("item", $posts_query->get_post());
							set_query_var("size", "item--small");
							set_query_var("class", "carousel-item");
							get_template_part( 'template-parts/post/content', "head-post");
							$count++;
						}
				 	}
					?>
				</div>
			</div>
			<div class="carousel-control">
				<a href="#" class="carousel-control-btn" data-direction="left"></a>
				<a href="#" class="carousel-control-btn" data-direction="right"></a>
			</div>
		</div>
	</div>
	<?php
}

function equipements_list() {
	echo get_field("equipement", $postCur); ?>
	<div class="single-body equipements-container">
	 	<?php 
		$equipements = get_posts( array('post_type' => 'equipements', 'posts_per_page' => '12'));
		foreach($equipements as $equipement){ setup_postdata( $equipement ); ?>
			<div class="equipements-item" id="post-<?php echo get_the_ID($equipement); ?>">
				<div class="equipements-item-content">
					<div class="equipements-title-container">
						<p class="equipements-title"><?php echo get_the_title($equipement); ?></p>
					</div>
					<div class="equipements-content">
						<?php echo get_field('description', $equipement) ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php
}

// Retourne le SLUG d'un post
function get_the_slug(){
	return get_post_field( 'post_name', get_post() );
}


////////////////////////////////
//				Dates
////////////////////////////////

// Formate une date de type 31122917 en 31/12/2017
function get_format_date($string){
	 return preg_replace("/(\d{2})(\d{2})(\d{4})/",	"$1/$2/$3", $string);
}


function manage_date_order_variable_product($options){
	$optionsManage = [];
	$c = date_create_from_format('dmY', date("dmY"))->getTimestamp();
	foreach( $options as $option) {
		if( $option ){
			$date = date_create_from_format( "dmY" , $option ) -> getTimestamp();
			if($date > $c){
				array_push($optionsManage, $option);
			}
		}
	}
	return $optionsManage;
}

function get_variation_attribute($product){
	$product_variable = new WC_Product_Variable( $product->ID );
	$variations = $product_variable->get_available_variations();

	$var_data = [];
	foreach ($variations as $variation) {
		if($variation['variation_id']){
			$var_data[] = $variation['attributes'];
		}
	}

	return $var_data;
}


function get_all_dates($product, $attibute_name="attribute_pa_date") {
	$data = get_variation_attribute($product);
	$date = [];
	for($i=0; $i<count($data); $i++){
		foreach($data[$i] as $attrName => $var_name) {
			if( $attrName == $attibute_name ) {
				array_push($date, $var_name);
			}
		}
	}
	return $date;
}

function get_next_date($product, $attibute_name="attribute_pa_date"){
	$date = get_all_dates($product);
	$currentDate = DateTime::createFromFormat('U', time());
	$nextDate = false;
	for($i=0; $i<count($date); $i++){
		$date[$i] = DateTime::createFromFormat( "dmY" , $date[$i] );
		if( $date[$i] > $currentDate ){
			//Si une date à venir est définis et que celle examiné est plus récente OU que aucune date prochaine n'est définis
			if(($nextDate&&$date[$i]<$nextDate)||($nextDate==false)){
				$nextDate = $date[$i];
			}
		}
	}
	if( $nextDate ) {
		return $nextDate;
	} else {
		return false;
	}
}

function sort_by_date($products){
	$products_sort = [];
	$count = 0;
	while ( $products->have_posts() ) :	$products->the_post();
		$post = get_post();
		$nextDate = get_next_date($post);
		$count++;
		$tmp_products_sort = $products_sort;
		$tmp = [
			"el" => $post,
			"date" => $nextDate
		];

		for($i=0; $i<count($products_sort); $i++) {
			//Si une date existe sur le produit parcouru
			if($products_sort[$i]["date"]){
				//Si la date est inferieur à celle du produit on ajoute avant
				if($nextDate && $nextDate < $products_sort[$i]["date"] ) {
					if($i==0){
						array_unshift($tmp_products_sort, $tmp);
					} else {
						array_splice( $tmp_products_sort, $i, 0, [$tmp]);
					}
					break;
				//Si c'est le dernier produit on ajoute après
				} elseif((count($products_sort)-1==$i)||($nextDate==false)){
					// echo "Dernier produit donc on rajoute après ".$products_sort[$i]["el"];
					array_push($tmp_products_sort, $tmp);
					break;
				}
			//Sinon
			} else {
				//Si la date du produit est définis,
				if( $i==0 ){
					array_unshift( $tmp_products_sort, $tmp);
				} else {
					array_splice( $tmp_products_sort, $i, 0, [$tmp]);
				}
				break;
			}
		}
		$products_sort = $tmp_products_sort;
		//Au début on ajoute le premier post
		if(count($products_sort) == 0){
			array_push($products_sort, [
				"el" => $post,
				"date" => get_next_date($post)
			]);
		}
	endwhile;

	$products_humanize = [];
	for($i=0; $i<count($products_sort); $i++){
		array_push($products_humanize, $products_sort[$i]["el"]);
	}
	return $products_humanize;
}

function get_category_title($category){
	if($category){
		$name = $category->name;
		if($name){
			return $name;
		}
	}
}


function get_category_slug($category) {
	if($category){
		$slug = $category->slug;
		if($slug){
			return $slug;
		}
	}
}



//////////////////////////////////////////////////////
//
//						SHORTCODES
//
//////////////////////////////////////////////////////

function shortcode_staff($atts){
	$args = shortcode_atts( array(
		'limit' => 5,
		'order' => "ASC"
	), $atts );

	$posts = new WP_Query(array(
		'post_type'=> 'staff',
		'limit' => (int) $args["limit"],
		'order'=> $args["order"]
	));

	$content="<div class='single-body staff-container'>";
	while ( $posts->have_posts() ) : $posts->the_post();
		if(get_post()->post_type == "staff"){
			$content .= "<div class='staff-item' id='post-<?php the_ID(); ?>'>
				<img src='".get_the_post_thumbnail_url()."' alt=''>
				<div class='staff-item-content'>
					<h3>".get_the_title()."</h3>
					<p>".get_the_content()."</p>
					<a href='#'	data-getarg='contact=".get_field('e-mail')."' data-wpxhr='contact_form' data-xhrarg='".get_the_ID()."' class='btn btn-colored action-abonnement'>Contactez le(a)</a>
				</div>
			</div>";
		}
	endwhile;
	$content.="</div>";
	wp_reset_query();
	return $content;

}

add_shortcode( 'staff', 'shortcode_staff' );


function shortcode_formbtn($atts){
	$args = shortcode_atts( array(
		'value' => null,
		'get' => null,
		'param' => null,
		'class' => "btn btn-colored",
		'action' => "classic_form"
	), $atts );

	$value = $args["value"];
	$get = ($args["get"]) ? "data-getarg='".$args["get"]."'" : "";
	$param = $args["param"];
	$action = $args["action"];
	$class = $args["class"];

	if($value){
		return "<a href='#' ".$get." data-wpxhr='".$action."' data-xhrarg='".$param."' class='".$class."'>".$value."</a>";
	}
}
add_shortcode( 'form', 'shortcode_formbtn' );


function shortcode_frames($atts){
	$args = shortcode_atts( array(
		'value' => null,
		'type' => 'dark'
	), $atts );
	$value = $args["value"];
	if($value){
		echo "<span class='frame frame--".$args['type']."'>".$value."</span>";
	}
}

add_shortcode( 'frame', 'shortcode_frames' );


function shortcode_box($atts, $content) {
	$args = shortcode_atts( array(
		'color' => 'yellow'
	), $atts );
	if($content){
		echo "<div class='box box--".$args["color"]."'>".$content."</div>";
	}
}

add_shortcode( 'box', 'shortcode_box' );


function shortcode_carousel($atts){
	$args = shortcode_atts( array(
		'category' => null,
		'except' => null,
		'style' => 'detail'
	), $atts );

	$except	= ( (int) $args["except"]) ? (int) $args["except"] : null;
	$category = $args["category"] ? $args["category"] : null;
	$style =	$args["style"] ? $args["style"] : null;

	if($category){
		$products = get_products_from_category($category);

		$count=0;
		//Parcours les posts
		while ( $products->have_posts() ) :	$products->the_post();
			//Si l'ID est différent de l'exception
			if ( get_the_ID($products->get_post()) != $except) {
				$cCat = get_the_terms( $products->get_post()->id, 'product_cat' )[0]->name;
				//Si la catégorie du post est bien celle qu'on parcours on incrémente
				if( $cCat == $category ){
					$count++;
				}
			}
		endwhile;

		if($count > 3){
			$active = "active-control";
		} else {
			$active = "";
		}
		?>
		<div class="archive-main-body">
			<div class="product-carousel carousel <?php echo $active; ?>">
				<div class="carousel-body">
					<div class="archive-head carousel-container">
						<?php $count = 0; ?>
						<?php while ( $products->have_posts() ) :	$products->the_post();
							if ( get_the_ID($products->get_post()) != $except) {
								$cCat = get_the_terms( $products->get_post()->id, 'product_cat' )[0]->name;
								if( $cCat == $category ){
									$product = $products->get_post();
									include( locate_template("template-parts/woocommerce/content-boutique-product.php") );
									$count++;
								}
							}
						endwhile; ?>
						<?php
						if ($count < 1){
							echo "<p class='no-product'>Il n'y a pas d'autre produit correspondant à cette catégorie.</p>";
						}
						 ?>
					</div>
				</div>
				<div class="carousel-control">
					<!-- <p class="carousel-control-mention">Voir d'autres abonnements</p> -->
					<a href="#" class="carousel-control-btn" data-direction="left"></a>
					<a href="#" class="carousel-control-btn" data-direction="right"></a>
				</div>
			</div>
		</div>
		<?php

	}
}

add_shortcode( 'carousel', 'shortcode_carousel' );


function shortcode_ico($atts){

	$special = array("atelier-partage", "machine", "2", "casier", "coaching", "entrepreneur", "office", "expo", "financement", "formation", "international", "logistique", "strong");
	$basic = array("line-chart", "handshake-o", "paint-brush", "lightbulb-o", "wifi", "male", "print", "clock-o");

	$args = shortcode_atts( array(
		'value' => null,
		'size' => 'small',
		'class' =>''
	), $atts );

	$value = $args["value"];
	$size = $args["size"];
	$class = $args["class"];

	if($value){
		if( in_array($value, $special) ) {
			$el = "<span class='fa-custom ".$class."'>
				<img src='".get_template_directory_uri()."/assets/images/ico/picto-".$value.".png'/>
			</span>";
		} else {
			$el = "<i class='".$class." ico fa fa-".$value."' aria-hidden='true'></i>";
		}
		return $el;
	}
}

add_shortcode( 'ico', 'shortcode_ico' );



//////////////////////////////////////////////////////
//
//						CUSTOM POST
//
//////////////////////////////////////////////////////

// POST TYPE STAFF
function create_post_type_staff() {
	register_post_type( 'staff',
		array(
			'labels' => array(
				'name' => __( 'Staff' ),
				'singular_name' => __( 'Staff' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-businessman',
			'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		)
	);
}

// POST TYPE EQUIPEMENTS
function create_post_type_equipements() {
	register_post_type( 'equipements',
		array(
			'labels' => array(
				'name' => __( 'Equipements' ),
				'singular_name' => __( 'Equipements' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-admin-tools',
			'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		)
	);
}


// POST TYPE ABONNEMENTS
function create_post_type_abonnement() {
	register_post_type( 'abonnements',
		array(
			'labels' => array(
				'name' => __( 'Abonnement' ),
				'singular_name' => __( 'Abonnement' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-backup',
			'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		)
	);
}

// POST TYPE ENTREPRISES
function create_post_type_entreprise() {
	register_post_type( 'entreprises',
		array(
			'labels' => array(
				'name' => __( 'Entreprise' ),
				'singular_name' => __( 'Entreprise' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-businessman',
			'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		)
	);
}

// POST TYPE ENTREPRISES
function create_post_type_events() {
	register_post_type( 'events',
		array(
			'labels' => array(
				'name' => __( 'Evènements' ),
				'singular_name' => __( 'Evènements' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-businessman',
			'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
		)
	);
}

function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'events');
	return $qv;
}
add_filter('request', 'myfeed_request');


add_action( 'init', 'create_post_type_abonnement' );
add_action( 'init', 'create_post_type_staff' );
add_action( 'init', 'create_post_type_entreprise' );
add_action( 'init', 'create_post_type_equipements' );
add_action( 'init', 'create_post_type_events' );


//////////////////////////////////////////////////////
//
//						woocommerce
//
//////////////////////////////////////////////////////

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);


function wc_remove_all_quantity_fields( $return, $product ) {
		return true;
}
add_filter( 'woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2 );// * @hooked woocommerce_template_single_rating - 10


function my_get_woo_cats() {
		$cats = get_terms( array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'orderby' => 'ASC',	'parent' =>0) );
}
add_action('init', 'my_get_woo_cats');


//////////////////////////////////////////////////////
//
//						AJAX
//
//////////////////////////////////////////////////////

function abonnement_form() {
	$param = (int) $_POST['param'];
	$post = get_post($param);
	if(get_field('subtitle', $post)){
		$h3 = "<h3>".get_field('subtitle', $post)."</h3>";
	} else {
		$h3 = "";
	}
	$content =	"<div class='title-container'><h2 class='title'>".get_the_title($post)."</h2>".$h3."</div>";
	echo $content;
	// echo do_shortcode("[wpforms id='".get_field('form_code', $post)."']");
	echo do_shortcode("[contact-form-7 id='".esc_attr( get_option('abonnement_form_id') )."' title='Abonnement']");

	die();
}

function contact_form() {
	$param = (int) $_POST['param'];
	$post = get_post($param);
	if(get_field('subtitle', $post)){
		$h3 = "<h3>".get_field('subtitle', $post)."</h3>";
	} else {
		$h3 = "";
	}
	$content =	"<div class='title-container'><h2 class='title'>".get_the_title($post)."</h2>".$h3."</div>";
	echo $content;
	// echo do_shortcode("[wpforms id='".get_field('form_code', $post)."']");
	echo do_shortcode("[contact-form-7 id='".esc_attr( get_option('contact_form_id') )."' title='Contactez ".get_the_title($post)."']");
	die();
}

function classic_form(){
	$param = $_POST['param'];
	if (is_array($param)){
		$id = (isset($param["id"])) ? (int) $param["id"] : null;
		$value = (isset($param["value"])) ? $param["value"] : "Formulaire";
	} else {
		$id = (int) $param;
		$value = null;
	}

	$content =	"<div class='title-container'><h2 class='title'>".$value."</h2></div>";
	echo $content;
	echo do_shortcode("[contact-form-7 id='".$id."' title='Contactez']");
	die();
}


add_action( 'wp_ajax_abonnement_form', 'abonnement_form' );
add_action( 'wp_ajax_nopriv_abonnement_form', 'abonnement_form' );
add_action( 'wp_ajax_contact_form', 'contact_form' );
add_action( 'wp_ajax_nopriv_contact_form', 'contact_form' );
add_action( 'wp_ajax_classic_form', 'classic_form' );
add_action( 'wp_ajax_nopriv_classic_form', 'classic_form' );

//////////////////////////////////////////////////////
//
//						THEMES FUNCTIONNALITY
//
//////////////////////////////////////////////////////

//Remove span wrapper in input form wp_contact_form_7
add_filter('wpcf7_form_elements', function($content) {
		$content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
		return $content;
});



//INITIALISATION DES SCRIPTS
function make_ici_scripts() {
	wp_register_script('smoothScroll', get_template_directory_uri() . '/assets/js/smoothscroll.js', array('jquery'),'1.1', true);
	wp_register_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'),'1.1', true);

	wp_enqueue_script('smoothScroll');
	wp_enqueue_script('main');

	wp_localize_script('main', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}

add_action( 'wp_enqueue_scripts', 'make_ici_scripts' );


// Récupére les premier mot de the_content
function get_excerpt_truncate($post, $value){
	return wp_trim_words( get_the_excerpt($post), $value, "...");
}

function truncate_content($content, $value, $suffixe = '...') {
	if(strlen($content) < $value) {
		$suffixe = '';
	}
	return strip_tags(substr( $content, 0, $value )).$suffixe;
}

function init_sidebar(){
	register_sidebar( array(
		 'name'					=> __( 'Footer 1', 'makeici' ),
		 'id'						=> 'sidebar-1',
		 'description'	 => __( 'Appears in the footer section of the site.', 'makeici' ),
		 'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		 'after_widget'	=> '</aside>',
		 'before_title'	=> '<h3 class="widget-title">',
		 'after_title'	 => '</h3>',
 	));
	 register_sidebar( array(
			 'name'					=> __( 'Footer 2', 'makeici' ),
			 'id'						=> 'sidebar-2',
			 'description'	 => __( 'Appears in the footer section of the site.', 'makeici' ),
			 'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			 'after_widget'	=> '</aside>',
			 'before_title'	=> '<h3 class="widget-title">',
			 'after_title'	 => '</h3>',
	 ));
	 register_sidebar( array(
			'name'					=> __( 'Footer 3', 'makeici' ),
			'id'						=> 'sidebar-3',
			'description'	 => __( 'Appears in the footer section of the site.', 'makeici' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	 => '</h3>',
	 ));
	 register_sidebar( array(
			'name'					=> __( 'Actu-Event', 'makeici' ),
			'id'						=> 'actue-event',
			'description'	 => __( 'Apparait dans la page Actu & Evenements', 'makeici' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</aside>'
	 ));

	register_sidebar( array(
			'name'					=> __( 'Below Post', 'makeici' ),
			'id'						=> 'below-post',
			'description'	 => __( 'Bloc de widget en bas des Post et des Events', 'makeici' ),
			'before_widget' => '<aside id="%1$s" class="widget-social %2$s">',
			'after_widget'	=> '</aside>'
	 ));
}

add_action( 'widgets_init', 'init_sidebar' );


add_filter('woocommerce_add_to_cart_redirect', 'themeprefix_add_to_cart_redirect');
function themeprefix_add_to_cart_redirect() {
	global $woocommerce;
	$checkout_url = $woocommerce->cart->get_checkout_url();
	return $checkout_url;
}


//////////////////////////////////////////////////////
//
//						ADMIN MENU
//
//////////////////////////////////////////////////////

function register_my_setting() {
	register_setting( 'formulaire', 'gift_card_id', "intval" );
	register_setting( 'formulaire', 'abonnement_form_id', "intval" );
	register_setting( 'formulaire', 'contact_form_id', "intval" );
	register_setting( 'formulaire', 'reduction_promo', "float" );
}
add_action( 'admin_init', 'register_my_setting' );


/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_theme_menu' );

/** Step 1. */
function my_theme_menu() {
	add_options_page( 'Mes options de thèmes', 'MakeICI', 'manage_options', 'my-unique-identifier', 'my_theme_options' );
}



/** Step 3. */
function my_theme_options() {
	if ( !current_user_can( 'manage_options' ) )	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	<div class="wrap">
		<h1>Réglage du thème MakeICI</h1>
		<div>
			<p>Pour consulter la documentation c'est par <a target="_blank" href="https://github.com/SolalDR/Make-ici/blob/master/README.md">ICI</a></p>
		</div>
		<form class="form" method="post" action="options.php">
		<?php
		settings_fields( 'formulaire' ) ;
		do_settings_sections( 'formulaire' );
		?>
		<div class="form-group">
			<label>Identifiant du produit Carte Cadeau</label><br>
			<input class="form-control" value="<?php echo esc_attr( get_option('gift_card_id') ); ?>" name="gift_card_id" type="text"/>
		</div>
		<div class="form-group">
			<label>Identifiant du formulaire d'abonnement</label><br>
			<input class="form-control" value="<?php echo esc_attr( get_option('abonnement_form_id') ); ?>" name="abonnement_form_id" type="text"/>
		</div>
		<div class="form-group">
			<label>Réduction abonné (mettre un nombre entre 0 et 1)</label><br>
			<i class="mention">100€ avec 0.8 = 100x0.8 => 80€</i>
			<input class="form-control" value="<?php echo esc_attr( get_option('reduction_promo') ); ?>" name="reduction_promo" type="text"/>
		</div>
		<div class="form-group">
			<label>Identifiant du formulaire de contact spécifique</label><br>
			<input class="form-control" value="<?php echo esc_attr( get_option('contact_form_id') ); ?>" name="contact_form_id" type="text"/>
		</div>
		<?php submit_button(); ?>
		</form>
	</div>
	<?php
}


//////////////////////////////////////////////////////
//
//						LOGIN CUSTOM
//
//////////////////////////////////////////////////////

function display_website_logo(){
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	if($image){
		echo "<img src='$image[0]' alt='".get_bloginfo("name")."'/>";
	}
}

function my_login_logo_url() {
	return home_url();
}

function my_login_logo() {
	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/login.css' );
}

add_filter( 'login_headerurl', 'my_login_logo_url' );
add_action( 'login_enqueue_scripts', 'my_login_logo' );


//////////////////////////////////////////////////////
//
//						twentyseventeen
//
//////////////////////////////////////////////////////

function makeici_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );
	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );
	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'top'		=> __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption') );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio' ) );
	add_theme_support( 'custom-logo', array( 'width' => 250, 'height' => 250, 'flex-width'	=> true) );
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'makeici_setup' );

function javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'javascript_detection', 0 );

function cross_browser_scripts() {
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cross_browser_scripts' );
