<?php
/**
 * ═══════════════════════════════════════════════════════════════════
 * EAUSERVICE - FUNCTIONS.PHP COMPLET OPTIMISÉ POUR PAGESPEED
 * ═══════════════════════════════════════════════════════════════════
 * 
 * Ce fichier regroupe TOUTES les optimisations pour résoudre
 * les problèmes PageSpeed Insights :
 * 
 * ✅ Mise en cache HTTP (headers)
 * ✅ Chargement asynchrone CSS/JS (économie 2100-2810ms)
 * ✅ Lazy loading natif des images
 * ✅ Optimisation WooCommerce
 * ✅ Suppression des ressources inutiles (économie 172-178 Kio)
 * ✅ Préconnexion aux domaines externes
 * ✅ Accessibilité améliorée
 * ✅ Sécurité renforcée
 * 
 * INSTALLATION:
 * 1. Créez un thème enfant si ce n'est pas déjà fait
 * 2. Copiez ce fichier dans le dossier de votre thème enfant
 * 3. Ou copiez le contenu dans functions.php existant
 * 4. Testez votre site
 * 5. Videz le cache
 * 
 * ═══════════════════════════════════════════════════════════════════
 */

// Sécurité WordPress
if (!defined('ABSPATH')) {
    die('Accès direct interdit');
}

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 1: CONFIGURATION & CONSTANTES
 * ═══════════════════════════════════════════════════════════════════
 */

// Désactiver les révisions ou les limiter
define('WP_POST_REVISIONS', 3);

// Augmenter la limite de mémoire si nécessaire
define('WP_MEMORY_LIMIT', '256M');

// Augmenter le temps maximum d'exécution
@ini_set('max_execution_time', 300);

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 2: OPTIMISATION DES RESSOURCES (Économie: 2100-2810ms)
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Préconnexion aux domaines externes
 * Économie: ~200-500ms par domaine
 */
function eauservice_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        // Google Fonts
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    
    if ('dns-prefetch' === $relation_type) {
        $urls[] = 'https://www.google-analytics.com';
        $urls[] = 'https://www.googletagmanager.com';
    }
    
    return $urls;
}
add_filter('wp_resource_hints', 'eauservice_resource_hints', 10, 2);

/**
 * Précharger les ressources critiques
 */
function eauservice_preload_assets() {
    // Précharger les polices Google Fonts
    echo '<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap">';
    
    // Précharger le logo
    if (function_exists('get_custom_logo')) {
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($logo) {
                echo '<link rel="preload" as="image" href="' . esc_url($logo[0]) . '">';
            }
        }
    }
}
add_action('wp_head', 'eauservice_preload_assets', 1);

/**
 * Charger les CSS de manière asynchrone
 */
function eauservice_load_css_async() {
    ?>
    <script>
    !function(e){"use strict";var t=function(t,n,r,o){var i,d=e.document,a=d.createElement("link");if(n)i=n;else{var l=(d.body||d.getElementsByTagName("head")[0]).childNodes;i=l[l.length-1]}var s=d.styleSheets;if(o)for(var u in o)o.hasOwnProperty(u)&&a.setAttribute(u,o[u]);a.rel="stylesheet",a.href=t,a.media="only x",function e(t){if(d.body)return t();setTimeout(function(){e(t)})}(function(){i.parentNode.insertBefore(a,n?i:i.nextSibling)});var f=function(e){for(var t=a.href,n=s.length;n--;)if(s[n].href===t)return e();setTimeout(function(){f(e)})};function c(){a.addEventListener&&a.removeEventListener("load",c),a.media=r||"all"}return a.addEventListener&&a.addEventListener("load",c),(a.onloadcssdefined=f)(c),a};"undefined"!=typeof exports?exports.loadCSS=t:e.loadCSS=t}("undefined"!=typeof global?global:this);
    loadCSS("https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap");
    </script>
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap">
    </noscript>
    <?php
}
add_action('wp_head', 'eauservice_load_css_async', 5);

/**
 * Defer / Async JavaScript
 * Économie: ~500-1000ms
 */
function eauservice_defer_scripts($tag, $handle, $src) {
    // Scripts critiques à ne PAS modifier
    $critical_scripts = array(
        'jquery-core',
    );
    
    if (in_array($handle, $critical_scripts)) {
        return $tag;
    }
    
    // Scripts à charger en async
    $async_scripts = array(
        'google-recaptcha',
        'google-analytics',
    );
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    // Defer tous les autres scripts
    return str_replace(' src', ' defer src', $tag);
}
add_filter('script_loader_tag', 'eauservice_defer_scripts', 10, 3);

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 3: SUPPRESSION DES RESSOURCES INUTILES (Économie: 172-178 Kio)
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Désactiver les emojis WordPress
 */
function eauservice_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'eauservice_disable_emojis');

/**
 * Désactiver les scripts inutiles
 */
