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
					<p class="margin-bottom-small">
						<strong>Impression 3D, laser, machine à bois, objets connectés, etc...</strong><br>
						Apprenez à maîtriser ces dispositifs et devenez un e-marker-euse, un professionnel-le des fablabs.
					</p>
					<a href="" class="font-size-n">Voir le programme détaillé</a>
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
				<div class="col-sm-6">
					<p class="bold box__parent">
						<span class="col-sm-6 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="apply_period">Janvier - Février 2018 :</span> 
						Période de candidature
					</p>
					<p class="bold box__parent">
						<span class="col-sm-6 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="apply_day">5 mars 2018 : </span>
						 Journée de candidature
					</p>
					<p class="bold box__parent">
						<span class="col-sm-6 box box--marge-null box--black box--font-m box--pad-s margin-right-small" data-dynamic-date="formation_start">19 mars 2018</span>
						 Début de la formation
					</p>
				</div>
				<div class="col-sm-6 float-right">
					<p>
						<a id="dynamic-date__selector" class="btn btn-dark" href="">
							<i class="fa fa-calendar" aria-hidden="true"></i> Consultez les autres date ici.
						</a>
					</p>
					<div id="dynamic-date__list" class="dynamic-date__list dynamic-date__list--hidden">
						
					</div>
				</div>
				<div class="col-sm-12">
					<div class="margin-top-medium box box--white box--block box--pad-m">
						<img class="left margin-right-medium" src="<?php echo get_template_directory_uri().'/assets/images/picto-objectif.png' ?>" alt="">
						<div>
							<p>Notre objectif est d'accueillir :</p>
							<ul class="styled">
								<li>7 personnes qui peuvent faire financer leur formation (par leur employeur ou sur fonds propres)</li>
								<li>7 jeunes en recherche d'emploi originaire de Montreuil et quartiers limitrophes.</li>
							</ul>
							<p>Non diplomé-e-s bienvenu-e-s : c'est la motivation qui compte ! :-)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Actions -->
	<div class="row separator--center section background--white">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="bubble bubble--left">
						<p>Je suis salarié ou demandeur d'emploi,<br> je veux faire<br> la formation</p>
					</div>
					<img class="height-s margin-top-medium" src="<?php echo get_template_directory_uri().'/assets/images/picto-salarie.png' ?>" alt="">
					<a href="" class="btn btn-block btn-colored">Je candidate</a>
				</div>
				<div class="col-sm-3 col-sm-offset-6">
					<div class="bubble bubble--right">
						<p>Je suis prescripteur (Pôle Emploi, OPCA, employeur) et je cherche des informations</p>
					</div>
					<img class="height-s margin-top-medium" src="<?php echo get_template_directory_uri().'/assets/images/picto-prescripteur.png' ?>" alt="">
					<a href="" class="btn btn-block btn-colored">Je candidate</a>
				</div>
			</div>
		</div>
	</div>

	<div class="row section background--black">
		<div class="center">
			<p>Une demande ? Une suggestion ? Une idée ? </p>
			<a href="" class="btn btn-light margin-top-medium">Contactez-nous !</a>
		</div>
	</div>
</main>

<?php get_footer();
