<?php
/*
Contenu d'une section d'abonnement
Ce template est appelé notamment dans archive-abonnement.php
*/
 ?>

<?php //L'id sert à identifier les section pour la navigation en timeline, le background sert à afficher l'image de fond ?>
<section id="item-<?php echo get_the_slug(); ?>" class=" perspective-corner  archive-body-item awesome-panel-item container-fluid page-section" style="background-image:url('<?php echo get_the_post_thumbnail_url(); ?>')">

  <div class="container">

    <?php //Contenu central de la section ?>
    <div class="archive-main">
      <div class="archive-main-head">
        <h2 class="left-full-border">
          <?php echo get_the_title(); ?>
        </h2>
        <h3 >
          <?php echo get_field("subtitle"); ?>
        </h3>
      </div>
      <div class="archive-main-body">
        <?php the_content(); ?>
      </div>
    </div>

    <?php // Sidebar de droite ?>
    <div class="archive-sidebar">

      <div class="cost_per_month">
        <i class="fa fa-eur" aria-hidden="true"></i>
        <p>À partir de <br> <?php echo get_field("cost_per_month"); ?> TTC /mois</p>
      </div>
 <div class="cost_registration">
        <i class="fa fa-inscription" aria-hidden="true"></i>
        <p>Frais d'inscription :<br><?php echo get_field("cost_registration"); ?> TTC</p>
      </div>
     

      <p class="mention">Durée minimale :<br><?php echo get_field("duration_min");  ?> / Préavis <?php echo get_field("duration_preavis");  ?></p>
      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
      <?php echo get_field("mention_supplementaire"); ?>

      <?php
      if(get_field("form_code")){
        //Si l'abonnement est lié à un produit (comme l'abonnement à la carte) on affiche le lien vers ce produit
        if(get_field("is_product")){
          echo "<a class='btn btn-colored action-abonnement' href='".get_the_permalink(get_field("form_code"))."'>Je m'abonne</a>";
        } else {
          //Sinon on appelle le shortcode du formulaire ajax
          echo do_shortcode("[form value=\"Je m'abonne\" class='btn btn-colored action-abonnement' action='abonnement_form' get='title=".get_the_title()."' param='".get_the_ID()."']");
        }
      }
      ?>

    </div>

  </div>

</section>
