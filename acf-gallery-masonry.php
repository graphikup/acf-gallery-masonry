<?php
/**
 * Plugin Name: ACF Gallery Masonry + Lightbox
 * Plugin URI: https://github.com/graphikup/acf-gallery-masonry
 * GitHub Plugin URI: https://github.com/graphikup/acf-gallery-masonry
 * Description: Shortcode [acf_gallery] pour afficher un champ Galerie ACF sous forme de grille Masonry responsive avec une lightbox.
 * Version: 1.0.2
 * Author: Graphikup
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: acf-gallery-masonry
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

final class ACF_Gallery_Masonry_Lightbox
{
    public const VERSION = '1.0.2';
    public const HANDLE  = 'acf-gallery-masonry-lightbox';

    /** @var bool */
    private static $needs_assets = false;

    public function __construct()
    {
        add_shortcode('acf_gallery', [$this, 'shortcode']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    /**
     * Shortcode:
     *   [acf_gallery field="galerie" columns="4" size="large" gap="14" class="acf-gallery-masonry"]
     */
    public function shortcode($atts): string
    {
        $atts = shortcode_atts([
            'field'   => '',
            'post_id' => get_the_ID(),
            'size'    => 'large',
            'columns' => 4,
            'gap'     => 14,
            'class'   => 'acf-gallery-masonry',
        ], (array) $atts, 'acf_gallery');

        if (empty($atts['field'])) {
            return '';
        }

        if (!function_exists('get_field')) {
            return '<!-- ACF not active: get_field() missing -->';
        }

        $images = get_field($atts['field'], $atts['post_id']);
        if (empty($images) || !is_array($images)) {
            return '';
        }

        self::$needs_assets = true;

        $columns = max(1, (int) $atts['columns']);
        $gap     = max(0, (int) $atts['gap']);

        // Allow multiple classes.
        $classes = array_filter(preg_split('/\s+/', (string) $atts['class']));
        $classes = array_map('sanitize_html_class', $classes);
        $class_attr = trim(implode(' ', $classes));

        // CSS variables for layout.
        $style_attr = sprintf('--agm-cols:%d;--agm-gap:%dpx;', $columns, $gap);

        $html  = '<div class="' . esc_attr($class_attr) . '" style="' . esc_attr($style_attr) . '" data-gap="' . esc_attr((string) $gap) . '">';
        $html .= '<div class="agm-grid-sizer"></div>';

        foreach ($images as $img) {
            $id = null;

            // Support ACF return formats: array / ID
            if (is_array($img) && !empty($img['ID'])) {
                $id = (int) $img['ID'];
            } elseif (is_numeric($img)) {
                $id = (int) $img;
            }

            if (!$id) {
                continue;
            }

            $full = wp_get_attachment_image_src($id, 'full');
            if (!$full) {
                continue;
            }

            $full_url = $full[0];
            $caption  = wp_get_attachment_caption($id);

            $thumb = wp_get_attachment_image($id, $atts['size'], false, [
                'loading' => 'lazy',
                'class'   => 'acf-gallery-img',
            ]);

            $html .= '<a class="agm-item glightbox" href="' . esc_url($full_url) . '"';
            if (!empty($caption)) {
                $html .= ' data-title="' . esc_attr(wp_strip_all_tags($caption)) . '"';
            }
            $html .= '>';
            $html .= $thumb;
            $html .= '</a>';
        }

        $html .= '</div>';

        return $html;
    }

    public function enqueue_assets(): void
    {
        if (!self::$needs_assets) {
            return;
        }

        // Masonry + imagesLoaded (WordPress core libs)
        wp_enqueue_script('masonry');
        wp_enqueue_script('imagesloaded');

        // GLightbox (CDN) — for production, you can bundle it locally if you prefer.
        wp_enqueue_style(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css',
            [],
            null
        );
        wp_enqueue_script(
            'glightbox',
            'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js',
            [],
            null,
            true
        );

        // Lightweight CSS
        wp_register_style(self::HANDLE, false, [], self::VERSION);
        wp_enqueue_style(self::HANDLE);

        $css = <<<CSS
/* Base container */
.acf-gallery-masonry{
  width: 100%;
}

/* Column sizing driven by shortcode: --agm-cols */
.acf-gallery-masonry .agm-grid-sizer,
.acf-gallery-masonry .agm-item{
  width: calc(100% / var(--agm-cols, 4));
}

/* Responsive defaults (override in your theme if needed) */
@media (max-width: 1024px){
  .acf-gallery-masonry .agm-grid-sizer,
  .acf-gallery-masonry .agm-item{
    width: calc(100% / min(var(--agm-cols, 4), 3));
  }
}
@media (max-width: 640px){
  .acf-gallery-masonry .agm-grid-sizer,
  .acf-gallery-masonry .agm-item{
    width: calc(100% / min(var(--agm-cols, 4), 2));
  }
}

.acf-gallery-masonry .agm-item{
  display: block;
}

.acf-gallery-masonry .agm-item img{
  width: 100%;
  height: auto;
  display: block;
  border-radius: 6px;
}
CSS;

        wp_add_inline_style(self::HANDLE, $css);

        // JS init inline
        wp_add_inline_script('glightbox', <<<JS
document.addEventListener('DOMContentLoaded', function () {

  // Lightbox
  if (window.GLightbox) {
    GLightbox({ selector: '.acf-gallery-masonry .glightbox' });
  }

  // Masonry (wait for images)
  document.querySelectorAll('.acf-gallery-masonry').forEach(function(grid){
    var gap = parseInt(grid.dataset.gap || '14', 10);

    var initMasonry = function(){
      if (window.Masonry) {
        new Masonry(grid, {
          itemSelector: '.agm-item',
          percentPosition: true,
          columnWidth: '.agm-grid-sizer',
          gutter: gap
        });
      }
    };

    if (window.imagesLoaded) {
      imagesLoaded(grid, initMasonry);
    } else {
      initMasonry();
    }
  });

});
JS, 'after');
    }
}

new ACF_Gallery_Masonry_Lightbox();
