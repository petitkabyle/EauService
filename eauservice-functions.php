<?php
/**
 * ============================================================================
 *  EAUSERVICE — Personnalisations boutique WooCommerce
 *  ---------------------------------------------------------------------------
 *  OÙ COLLER CE CODE ?
 *  Option A (recommandée) : installer l'extension gratuite « Code Snippets »,
 *    créer un nouveau snippet, coller TOUT le contenu ci-dessous (SANS la
 *    premiere ligne <?php), choisir « Exécuter partout » et activer.
 *  Option B : coller dans le fichier functions.php de votre THEME ENFANT
 *    (Apparence > Editeur de fichiers > functions.php), à la fin du fichier,
 *    cette fois EN GARDANT tout y compris après <?php.
 *
 *  Ce fichier gère 3 choses :
 *   1) L'ORDRE des produits dans la boutique (packs en premier, dans l'ordre).
 *   2) Un bouton « Lire la suite » à côté de « Ajouter au panier » (boutique).
 *   3) Un bouton « Retour à la boutique » sur la fiche produit.
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ===========================================================================
 * 1) ORDRE PERSONNALISÉ DES PRODUITS
 *    Ordre voulu :
 *      1. Pack Eau
 *      2. Pack Events de Base
 *      3. Pack Events de Base (Covim / Lavazza)
 *      4. Pack Events Complet
 *      5. Pack (Events) Complet (Covim / Lavazza)
 *      6. Pack (Events) Complet (Gemini)
 *      7. Autres packs
 *      8. Le reste des produits
 *    Le tri se fait à l'affichage, sans rien modifier en base de données.
 * =========================================================================== */
function eauservice_pack_rank( $title ) {
	$t            = function_exists( 'mb_strtolower' ) ? mb_strtolower( $title ) : strtolower( $title );
	$has_brand    = ( strpos( $t, 'covim' ) !== false || strpos( $t, 'lavazza' ) !== false || strpos( $t, 'nespresso' ) !== false );
	$has_gemini   = ( strpos( $t, 'gemini' ) !== false );

	// 1. Pack Eau
	if ( strpos( $t, 'pack eau' ) !== false || strpos( $t, 'pack d\'eau' ) !== false ) {
		return 1;
	}
	// Packs « de base »
	if ( strpos( $t, 'de base' ) !== false && strpos( $t, 'pack' ) !== false ) {
		if ( $has_brand ) { return 3; } // 3. Pack Events de Base (Covim / Lavazza)
		return 2;                       // 2. Pack Events de Base (générique)
	}
	// Packs « complet »
	if ( strpos( $t, 'complet' ) !== false && strpos( $t, 'pack' ) !== false ) {
		if ( $has_gemini ) { return 6; } // 6. Pack Complet (Gemini)
		if ( $has_brand )  { return 5; } // 5. Pack Complet (Covim / Lavazza)
		return 4;                        // 4. Pack Events Complet (générique)
	}
	// 7. Autres packs
	if ( strpos( $t, 'pack' ) !== false ) {
		return 7;
	}
	// 8. Le reste
	return 100;
}

add_filter( 'the_posts', 'eauservice_order_shop_products', 20, 2 );
function eauservice_order_shop_products( $posts, $query ) {
	if ( is_admin() || empty( $posts ) || ! is_a( $query, 'WP_Query' ) ) {
		return $posts;
	}
	if ( ! $query->is_main_query() ) {
		return $posts;
	}
	if ( ! ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_taxonomy() ) ) ) {
		return $posts;
	}

	// Tri stable : on garde l'ordre d'origine en cas d'égalité de rang.
	$indexed = array();
	foreach ( $posts as $i => $p ) {
		$indexed[] = array(
			'rank' => eauservice_pack_rank( $p->post_title ),
			'i'    => $i,
			'post' => $p,
		);
	}
	usort(
		$indexed,
		function ( $a, $b ) {
			if ( $a['rank'] === $b['rank'] ) {
				return $a['i'] - $b['i'];
			}
			return $a['rank'] - $b['rank'];
		}
	);

	$sorted = array();
	foreach ( $indexed as $item ) {
		$sorted[] = $item['post'];
	}
	return $sorted;
}