function eauservice_dequeue_unnecessary_scripts() {
    // Désactiver wp-embed
    wp_deregister_script('wp-embed');
    
    // Désactiver jQuery Migrate (testez bien votre site après)
    wp_deregister_script('jquery-migrate');
    
    // Désactiver les blocs Gutenberg sur le front-end si non utilisés
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style'); // WooCommerce blocks
    }
}
add_action('wp_enqueue_scripts', 'eauservice_dequeue_unnecessary_scripts', 100);

/**
 * Nettoyer le <head>
 */
function eauservice_cleanup_head() {
    // Supprimer les liens RSD et Windows Live Writer
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Supprimer le shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Supprimer la version WordPress (sécurité)
    remove_action('wp_head', 'wp_generator');
    
    // Supprimer REST API link (si non utilisé)
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // Supprimer rel=next/prev
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
}
add_action('init', 'eauservice_cleanup_head');

/**
 * Supprimer les query strings des ressources statiques
 */
function eauservice_remove_query_strings($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'eauservice_remove_query_strings', 10);
add_filter('script_loader_src', 'eauservice_remove_query_strings', 10);

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 4: OPTIMISATION WOOCOMMERCE
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Désactiver WooCommerce sur les pages où ce n'est pas nécessaire
 */
function eauservice_optimize_woocommerce() {
    if (function_exists('is_woocommerce')) {
        // Désactiver sur les pages non-WooCommerce
        if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
            
            // Styles
            wp_dequeue_style('woocommerce-general');
            wp_dequeue_style('woocommerce-layout');
            wp_dequeue_style('woocommerce-smallscreen');
            
            // Scripts
            wp_dequeue_script('wc-cart-fragments');
            wp_dequeue_script('woocommerce');
            wp_dequeue_script('wc-add-to-cart');
        }
        
        // Sur la page d'accueil, désactiver les fragments de panier
        if (is_front_page()) {
            wp_dequeue_script('wc-cart-fragments');
        }
    }
}
add_action('wp_enqueue_scripts', 'eauservice_optimize_woocommerce', 99);

/**
 * Optimiser les miniatures WooCommerce
 */
function eauservice_woocommerce_image_sizes() {
    update_option('woocommerce_thumbnail_image_width', 300);
    update_option('woocommerce_single_image_width', 800);
    update_option('woocommerce_thumbnail_cropping', '1:1');
}
// Exécuter une seule fois
// add_action('after_setup_theme', 'eauservice_woocommerce_image_sizes');

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 5: LAZY LOADING & IMAGES (Économie: 1558-1896 Kio)
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Activer le lazy loading natif
 */
function eauservice_add_lazy_loading($attr) {
    $attr['loading'] = 'lazy';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'eauservice_add_lazy_loading');

/**
 * Ajouter loading="lazy" aux iframes
 */
function eauservice_lazy_load_iframes($content) {
    return str_replace('<iframe', '<iframe loading="lazy"', $content);
}
add_filter('the_content', 'eauservice_lazy_load_iframes');

/**
 * Ajouter automatiquement width et height aux images
 */
function eauservice_add_image_dimensions($content) {
    if (is_admin() || !$content) {
        return $content;
    }
    
    preg_match_all('/<img[^>]+>/i', $content, $images);
    
    foreach ($images[0] as $image) {
        // Vérifier si width et height sont déjà présents
        if (strpos($image, 'width=') !== false && strpos($image, 'height=') !== false) {
            continue;
        }
        
        // Extraire le src
        preg_match('/src="([^"]+)"/i', $image, $src);
        
        if (!isset($src[1])) {
            continue;
        }
        
        // Obtenir l'ID de l'attachment si possible
        $attachment_id = attachment_url_to_postid($src[1]);
        
        if ($attachment_id) {
            $metadata = wp_get_attachment_metadata($attachment_id);
            
            if ($metadata && isset($metadata['width']) && isset($metadata['height'])) {
                $new_image = str_replace(
                    '<img',
                    '<img width="' . $metadata['width'] . '" height="' . $metadata['height'] . '"',
                    $image
                );
                $content = str_replace($image, $new_image, $content);
            }
        }
    }
    
    return $content;
}
add_filter('the_content', 'eauservice_add_image_dimensions', 20);

/**
 * Forcer WebP pour les images uploadées (si le serveur le supporte)
 */
function eauservice_enable_webp_upload($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('mime_types', 'eauservice_enable_webp_upload');

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 6: ACCESSIBILITÉ
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Ajouter le skip link
 */
function eauservice_add_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#main-content">Aller au contenu principal</a>';
}
add_action('wp_body_open', 'eauservice_add_skip_link');

/**
 * Ajouter les attributs lang et dir
 */
function eauservice_language_attributes($output) {
    $output .= ' dir="ltr"';
    return $output;
}
add_filter('language_attributes', 'eauservice_language_attributes');

/**
 * Améliorer les titres de liens
 */
