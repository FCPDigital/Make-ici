<?php
/**
 * Template Name: Produit Pro
 */

	$product = get_post();

get_header();
?>
<main id="single-product single-product-pro" class="site-main container-fluid" role="main">
	<!-- Landing -->
	<div class="row section background background--mask" style="background-image: url(<?php echo get_template_directory_uri().'/assets/images/bg-1.jpg' ?> ); ">
		<div class="container">
			<div class="row margin-bottom-small">
				<div class="col-sm-12">
					<h1 class="left-full-border title margin-top-big"><?php echo get_the_title(); ?></h1>
					<p class="font-size-b bold color-white margin-top-small">
						<?php echo get_post()->post_content; ?>
					</p>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Description -->
	<div class="row section background--white">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php the_field("bloc_texte_1"); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row section background background--mask" style="background-image: url(<?php echo get_template_directory_uri().'/assets/images/bg-1.jpg' ?> ); ">
		<div class="container">
			<div class="row margin-bottom-small color-white">
				<div class="col-sm-12 margin-bottom-medium">
					<ul class="ul styled">
						<li>10% de théorie, 90% de pratique : <a href="<?php the_field("url_program"); ?>" class="color-white">Voici le programme détaillé</a></li>
						<li>Découvrez ICI Montreuil et la formation Entrepreneur-Maker en vidéo</li>
					</ul>
				</div>
				<div class="col-sm-6">
					<iframe src="https://player.vimeo.com/video/212746280" width="420" height="300" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<p class="margin-top-small">La formation Entreoreneur-Maker résumé en 5 min</p>
				</div>
				<div class="col-sm-6">
					<iframe src="https://player.vimeo.com/video/207325945" width="420" height="300" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<p class="margin-top-small">La formation Entrepreneur-Maker résumé en 5 min</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Yellow -->
	<div class="row section background background--mask background--mask-yellow" style="background-image: url(<?php echo get_template_directory_uri().'/assets/images/bg-2.jpg' ?>);">
		<div class="container">
			<div class="row">
				<div id="date_data" style="display: none;">
					<?php echo get_field("date_data"); ?>
				</div>
				<div class="col-sm-12">
					<p class="bold box__parent">
						<span class="col-sm-3 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="apply_period">Février - Février 2018 :</span> 
						Période de candidature
					</p>
					<p class="bold box__parent">
						<span class="col-sm-3 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="information_candidat">Jeudi 8 février 2018 : </span>
						 à 9h et 19h : sessions d'informations aux candidats et visite
					</p>
					<p class="bold box__parent">
						<span class="col-sm-3 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="entretien_day">Lundi 5 mars 2018 : </span>
						 Journée d'entretiens et d'ateliers pour 40 pré-sélectionné-e-s
					</p>
					<p class="bold box__parent">
						<span class="col-sm-3 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="formation_start">Lundi 19 mars 2018 :</span> 
						Rentre - début de la formation
					</p>
					<p class="bold box__parent">
						<span class="col-sm-3 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="formation_end">26 juillet 2018 : </span>
						 fin de la formation
					</p>
				</div>
				<!-- <div class="col-sm-5 float-right">
					<p>
						<a id="dynamic-date__selector" class="btn btn-dark" href="">
							<i class="fa fa-calendar" aria-hidden="true"></i> Consultez les autres date ici.
						</a>
					</p>
					<div id="dynamic-date__list" class="dynamic-date__list dynamic-date__list--hidden">
						
					</div>
				</div> -->
				<div class="col-sm-12">
					<div class="margin-top-medium box box--white box--block box--pad-m">
						<img class="left margin-right-medium" src="<?php echo get_template_directory_uri().'/assets/images/picto-objectif.png' ?>" alt=""/>
						<div class="left">
							<?php echo the_field("bloc_text_goal"); ?>
						</div>
						<div class="clr"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Actions -->
	<div class="row section background--white">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 border-right border-bottom padding-bottom-big">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="bubble bubble--left">
							<p>Je suis salarié ou demandeur d'emploi,<br> je veux faire<br> la formation</p>
						</div>
						<img class="height-s margin-top-medium" src="<?php echo get_template_directory_uri().'/assets/images/picto-candidat.png' ?>" alt="">
						<a href="https://docs.google.com/forms/d/e/1FAIpQLSd3LDMYQ18NzZH0JSM2Dsr4K5KNHt20M8WOso5J_0eCTHN6Sg/viewform" class="btn btn-block btn-colored">Je candidate !</a>
					</div>
					
				</div>
				<div class="col-sm-6 border-bottom">
					<div class="col-sm-6 col-sm-offset-3 padding-bottom-big">
						<div class="bubble bubble--right">
							<p>Je suis prescripteur (Pôle Emploi, OPCA, employeur) et je cherche des informations</p>
						</div>
						<img class="height-s margin-top-medium" src="<?php echo get_template_directory_uri().'/assets/images/picto-question.png' ?>" alt="">
						<?php echo do_shortcode("[form value=\"Je pose des questions\" class='btn btn-colored btn-block' param='".get_field("link_form_question")."']"); ?>
					</div>
				</div>
				<div class="col-sm-12 margin-top-medium">
					<p class="bold underline">Quelques informations complémentaires</p>
					<?php echo the_field("bloc_info_complementaire") ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row section background--black">
		<div class="center">
			<p>Une demande ? Une suggestion ? Une idée ? </p>
			<a href="<?php echo home_url(); ?>/contact" class="btn btn-light margin-top-medium">Contactez-nous !</a>
		</div>
	</div>
</main>

<?php get_footer();
