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
- Contact Form 7 : Gestion des formulaires
- ACF : Gestion des Custom Field

## Shortcodes
Ci dessous sont listés l'ensemble des shortcodes ajouté dans ce thème

| Shortcode  | Paramètre | Fonctionnalité | Utilisation |
|:----------:|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------|
| [staff] | - limit (définis la limite de post affichés : par défaut 5)  | Affiche les custom-post staff sous forme carré | - Homepage makeici.org<br> - Page contact |
| [form] | - value (Contenu du bouton de formulaire)<br> - get (spécifie un paramètre GET)<br> - param (Paramètre envoyer avec la requête)<br>  - class (Classe HTML du bouton de formulaire)<br> - action (Action javascript, par défault classic_form pour la plupart) | Affiche un bouton qui au clique lance une requête ajax et affiche le formulaire | Tout les formulaires excepté ceux de woocommerce |
| [frame] | - value (contenu du cadre) | Affiche une valeure en jaune avec un encadré  | Utiliser dans la section parc machine de la page d'accueil |
| [carousel] | - category (Définis la categorie des formations à affiché) <br> - except (Permet de ne pas afficher un certains post en passant son id)<br> - style (Style du carousel => par défaut detail mais peut être compact)  <br> | Affiche un carousel des formations | - Page formation<br> - Page produit (produit suggéré) |
| [ico] | - value (valeur de l'icone, peut être un font-awesome)<br> - size (par defaut small)<br> - class (class css supplémentaire) | Affiche un icône font-awesome ou l'un de ceux la : <br>atelier-partage - machine - 2 - casier - coaching - entrepreneur - office - expo - financement - formation - international - logistique - strong | Nulle part |

## Fonctions du thème

`display_website_logo()` : Helpers qui affiche le logo  




## Todo
- barre du footer au scroll