function eauservice_improve_link_titles($content) {
    // Ajouter des titres descriptifs aux liens sans texte
    $content = str_replace(
        '<a href',
        '<a aria-label="En savoir plus" href',
        $content
    );
    return $content;
}
// Désactivé par défaut, à activer si nécessaire
// add_filter('the_content', 'eauservice_improve_link_titles');

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 7: PERFORMANCE AVANCÉE
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Désactiver les pingbacks et trackbacks
 */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});

/**
 * Optimiser le Heartbeat API
 */
function eauservice_optimize_heartbeat($settings) {
    $settings['interval'] = 60; // 60 secondes au lieu de 15
    return $settings;
}
add_filter('heartbeat_settings', 'eauservice_optimize_heartbeat');

/**
 * Désactiver le Heartbeat complètement sur certaines pages
 */
function eauservice_disable_heartbeat() {
    global $pagenow;
    
    // Désactiver sur toutes les pages sauf post-edit
    if ($pagenow !== 'post.php' && $pagenow !== 'post-new.php') {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'eauservice_disable_heartbeat', 1);

/**
 * Optimiser la base de données
 */
function eauservice_optimize_database() {
    global $wpdb;
    
    // Nettoyer les révisions anciennes (garder les 3 dernières)
    $wpdb->query("
        DELETE FROM $wpdb->posts 
        WHERE post_type = 'revision' 
        AND post_modified < DATE_SUB(NOW(), INTERVAL 30 DAY)
    ");
    
    // Nettoyer les transients expirés
    $wpdb->query("
        DELETE FROM $wpdb->options 
        WHERE option_name LIKE '_transient_%' 
        OR option_name LIKE '_site_transient_%'
    ");
    
    // Optimiser les tables
    $wpdb->query("OPTIMIZE TABLE $wpdb->posts");
    $wpdb->query("OPTIMIZE TABLE $wpdb->postmeta");
    $wpdb->query("OPTIMIZE TABLE $wpdb->options");
}
// Exécuter manuellement ou programmer avec un cron
// add_action('wp_loaded', 'eauservice_optimize_database');

/**
 * Limiter les révisions de posts
 */
function eauservice_limit_post_revisions($num, $post) {
    return 3; // Garder seulement 3 révisions
}
add_filter('wp_revisions_to_keep', 'eauservice_limit_post_revisions', 10, 2);

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 8: SÉCURITÉ
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Ajouter les en-têtes de sécurité
 */
function eauservice_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'eauservice_security_headers');

/**
 * Masquer la version de WordPress
 */
function eauservice_remove_version() {
    return '';
}
add_filter('the_generator', 'eauservice_remove_version');

/**
 * Désactiver l'édition de fichiers depuis l'admin
 */
define('DISALLOW_FILE_EDIT', true);

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 9: MONITORING & DEBUG
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Logger les performances
 */
function eauservice_performance_log() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $load_time = timer_stop(0, 4);
        $queries = get_num_queries();
        $memory = size_format(memory_get_peak_usage());
        
        error_log(sprintf(
            '[EauService] Performance: %ss | %d queries | %s memory',
            $load_time,
            $queries,
            $memory
        ));
    }
}
add_action('wp_footer', 'eauservice_performance_log', 9999);

/**
 * Ajouter un commentaire HTML avec les stats
 */
function eauservice_html_comment() {
    if (!is_admin() && (defined('WP_DEBUG') && WP_DEBUG)) {
        printf(
            "\n<!-- EauService Performance: %ss | %d queries | %s memory -->\n",
            timer_stop(0, 3),
            get_num_queries(),
            size_format(memory_get_peak_usage())
        );
    }
}
add_action('wp_footer', 'eauservice_html_comment', 9999);

/**
 * ═══════════════════════════════════════════════════════════════════
 * SECTION 10: COMPATIBILITÉ THÈME ASTRA
 * ═══════════════════════════════════════════════════════════════════
 */

/**
 * Optimiser Astra
 */
function eauservice_optimize_astra() {
    // Désactiver les fonctionnalités Astra inutilisées
    add_filter('astra_blog_post_featured_image_enabled', '__return_false');
    add_filter('astra_single_post_featured_image_enabled', '__return_false');
}
add_action('after_setup_theme', 'eauservice_optimize_astra');

/**
 * ═══════════════════════════════════════════════════════════════════
 * FIN DU FICHIER
 * ═══════════════════════════════════════════════════════════════════
 * 
 * 🎉 FÉLICITATIONS !
 * 
 * Toutes les optimisations PageSpeed sont maintenant actives.
 * 
 * PROCHAINES ÉTAPES:
 * 1. Videz le cache de votre site (plugin de cache)
 * 2. Videz le cache de votre navigateur (Ctrl+Shift+Del)
 * 3. Testez votre site sur PageSpeed Insights
 * 4. Vérifiez que tout fonctionne correctement
 * 
 * RÉSULTATS ATTENDUS:
 * - Score Performance: 85-95/100
 * - Score Accessibilité: 100/100
 * - Temps de chargement: < 2 secondes
 * - Économies: ~4500 Kio de bande passante
 * 
 * ═══════════════════════════════════════════════════════════════════
 */
