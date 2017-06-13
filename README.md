# Make ICI

Ceci est le thème du multi-site Make ICI disposé à s'appliquer aux sites Ici-Montreuil, Ici-Marseille
Ce thème wordpress utilise le préprocesseur SCSS dont le fonctionnement est expliqué ci-dessous.

Afin de faciliter le travail en collaboration, le thème est versionner sur github à l'adresse suivante : <a href="https://github.com/SolalDR/Make-ici">https://github.com/SolalDR/Make-ici</a>

Les différentes fonctionnalité, shortcode, plugin nécessaire sont précisé ci-dessous.


## Fonctionnement de SCSS
 <a href="http://sass-lang.com/install">Installer sass / scss</a>
- Tous les fichiers de style sont situés dans le dossier scss et doivent être modifier depuis ce dossier.  
- Les informations du thèmes sont spécifiées en haut de la feuille de style : `scss/style.scss`
- Pour commencer le watching de sass et rendre les modifications de style effective, lancez la commande (depuis le dossier du thème) `sass --watch scss/style.scss:style.css`


## Dépendance du thème
- WooCommerce : Gestion des formations
- WP-Form : Gestion des formulaires
- ACF : Gestion des Custom Field

## Shortcodes
Ci dessous sont listés l'ensemble des shortcodes ajouté dans ce thème

## Fonctions du thème

`display_website_logo()` : Helpers qui affiche le logo  


## Todo

- Call to action homepage appelle au scroll
- Super bloc dans Formations
- timeline
- Formation => c2a prochaine session | Pas de prochaine session
- Ajout au panier même quand il n'y a pas de session
- barre du footer au scroll
