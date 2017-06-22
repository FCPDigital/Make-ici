<?php

get_header();

/* Start the Loop */
while ( have_posts() ) : the_post();

$template = get_post_meta( get_the_ID(), "_wp_page_template" );

if(count($template)>0){
  if($template[0] == "default"){
    include( locate_template("product-".$template[0].".php") );
  } else {
    include( locate_template($template[0]) );
  }
} else {
  include( locate_template("product-default.php") );
}

endwhile;

?>
