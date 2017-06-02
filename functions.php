<?php


require_once('helpers/wp_bootstrap_navwalker.php');


//////////////////////////////////////////////////////
//
//						HELPERS
//
//////////////////////////////////////////////////////

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
		$count = $products->post_count;


		// var_dump($products->posts);
		$active = ($count > 4) ? "active-control" : "";


		?>
		<div class="archive-main-body">
			<div class="product-carousel carousel <?php echo $active; ?>">
				<div class="carousel-body">
					<div class="archive-head carousel-container">
						<?php $count = 0; ?>

						<?php while ( $products->have_posts() ) :  $products->the_post();
							if ( get_the_ID($products->get_post()) != $except ) {
								include( locate_template("template-parts/woocommerce/content-boutique-product.php") );
								$count++;
							}
						endwhile; ?>
					</div>
				</div>
				<div class="carousel-control">
					<p class="carousel-control-mention">Voir d\'autres abonnements</p>
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

function get_category_slug($category) {
	if($category){
		$slug = $category->slug;
		if($slug){
			return $slug;
		}
	}
}

function get_products_from_category($category){

	$productArgs = array( 'post_type' => 'product', 'posts_per_page' => -1, 'product_cat' => $category->name, 'orderby' => 'rand' );
	$products = new WP_Query( $productArgs );
	return $products ;
}

//////////////////////////////////////////////////////
//
//						THEMES FUNCTIONNALITY
//
//////////////////////////////////////////////////////

function create_post_type_abonnement() {
  register_post_type( 'abonnements',
    array(
      'labels' => array(
        'name' => __( 'Abonnement' ),
        'singular_name' => __( 'Abonnement' )
      ),
      'public' => true,
      'has_archive' => true,
			'menu_icon' => 'dashicons-book-alt',
			'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' )
    )
  );
}

add_action( 'init', 'create_post_type_abonnement' );


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
// * @hooked woocommerce_template_single_price - 10
// * @hooked woocommerce_template_single_excerpt - 20
// * @hooked woocommerce_template_single_add_to_cart - 30
// * @hooked woocommerce_template_single_meta - 40
// * @hooked woocommerce_template_single_sharing - 50
// * @hooked WC_Structured_Data::generate_product_data() - 60
// */



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
	echo do_shortcode("[wpforms id='".get_field('form_code', $post)."']");
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

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );
	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'makeici_setup' );



function init_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'init_sidebars' );



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
