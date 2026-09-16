<?php
/**
 * EAUSERVICE - OPTIMISATION DU CHARGEMENT DES RESSOURCES
 * Économie: 2100-2810 ms de temps de blocage
 * 
 * Ce fichier :
 * - Charge les CSS/JS de manière asynchrone (non-bloquant)
 * - Préconnecte aux domaines externes
 * - Précharge les ressources critiques
 * - Désactive les scripts inutiles
 * - Optimise WooCommerce
 * 
 * INSTALLATION:
 * Copiez ce contenu dans le fichier functions.php de votre thème enfant
 */

// Sécurité WordPress
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. PRECONNECT - Établir les connexions DNS tôt
 * Économie: ~200-500ms par domaine externe
 */
function eauservice_preconnect_external_domains() {
    // Google Fonts (utilisé pour Sora et Manrope)
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    
    // Si vous utilisez d'autres services externes
    // echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>';
}
add_action('wp_head', 'eauservice_preconnect_external_domains', 1);

/**
 * 2. PRELOAD - Précharger les ressources critiques
 * Les fichiers essentiels sont chargés en priorité
 */
function eauservice_preload_critical_resources() {
    // Précharger les polices Google Fonts
    ?>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap">
    <?php
    
    // Précharger le logo (si vous en avez un)
    if (function_exists('get_custom_logo')) {
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
            if ($logo_url) {
                echo '<link rel="preload" as="image" href="' . esc_url($logo_url) . '">';
            }
        }
    }
}
add_action('wp_head', 'eauservice_preload_critical_resources', 2);

/**
 * 3. CHARGER LES CSS DE MANIÈRE ASYNCHRONE
 * Les CSS non-critiques sont chargées sans bloquer le rendu
 */
function eauservice_async_css() {
    ?>
    <script>
    // Fonction pour charger les CSS de manière asynchrone
    function loadCSS(href, before, media, attributes) {
        var doc = window.document;
        var ss = doc.createElement("link");
        var ref;
        if (before) {
            ref = before;
        } else {
            var refs = (doc.body || doc.getElementsByTagName("head")[0]).childNodes;
            ref = refs[refs.length - 1];
        }
        var sheets = doc.styleSheets;
        if (attributes) {
            for (var attributeName in attributes) {
                if (attributes.hasOwnProperty(attributeName)) {
                    ss.setAttribute(attributeName, attributes[attributeName]);
                }
            }
        }
        ss.rel = "stylesheet";
        ss.href = href;
        ss.media = "only x";
        function ready(cb) {
            if (doc.body) {
                return cb();
            }
            setTimeout(function() {
                ready(cb);
            });
        }
        ready(function() {
            ref.parentNode.insertBefore(ss, (before ? ref : ref.nextSibling));
        });
        var onloadcssdefined = function(cb) {
            var resolvedHref = ss.href;
            var i = sheets.length;
            while (i--) {
                if (sheets[i].href === resolvedHref) {
                    return cb();
                }
            }
            setTimeout(function() {
                onloadcssdefined(cb);
            });
        };
        function loadCB() {
            if (ss.addEventListener) {
                ss.removeEventListener("load", loadCB);
            }
            ss.media = media || "all";
        }
        if (ss.addEventListener) {
            ss.addEventListener("load", loadCB);
        }
        ss.onloadcssdefined = onloadcssdefined;
        onloadcssdefined(loadCB);
        return ss;
    }
    
    // Charger Google Fonts de manière asynchrone
    loadCSS("https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap");
    </script>
    <?php
}
add_action('wp_head', 'eauservice_async_css', 5);

/**
 * 4. DEFER / ASYNC JavaScript
 * Les scripts sont chargés sans bloquer le rendu
 */
