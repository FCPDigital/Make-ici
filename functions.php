<?php


require_once('helpers/wp_bootstrap_navwalker.php');


//////////////////////////////////////////////////////
//
//						HELPERS
//
//////////////////////////////////////////////////////

function get_last_posts(){
	$limit = 5;
	$activeControl = ($limit>3) ?  "active-control" : "";
	$products = get_posts(array(
		'post_type' => 'product',
		'orderby' => 'post_date',
		'order' => "DESC",
		'limit' => $limit,
	));
	?>
	<div class="archive-main-body">
		<div class="product-carousel carousel <?php echo $activeControl; ?>">
			<div class="carousel-body">
				<div class="archive-head carousel-container">
					<?php
					$count = 0;
					foreach ( $products as $product ) : setup_postdata( $product );
					if($count < $limit){
						include( locate_template("template-parts/woocommerce/content-last-products.php") );
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

function shortcode_formbtn($atts){
	$args = shortcode_atts( array(
		'value' => null,
		'get' => "",
		'param' => null,
		'action' => null
	), $atts );
	$value = $args["value"];
	$get = $args["get"];
	$param = $args["param"];
	$action = $args["action"];
	if($value){
		echo "<a href='#'  data-getarg='".$get."' data-wpxhr='".$action."' data-xhrarg='".$param."' class='btn btn-colored action-abonnement'>".$value."</a>";
	}
}
add_shortcode( 'form', 'shortcode_formbtn' );


function shortcode_frames($atts){
	$args = shortcode_atts( array(
		'value' => null
	), $atts );
	$value = $args["value"];
	if($value){
		echo "<span class='framed'>".$value."</span>";
	}
}

add_shortcode( 'frame', 'shortcode_frames' );

function shortcode_carousel($atts){
	$args = shortcode_atts( array(
		'category' => null,
		'except' => null,
		'style' => 'detail',
		'baz' => 'default baz',
	), $atts );

	$except  = ( (int) $args["except"]) ? (int) $args["except"] : null;
	$category = $args["category"] ? $args["category"] : null;
	$style =  $args["style"] ? $args["style"] : null;

	if($category){
		$products = get_products_from_category($category);

		$count=0;
		//Parcours les posts
		while ( $products->have_posts() ) :  $products->the_post();
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
						<?php while ( $products->have_posts() ) :  $products->the_post();
							if ( get_the_ID($products->get_post()) != $except) {
								$cCat = get_the_terms( $products->get_post()->id, 'product_cat' )[0]->name;
								if( $cCat == $category ){
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
					<p class="carousel-control-mention">Voir d'autres abonnements</p>
					<a href="#" class="carousel-control-btn" data-direction="left"></a>
					<a href="#" class="carousel-control-btn" data-direction="right"></a>
				</div>
			</div>
		</div>
		<?php

	}
}

add_shortcode( 'carousel', 'shortcode_carousel' );

function display_website_logo(){
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	if($image){
		echo "<img src='$image[0]' alt='".get_bloginfo("name")."'/>";
	}
}

function get_the_slug(){
	return get_post_field( 'post_name', get_post() );
}

function get_woocommerce_categories(){

  $taxonomy     = 'product_cat';
  $orderby      = 'name';
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no
  $title        = '';
  $empty        = 0;

  $args = array(
  	'taxonomy'     => $taxonomy,
  	'orderby'      => $orderby,
  	'show_count'   => $show_count,
  	'pad_counts'   => $pad_counts,
  	'hierarchical' => $hierarchical,
  	'title_li'     => $title,
  	'hide_empty'   => $empty
  );

	return get_categories( $args );
}

function get_category_thumbnail($category){
	$id = $category->term_id;
	$thumbnail_id = get_woocommerce_term_meta( $id, 'thumbnail_id', true );
	$image = wp_get_attachment_url( $thumbnail_id );
	if($image){
		return $image;
	}
}

function get_format_date($string){
	 return preg_replace("/(\d{2})(\d{2})(\d{4})/",  "$1/$2/$3", $string);
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

function get_category_title($category){
	if($category){
		$name = $category->name;
		if($name){
			return $name;
		}
	}
}

function get_woocommerce_category_name($post){
	// $cats = get_terms( array(
	// 	'taxonomy' => 'product_cat',
	// 	'hide_empty' => 0,
	// 	'orderby' => 'ASC',
	// 	'parent' =>0
	// ));
}

function get_category_slug($category) {
	if($category){
		$slug = $category->slug;
		if($slug){
			return $slug;
		}
	}
}

function get_products_from_category($category){

	$productArgs = array( 'post_type' => 'product', 'posts_per_page' => -1, 'product_cat' => $category->name, 'orderby' => 'post_date', 'order' => "DESC" );
	$products = new WP_Query( $productArgs );
	return $products ;
}

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


function my_get_woo_cats() {
    $cats = get_terms( array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'orderby' => 'ASC',  'parent' =>0) );
    //print_r($cats);
}
add_action('init', 'my_get_woo_cats');



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

add_action( 'init', 'create_post_type_abonnement' );

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
add_action( 'init', 'create_post_type_entreprise' );

function make_ici_scripts() {
	wp_register_script('smoothScroll', get_template_directory_uri() . '/assets/js/smoothscroll.js', array('jquery'),'1.1', true);
	wp_register_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'),'1.1', true);

	wp_enqueue_script('smoothScroll');
	wp_enqueue_script('main');

	wp_localize_script('main', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}

add_action( 'wp_enqueue_scripts', 'make_ici_scripts' );


function get_excerpt_truncate($post, $value){
	return wp_trim_words( get_the_excerpt($post), $value, "...");
}


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


add_action( 'wp_ajax_abonnement_form', 'abonnement_form' );
add_action( 'wp_ajax_nopriv_abonnement_form', 'abonnement_form' );

function abonnement_form() {
	$param = (int) $_POST['param'];
	$post = get_post($param);
	if(get_field('subtitle', $post)){
		$h3 = "<h3>".get_field('subtitle', $post)."</h3>";
	} else {
		$h3 = "";
	}
	$content =  "<div class='title-container'><h2 class='title'>".get_the_title($post)."</h2>".$h3."</div>";
	echo $content;
	// echo do_shortcode("[wpforms id='".get_field('form_code', $post)."']");
	echo do_shortcode("[contact-form-7 id='".get_field('form_code', $post)."' title='Abonnement']");

	die();
}


add_action( 'wp_ajax_contact_form', 'contact_form' );
add_action( 'wp_ajax_nopriv_contact_form', 'contact_form' );

function contact_form() {
	$param = (int) $_POST['param'];
	$post = get_post($param);
	if(get_field('subtitle', $post)){
		$h3 = "<h3>".get_field('subtitle', $post)."</h3>";
	} else {
		$h3 = "";
	}
	$content =  "<div class='title-container'><h2 class='title'>".get_the_title($post)."</h2>".$h3."</div>";
	echo $content;
	// echo do_shortcode("[wpforms id='".get_field('form_code', $post)."']");
	echo do_shortcode("[contact-form-7 id='".get_field('id_form', $post)."' title='Contactez ".get_the_title($post)."']");
	die();
}

add_action( 'wp_ajax_classic_form', 'classic_form' );
add_action( 'wp_ajax_nopriv_classic_form', 'classic_form' );

function classic_form(){
	$param = (int) $_POST['param'];
	$post = get_post($param);
	if(get_field('subtitle', $post)){
		$h3 = "<h3>".get_field('subtitle', $post)."</h3>";
	} else {
		$h3 = "";
	}
	$content =  "<div class='title-container'><h2 class='title'>".get_the_title($post)."</h2>".$h3."</div>";
	echo $content;
	// echo do_shortcode("[wpforms id='".get_field('form_code', $post)."']");
	echo do_shortcode("[contact-form-7 id='".get_field('id_form', $post)."' title='Contactez ".get_the_title($post)."']");
	die();
}


function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo() {
	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_logo' );


function init_sidebar(){
	register_sidebar( array(
		 'name'          => __( 'Footer 1', 'makeici' ),
		 'id'            => 'sidebar-1',
		 'description'   => __( 'Appears in the footer section of the site.', 'makeici' ),
		 'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		 'after_widget'  => '</aside>',
		 'before_title'  => '<h3 class="widget-title">',
		 'after_title'   => '</h3>',
 ));
 register_sidebar( array(
		 'name'          => __( 'Footer 2', 'makeici' ),
		 'id'            => 'sidebar-2',
		 'description'   => __( 'Appears in the footer section of the site.', 'makeici' ),
		 'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		 'after_widget'  => '</aside>',
		 'before_title'  => '<h3 class="widget-title">',
		 'after_title'   => '</h3>',
 ));
 register_sidebar( array(
		'name'          => __( 'Footer 3', 'makeici' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'makeici' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
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
//						twentyseventeen
//
//////////////////////////////////////////////////////

function makeici_setup() {

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );
	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );


	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption') );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio' ) );
	add_theme_support( 'custom-logo', array( 'width' => 250, 'height' => 250, 'flex-width'  => true) );
	add_theme_support( 'customize-selective-refresh-widgets' );

}
add_action( 'after_setup_theme', 'makeici_setup' );


 //Adds a `js` class to the root `<html>` element when JavaScript is detected.
function javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'javascript_detection', 0 );



// Add a pingback url auto-discovery header for singularly identifiable articles.
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
// add_action( 'wp_head', 'twentyseventeen_pingback_header' );



// Enqueue scripts and styles.
function cross_browser_scripts() {

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );


	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cross_browser_scripts' );
