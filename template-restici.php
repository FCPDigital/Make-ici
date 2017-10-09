<?php
/**
 * Template Name: REST'ICI
 */

get_header(); ?>

<main id="page" class="site-main equipements" role="main">
	<div id="anchor-1" class="section-post last-posts" style="background-image: url(<?php echo get_field("bg_rest-ici"); ?>)">
		<div class="container">
			<div class="archive-main row">
				<?php //Contenu principale de la section ?>
				<div class="col-sm-8">
					<div class="archive-main-head">
			<h1 class="left-full-border"><?php echo get_the_title(); ?></h1>
			<div class="single-body">
			<p>
			<?php
			while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?></p>
			<?php endwhile; // End of the loop. ?>
			</div>
			</div>		 
				</div>
				<?php //Sidebar de droite ?>
				<div class="col-sm-4 ">
					<div class="rest-img"><img src="<?php echo get_field("photo_chef"); ?>" width="304" alt="">
						<p class="rest-img-content"><?php echo get_field("texte_chef"); ?><p>&nbsp;</p></p>
					</div>
					</div>
					
					
					
			<div class="clr"></div>
		</div>
		<a class="scroll-btn" href="#anchor-2" data-scroll></a>
	</div>
		</div>
	
	
	<div id="anchor-2" class="section-post" style="background-image: url(<?php echo get_field('fond_rest-ici_formules'); ?>);">
		<div class="container">
		
			<h2 class="left-full-border">3 Formules, tous les midis</h2>
			<div class="single-body">
				<div id="main-carousel" class="carousel ">
					<div class="carousel-body rest">
						<div class="archive-head carousel-container">

							<div class="item  item--height-auto archive-head-item carousel-item">
								<div class="item__banner">
									<p class="item__title">SUR PLACE</p>
								</div>
								<div class="item__thumbnail">
									<img src="http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/07/img-surplace.jpg" alt="">
								</div>
								<div class="item__content margin-bottom-medium">
									<p>Pour passer un moment dans un environnement Arty, notre salle <br>contient plus de 30 places assises</p>
								</div>
							</div>

							<div class="item  item--height-auto archive-head-item carousel-item">
								<div class="item__banner">
									<p class="item__title">À EMPORTER</p>
								</div>
								<div class="item__thumbnail">
									<img src="http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/07/img-emporter.jpg" alt="">
								</div>
								<div class="item__content margin-bottom-medium">
									Deliveroo peut vous livrer directement sur votre lieu de travail ou <br>vous pouvez venir chercher votre repas sur place
								</div>
								<div class="item__actions">
		 							<a href="https://deliveroo.fr/fr/menu/paris/montreuil-robespierre/restici" target="blank_" class="btn btn--light">Commander sur Deliveroo</a>
		 						</div>
							</div>

							<div class="item  item--height-auto archive-head-item carousel-item">
								<div class="item__banner">
									<p class="item__title">GROUPES</p>
								</div>
								<div class="item__thumbnail">
									<img src="http://makeici.org/icimontreuil/wp-content/uploads/sites/2/2017/07/img-groupe.jpg" alt="">
								</div>
								<div class="item__content margin-bottom-medium">
									<p>Nous pouvons accueillir des groupes de<br> 5 à 50 pax<?php echo get_field("texte_group"); ?></p>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<a class="scroll-btn" href="#anchor-3" data-scroll></a>
	</div>
 </div>
	 <div id="anchor-3" class="section-post last-posts" style="background-image: url(<?php echo get_field("fond_formule"); ?>)">
		<div class="container">
			<div class="archive-main row">
				<?php //Contenu principale de la section ?>
				<div class="col-sm-8">
					<div class="archive-main-head">
				<h2 class="left-full-border">Formule</h2>
				 <p>&nbsp;</p>
			<div class="single-body">
			<p><?php echo get_field("texte_formule"); ?> </p>
			</div>
			</div>		 
				</div>
				<?php //Sidebar de droite ?>
				<div class="col-sm-4 ">
					<div class="rest-img"><img src="<?php echo get_field("photo_manager"); ?>" width="304" alt="">
						<p class="rest-img-content"><?php echo get_field("texte_manager"); ?></p>
					</div>
					</div>
			
			<div class="clr"></div>
		</div>
		<a class="scroll-btn" href="#anchor-4" data-scroll></a>
	</div>
	 </div>
	 <div id="anchor-4" class="section-post" style="background-image: url(<?php echo get_field('slider_fond'); ?>);">
		<div class="container">
		
			<h2 class="left-full-border">Photos</h2>
			 <p>&nbsp;</p>
			<div class="single-body"><?php echo get_field("photo-slider"); ?>
			</div>
			</div>
		</div>
				</div>
</main>

<?php get_footer();