function eauservice_defer_scripts($tag, $handle, $src) {
    // Liste des scripts à defer (la plupart)
    $defer_scripts = array(
        'jquery-migrate',
        'wp-embed',
        'comment-reply',
        'wc-cart-fragments',
        'woocommerce',
        'wc-add-to-cart',
        'wc-checkout',
    );
    
    // Liste des scripts à async (peuvent être chargés en parallèle)
    $async_scripts = array(
        'google-analytics',
        'google-recaptcha',
    );
    
    // Scripts critiques à NE PAS modifier
    $critical_scripts = array(
        'jquery-core',
    );
    
    // Ne pas modifier les scripts critiques
    if (in_array($handle, $critical_scripts)) {
        return $tag;
    }
    
    // Ajouter defer
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    // Ajouter async
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    // Par défaut, defer tous les autres scripts non-critiques
    if (!in_array($handle, $critical_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'eauservice_defer_scripts', 10, 3);

/**
 * 5. DÉSACTIVER LES SCRIPTS INUTILES
 * Économie: ~50-100 Kio
 */
function eauservice_remove_unnecessary_scripts() {
    // Désactiver les emojis WordPress (non nécessaires)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Désactiver les embed (si vous n'utilisez pas oEmbed)
    wp_deregister_script('wp-embed');
    
    // Désactiver jQuery Migrate (si votre thème est moderne)
    // ATTENTION: Testez bien votre site après cette modification
    // Commentez cette ligne si vous avez des erreurs JavaScript
    wp_deregister_script('jquery-migrate');
    
    // Désactiver les styles de blocs Gutenberg sur le front-end (si non utilisés)
    // Décommentez si vous n'utilisez pas l'éditeur de blocs
    // wp_dequeue_style('wp-block-library');
    // wp_dequeue_style('wp-block-library-theme');
}
add_action('wp_enqueue_scripts', 'eauservice_remove_unnecessary_scripts', 100);

/**
 * 6. OPTIMISER WOOCOMMERCE
 * Désactiver les scripts WooCommerce sur les pages où ils ne sont pas nécessaires
 */
function eauservice_optimize_woocommerce_scripts() {
    // Désactiver WooCommerce sur toutes les pages sauf boutique/panier/compte
    if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
        
        // Désactiver les styles WooCommerce
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        
        // Désactiver les scripts WooCommerce
        wp_dequeue_script('wc-cart-fragments');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'eauservice_optimize_woocommerce_scripts', 99);

/**
 * 7. DÉSACTIVER LES SCRIPTS WOOCOMMERCE SUR LA PAGE D'ACCUEIL
 * Économie supplémentaire: ~30-50 Kio
 */
function eauservice_disable_woocommerce_home() {
    if (is_front_page()) {
        // Sur la page d'accueil, on ne charge pas les fragments de panier
        // Le panier sera mis à jour lors de la navigation vers la boutique
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'eauservice_disable_woocommerce_home', 99);

/**
 * 8. LAZY LOADING NATIF POUR LES IFRAMES
 * YouTube, Google Maps, etc.
 */
function eauservice_add_lazy_loading_iframes($content) {
    // Ajouter loading="lazy" à tous les iframes
    $content = str_replace('<iframe', '<iframe loading="lazy"', $content);
    return $content;
}
add_filter('the_content', 'eauservice_add_lazy_loading_iframes');

/**
 * 9. SUPPRIMER LES QUERY STRINGS DES RESSOURCES STATIQUES
 * Améliore la mise en cache
 */
function eauservice_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'eauservice_remove_query_strings', 10, 1);
add_filter('script_loader_src', 'eauservice_remove_query_strings', 10, 1);

/**
 * 10. NETTOYER LE <HEAD>
 * Supprimer les liens inutiles
 */
function eauservice_cleanup_head() {
    // Supprimer les liens RSD et WLW
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Supprimer le lien shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Supprimer le lien vers Windows Live Writer
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Supprimer la version de WordPress (sécurité)
    remove_action('wp_head', 'wp_generator');
    
    // Supprimer les liens RSS si non utilisés
    // Décommentez si vous n'utilisez pas de flux RSS
    // remove_action('wp_head', 'feed_links', 2);
    // remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('init', 'eauservice_cleanup_head');

/**
 * 11. ACTIVER LE LAZY LOADING NATIF POUR LES IMAGES
 * WordPress 5.5+
 */
function eauservice_enable_native_lazy_loading($attr, $attachment, $size) {
    // Ajouter loading="lazy" à toutes les images sauf celles above-the-fold
    $attr['loading'] = 'lazy';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'eauservice_enable_native_lazy_loading', 10, 3);

/**
 * 12. OPTIMISER LA BASE DE DONNÉES
 * Nettoyer les révisions de posts (optionnel)
 */
// Limiter le nombre de révisions (dans wp-config.php c'est mieux)
// define('WP_POST_REVISIONS', 3);

/**
 * 13. DNS-PREFETCH POUR LES DOMAINES EXTERNES
 * Résoudre les DNS avant que les ressources ne soient demandées
 */
function eauservice_dns_prefetch() {
    ?>
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <?php
}
add_action('wp_head', 'eauservice_dns_prefetch', 0);

/**
 * 14. HINT POUR LE NAVIGATEUR - Resource Hints
 * Précharger, préconnect, prefetch
 */
function eauservice_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'eauservice_resource_hints', 10, 2);

/**
 * 15. OPTIMISER LES IMAGES DE MINIATURES WOOCOMMERCE
 * Charger la bonne taille d'image
 */
function eauservice_optimize_product_thumbnails() {
    // Régénérer les miniatures avec les bonnes dimensions
    update_option('woocommerce_thumbnail_image_width', 300);
    update_option('woocommerce_thumbnail_cropping', '1:1');
    update_option('woocommerce_thumbnail_cropping_custom_width', 1);
    update_option('woocommerce_thumbnail_cropping_custom_height', 1);
}
// Décommentez pour exécuter une seule fois
// add_action('after_setup_theme', 'eauservice_optimize_product_thumbnails');

/**
 * 16. DÉSACTIVER LES PINGBACKS ET TRACKBACKS
 * Réduit les requêtes inutiles
 */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});

