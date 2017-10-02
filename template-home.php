<?php
/**
 * Template Name: Accueil
 */

get_header();
while ( have_posts() ) : the_post();
$postCur = get_post(); // On stocke le post courant pour éviter le bug de la boucle get_last_posts() qui écrase le post_data principale.

?>


<main id="page" class="site-main homepage" role="main">

	<div class="landing" style="background-image:url(<?php echo get_field('bg_main', $postCur); ?>);">	 
	 <div class="container">
			<div class="landing-legend">
				<h2>ICI MONTREUIL</h2> est une manufacture collaborative et solidaire pour les artisans, artistes,<br> designers, startups et entrepreneurs du “Faire”
			</div>
		</div>
		<a id="scroll" href="#anchor-1" data-scroll>Découvrez ICI Montreuil</a>
	</div>
	<div id="anchor-1" class="section-post" style="background-image: url(<?php echo get_the_post_thumbnail_url($postCur); ?>);">
		<div class="container">
			<h1 class="left-full-border"><?php echo get_the_title(); ?></h1>
			<div class="single-body">
				<?php the_content($postCur); ?>
			</div>
		</div>
		<a class="scroll-btn" href="#anchor-2" data-scroll></a>
	</div>
	
	<div id="anchor-2" class="section-post equipements" style="background-image:url(<?php echo get_field('bg_equipement', $postCur); ?>);">
		<div class="container">
			<h2 class="left-full-border">Equipements et services</h2>
			 <?php echo get_field("equipement", $postCur); ?>
			 <div class="single-body equipements-container">
				<div class="equipements-item" id="post-413">
					<div class="equipements-item-content">
						<div class="equipements-title-container">
							<p class="equipements-title">MÉTAL</p>
						</div>
						<div class="equipements-content">
							<p>Découpeuse Plasma Plein Format à commande numérique (2000×1200)<span class="equip">|</span> Scie fraise <spna class="equip">|</span> Perceuse à colonne <span class="equip">|</span> Cintreuse <span class="equip">|</span> Meuleuse <span class="equip">|</span> Postes à souder (MIG/MAG, TIG, à électrode enrobée) <span class="equip">|</span> Tour conventionnel…
							</p>
						</div>
					</div>
				</div>
				<div class="equipements-item" id="post-414">
					<div class="equipements-item-content">
						<div class="equipements-title-container">
							<p class="equipements-title">BOIS</p>
						</div>
						<div class="equipements-content">
							<p>Fraiseuse / Défonceuse à commande numérique (2000×1200) <span class="equip">|</span> Scie à Ruban <span class="equip">|</span> Scie Circulaire <span class="equip">|</span> Combiné Raboteuse – Dégauchisseuse (Arbre à 3 fers, table 2mx41cm) <span class="equip">|</span> Fraiseuse Toupie <span class="equip">|</span> Scies à onglet <span class="equip">|</span> Ponceuse à bande <span class="equip">|</span> Scie plongeante <span class="equip">|</span> Scie sauteuse <span class="equip">|</span> Défonceuse <span class="equip">|</span> sert-joints <span class="equip">|</span> Petits outillages etc
							</p>
						</div>
					</div>
				</div>
				<div class="equipements-item" id="post-415">
					<div class="equipements-item-content">
						<div class="equipements-title-container">
							<p class="equipements-title">PLASTIQUE / PVC / VINYLE</p>
						</div>
						<div class="equipements-content">
							<p>Découpeuse Laser à <span class="equip">|</span>commande numérique (90×60), Imprimantes 3D, Découpe vinyle grand format (2000×1200), Traceur Numérique grand format (2000×1200), Imprimantes 3D…</p>
						</div>
					</div>
				</div>
				<div class="equipements-item" id="post-416">
					<div class="equipements-item-content">
						<div class="equipements-title-container">
							<p class="equipements-title">TEXTILE / CUIR / RELIURE</p>
						</div>
						<div class="equipements-content">
							<p>Surjeteuses industrielles, Piqueuses plates industrielles, Piqueuses Familiales, Matrice à boutons recouverts, Tables de coupe, Presse Industrielle, Presse à percussions, Métier à tisser, Presse hydraulique, Compresseur…</p>
						</div>
					 </div>
					</div>
					<div class="equipements-item" id="post-417">
						<div class="equipements-item-content">
							<div class="equipements-title-container">
								<p class="equipements-title">ÉLECTRONIQUE</p>
							</div>
							<div class="equipements-content">
								<p>Alimentation stabilisée, Cisaille pour Circuits Imprimés, Fers à souder, Fers à air chaud, Générateur basse fréquence, Multimètres, Oscilloscopes…</p>
							</div>
						</div>
					</div>
				 <div class="equipements-item" id="post-418">
					<div class="equipements-item-content">
						<div class="equipements-title-container">
							<p class="equipements-title">BIJOUX / MAQUETTAGE</p>
						</div>
						<div class="equipements-content">
							<p>Table de Polissage avec aspiration et éclairage intégré, Laminoir plaque et fil, Table de soudure avec Chalumeaux (Oxy/propane, Brésillien au propane), 2 tables de bijoutiers, Moteurs suspendus avec pièces à main 2050, Triboulets, Bocfil, Marteaux plats, Marteaux de ciseleur, Dés à emboutir, Bouterolles…</p>
						</div>
					</div>
				</div>
			</div>
			<a class="scroll-btn" href="#anchor-3" data-scroll></a>
		</div> 
	</div>
	<div id="anchor-3" class="section-post last-posts" style="background-image:url(<?php echo get_field('bg_last_posts', $postCur); ?>);">
		<div class="container">
			<h2 class="left-full-border">Prochaines formations</h2>
			<?php get_last_posts(); ?>
			<div class="clr"></div>
		</div>
	</div>
</main>

<?php endwhile; // End of the loop. ?>
<?php get_footer();?>