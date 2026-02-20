# ACF Gallery Masonry + Lightbox

Affiche un champ **Galerie ACF** via le shortcode `[acf_gallery]` sous forme de grille **Masonry** responsive + **lightbox** (GLightbox).

## Installation
1. Copie le dossier `acf-gallery-masonry` dans `wp-content/plugins/`
2. Active l’extension dans WordPress
3. Assure-toi qu’ACF est actif

## Utilisation
```text
[acf_gallery field="galerie"]
```

Paramètres :
- `field` (obligatoire) : nom du champ ACF Galerie
- `post_id` : ID de l’article (par défaut : article courant)
- `size` : taille d’image WordPress (par défaut : `large`)
- `columns` : colonnes desktop (par défaut : `4`)
- `gap` : gouttière en pixels (par défaut : `14`)
- `class` : classe(s) CSS (par défaut : `acf-gallery-masonry`)

Exemple :
```text
[acf_gallery field="galerie" columns="3" size="medium" gap="20"]
```

## Notes
GLightbox est chargé depuis un CDN. Si tu veux du 100% local (sans CDN), il suffit d’embarquer GLightbox dans `/assets/` et de remplacer les URLs dans le code.

## Licence
GPL-2.0-or-later