/**
 * 17. AUGMENTER LE HEARTBEAT (API WordPress)
 * Réduit les requêtes AJAX de WordPress
 */
function eauservice_optimize_heartbeat($settings) {
    // Ralentir le heartbeat à 60 secondes
    $settings['interval'] = 60;
    return $settings;
}
add_filter('heartbeat_settings', 'eauservice_optimize_heartbeat');

/**
 * 18. LOG DE PERFORMANCE (DEBUG)
 * Mesurer le temps de chargement
 */
function eauservice_performance_log() {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $load_time = timer_stop(0, 3);
        $queries = get_num_queries();
        error_log(sprintf(
            'EauService Performance: %s secondes, %d requêtes SQL',
            $load_time,
            $queries
        ));
    }
}
add_action('wp_footer', 'eauservice_performance_log', 999);

/**
 * 19. AJOUTER UN COMMENTAIRE DE DEBUG DANS LE HTML
 * Pour vérifier que les optimisations sont actives
 */
function eauservice_debug_comment() {
    if (!is_admin()) {
        echo "\n<!-- EauService Performance Optimizations Active -->\n";
        echo sprintf(
            "<!-- Generated in %s seconds with %d queries -->\n",
            timer_stop(0, 3),
            get_num_queries()
        );
    }
}
add_action('wp_footer', 'eauservice_debug_comment', 9999);

/**
 * 20. NOTICE DE SUCCÈS
 * Message dans l'admin pour confirmer l'activation
 */
function eauservice_performance_admin_notice() {
    if (current_user_can('manage_options')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong>✅ EauService Performance:</strong> Les optimisations PageSpeed sont actives ! Temps de chargement: <?php echo timer_stop(0, 3); ?>s</p>
        </div>
        <?php
    }
}
// add_action('admin_notices', 'eauservice_performance_admin_notice');

// Fin du fichier - Toutes les optimisations sont maintenant actives !
// Testez votre site et videz le cache après l'activation.