/* ===========================================================================
 * 2) BOUTONS BOUTIQUE : « Ajouter au panier » (gros) + « Lire la suite » (petit)
 *    On enveloppe les deux dans un conteneur .es-loop-actions pour les aligner.
 * =========================================================================== */

// Ouvre le conteneur juste avant le bouton « Ajouter au panier » (prio 10).
add_action( 'woocommerce_after_shop_loop_item', 'eauservice_actions_open', 9 );
function eauservice_actions_open() {
	echo '<div class="es-loop-actions">';
}

// Ajoute le bouton « Lire la suite » juste après « Ajouter au panier ».
add_action( 'woocommerce_after_shop_loop_item', 'eauservice_loop_read_more', 15 );
function eauservice_loop_read_more() {
	global $product;
	if ( ! $product ) {
		return;
	}
	// Si le produit n'est PAS achetable (ex. prix non renseigné), WooCommerce
	// affiche déjà « Lire la suite » à la place du panier : on évite le doublon.
	if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
		return;
	}
	echo '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '" class="es-loop-readmore">'
		. esc_html__( 'Lire la suite', 'woocommerce' ) . '</a>';
}

// Ferme le conteneur.
add_action( 'woocommerce_after_shop_loop_item', 'eauservice_actions_close', 16 );
function eauservice_actions_close() {
	echo '</div>';
}

/* ===========================================================================
 * 3) FICHE PRODUIT : bouton « Retour à la boutique »
 *    Placé tout en haut du résumé produit (au-dessus du titre).
 * =========================================================================== */
add_action( 'woocommerce_single_product_summary', 'eauservice_back_to_shop', 4 );
function eauservice_back_to_shop() {
	$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/boutique/' );
	echo '<a href="' . esc_url( $shop_url ) . '" class="es-back-to-shop">&larr; '
		. esc_html__( 'Retour à la boutique', 'woocommerce' ) . '</a>';
}


/* ===========================================================================
 * 4) NOMBRE DE PRODUITS PAR PAGE
 *    Pour n'avoir que 2 pages au lieu de 3. Augmentez la valeur si besoin :
 *    elle doit etre >= (nombre total de produits / 2).
 *    Ex : 40 produits -> mettre au moins 20 ; 48 produits -> au moins 24.
 * =========================================================================== */
add_filter( 'loop_shop_per_page', 'eauservice_products_per_page', 30 );
function eauservice_products_per_page( $cols ) {
	return 12; // <-- ajustez ce nombre si vous voulez plus/moins par page (12 = 2 pages)
}

/* ===========================================================================
 * 5) IMAGES NON COUPÉES DANS LA BOUTIQUE
 *    Par defaut WooCommerce ROGNE les vignettes en carre : les produits
 *    hauts (fontaine a eau) ou larges (Nespresso Zenius) sont coupes.
 *    On force l'utilisation de l'image COMPLETE (non rognee) dans la boucle
 *    boutique. Combine au CSS (object-fit:contain), l'image s'affiche ENTIERE.
 *    -> Aucune regeneration de miniatures necessaire.
 * =========================================================================== */
add_filter( 'single_product_archive_thumbnail_size', 'eauservice_loop_image_full' );
add_filter( 'woocommerce_gallery_thumbnail_size', 'eauservice_loop_image_full' );
function eauservice_loop_image_full( $size ) {
	return 'woocommerce_single'; // taille non rognee (largeur fixe, hauteur libre)
}

// Au cas ou le theme imposerait un rognage : on force le format "non rogne".
add_filter( 'woocommerce_get_image_size_thumbnail', 'eauservice_uncrop_thumbnail' );
function eauservice_uncrop_thumbnail( $size ) {
	return array(
		'width'  => 600,
		'height' => 600,
		'crop'   => 0, // 0 = non rogne (garde les proportions, rien n'est coupe)
	);
}
