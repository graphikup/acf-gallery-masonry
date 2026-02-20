=== ACF Gallery Masonry + Lightbox ===
Contributeurs: graphikup
Tags: acf, galerie, masonry, lightbox, photos, images
Nécessite au moins: 5.5
Testé jusqu’à: 6.5
Nécessite PHP: 7.4
Tag stable: 1.0.1
Licence: GPLv2 or later
URI de la licence: https://www.gnu.org/licenses/gpl-2.0.html

Affiche un champ Galerie d’Advanced Custom Fields (ACF) sous forme de grille Masonry responsive avec une lightbox.

== Description ==

ACF Gallery Masonry + Lightbox te permet d’afficher facilement les images d’un champ Galerie ACF via une mise en page *Masonry* responsive et une lightbox moderne (GLightbox).

Idéal pour les portfolios, sites photo, ou tout contenu qui nécessite des grilles d’images propres et agréables.

Fonctionnalités :

* Compatible avec les champs Galerie ACF (format de retour tableau ou ID)
* Mise en page Masonry responsive (bibliothèque Masonry du cœur WordPress)
* Ouverture en lightbox au clic (GLightbox)
* Lazy loading (via l’attribut `loading="lazy"`)
* Plusieurs galeries sur une même page
* Aucun paramétrage requis
* Léger (pas de dépendance lourde côté WordPress)

== Installation ==

1. Téléverse le dossier du plugin dans `/wp-content/plugins/`
2. Active le plugin via le menu “Extensions” de WordPress
3. Assure-toi qu’Advanced Custom Fields (ACF) est installé et activé
4. Ajoute un champ Galerie ACF à ton article / page
5. Insère le shortcode dans ton contenu

== Utilisation ==

Shortcode :

[acf_gallery field="galerie"]

Paramètres :

* field   — (obligatoire) Nom du champ Galerie ACF
* post_id — ID d’article (optionnel, par défaut : article courant)
* size    — Taille d’image (par défaut : large)
* columns — Nombre de colonnes sur desktop (par défaut : 4)
* gap     — Espacement (gouttière) en pixels (par défaut : 14)
* class   — Classe CSS additionnelle (par défaut : acf-gallery-masonry)

Exemple :

[acf_gallery field="galerie" columns="3" size="medium" gap="20"]

== Pré-requis ==

* WordPress 5.5+
* PHP 7.4+
* Advanced Custom Fields (ACF)

== FAQ ==

= Est-ce que ce plugin nécessite ACF Pro ? =
Non. Il fonctionne avec toute version d’ACF qui propose les champs Galerie.

= Puis-je afficher plusieurs galeries sur une même page ? =
Oui. Chaque shortcode est indépendant.

= Est-ce compatible Polylang / WPML ? =
Oui. Il affiche la galerie rattachée au contenu affiché.

= Puis-je personnaliser le style ? =
Oui. Tu peux surcharger le CSS depuis ton thème.

== Notes ==

Ce plugin charge GLightbox depuis un CDN. Si tu préfères une approche “tout local”, tu peux embarquer GLightbox dans le plugin et remplacer les URLs dans le code.

== Journal des modifications ==

= 1.0.1 =
* Largeur des colonnes pilotée par le shortcode (variable CSS)
* Support de plusieurs classes CSS dans l’attribut `class`
* Chargement de `imagesloaded` depuis WordPress (plus de CDN)

= 1.0.0 =
* Version initiale
* Grille Masonry
* Intégration GLightbox
* Design responsive
* Support du lazy loading

== Notice de mise à jour ==

= 1.0.1 =
Améliorations de robustesse et de personnalisation.

== Crédits ==

Utilise :

* Masonry (bibliothèque incluse dans WordPress)
* GLightbox (https://github.com/biati-digital/glightbox)

== Licence ==

Ce plugin est distribué sous licence GPL v2 ou ultérieure.
