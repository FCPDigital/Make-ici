<?php
/*
Ce template sert à router une page de woocommerce vers le bon template en fonction de celui sélectionner dans le backoffice
Il va donc appelé l'un des deux fichiers :
- product-default.php
- product-other.php
Qui respectivement appelleront
- template-parts/woocommerce/content-product-formation.php
- template-parts/woocommerce/content-product-other.php
*/

get_header();

/* Start the Loop */
while ( have_posts() ) : the_post();

//Récupère le template de la page
$template = get_post_meta( get_the_ID(), "_wp_page_template" );

//SI le template est définis
if(count($template)>0){
  if($template[0] == "default"){
    include( locate_template("product-".$template[0].".php") );
  } else {
    include( locate_template($template[0]) );
  }
// Sinon par défaut
} else {
  include( locate_template("product-default.php") );
}

endwhile;

?>
