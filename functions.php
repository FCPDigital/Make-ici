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
            'post_type'        => $post->post_type,
            'exclude_tree'     => $post->ID,
            'selected'         => $post->post_parent,
            'name'             => 'parent_id',
            'show_option_none' => __('(no parent)'),
            'sort_column'      => 'menu_order, post_title',
            'echo'             => 0,
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

// Retourne la liste des catégories de woocommerce
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


////////////////////////////////
//				Générique
////////////////////////////////

// Renvoi les derniers produits sous la forme d'un carousel
function get_last_posts(){

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

  $products = new WP_Query($args);
  $products = sort_by_date($products);
  $limit = count($products);
  $activeControl = ($limit>3) ?  "active-control" : "";
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

// Retourne le SLUG d'un post
function get_the_slug(){
	return get_post_field( 'post_name', get_post() );
}


////////////////////////////////
//				Dates
////////////////////////////////

// Formate une date de type 31122917 en 31/12/2017
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

function get_next_date($product, $attibute_name="attribute_pa_date"){
  $data = get_variation_attribute($product);
  $date = [];
  for($i=0; $i<count($data); $i++){
    foreach($data[$i] as $attrName => $var_name) {
      if( $attrName == $attibute_name ) {
        array_push($date, $var_name);
      }
    }
  }
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
  while ( $products->have_posts() ) :  $products->the_post();
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
          // echo "Date courante est inférieur à celle du produit :".$products_sort[$i]["el"];
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
    'order'=> $args["ASC"]
  ));

  $content="<div class='single-body staff-container'>";
  while ( $posts->have_posts() ) : $posts->the_post();
    if(get_post()->post_type == "staff"){
      $content .= "<div class='staff-item' id='post-<?php the_ID(); ?>'>
        <img src='".get_the_post_thumbnail_url()."' alt=''>
        <div class='staff-item-content'>
          <h3>".get_the_title()."</h3>
          <p><?php the_content() ?></p>
          <a href='#'  data-getarg='contact=".get_field('e-mail')."' data-wpxhr='contact_form' data-xhrarg='".get_the_ID()."' class='btn btn-colored action-abonnement'>Contactez le(a)</a>
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

add_action( 'init', 'create_post_type_staff' );

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
	$param = $_POST['param'];
	if (is_array($param)){
		$id = (isset($param["id"])) ? (int) $param["id"] : null;
		$value = (isset($param["value"])) ? $param["value"] : "Formulaire";
	} else {
		$id = (int) $param;
		$value = null;
	}

	$content =  "<div class='title-container'><h2 class='title'>".$value."</h2></div>";
	echo $content;
	echo do_shortcode("[contact-form-7 id='".$id."' title='Contactez']");
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
