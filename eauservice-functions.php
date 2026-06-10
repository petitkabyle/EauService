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
		. esc_html__( 'En savoir plus', 'woocommerce' ) . '</a>';
}

/* Renomme le bouton par défaut "Lire la suite" (produit sans prix) en
   "En savoir plus" pour rester cohérent. */
add_filter( 'woocommerce_product_add_to_cart_text', 'eauservice_add_to_cart_text', 10, 2 );
function eauservice_add_to_cart_text( $text, $product ) {
	if ( $product && ( ! $product->is_purchasable() || ! $product->is_in_stock() ) ) {
		return esc_html__( 'En savoir plus', 'woocommerce' );
	}
	return $text;
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


/* ===========================================================================
 * 6) LIVRAISON ÉVÉNEMENTIELLE — champs personnalisés sur la commande
 *    Secteur événementiel : livraison sur salons, congrès, événements.
 *    On ajoute une section dédiée avec un maximum d'infos logistiques.
 *    Ces champs sont enregistrés dans la commande, affichés en back-office
 *    ET dans les e-mails de commande.
 * =========================================================================== */

// Liste centralisée des champs (clé => libellé) pour réutilisation.
function eauservice_event_fields_list() {
	return array(
		'es_event_name'    => 'Nom de l’événement / salon / congrès',
		'es_venue_name'    => 'Lieu / site (parc expo, palais des congrès…)',
		'es_venue_address' => 'Adresse complète du lieu de livraison',
		'es_hall'          => 'Hall / Pavillon',
		'es_stand'         => 'N° de stand / emplacement',
		'es_delivery_date' => 'Date de livraison souhaitée',
		'es_delivery_time' => 'Créneau horaire de livraison',
		'es_pickup_date'   => 'Date de reprise / fin de location',
		'es_pickup_time'   => 'Créneau horaire de reprise',
		'es_onsite_contact'=> 'Contact sur place (nom)',
		'es_onsite_phone'  => 'Téléphone du contact sur place',
		'es_access_notes'  => 'Instructions d’accès / logistique',
	);
}

// 6a. Affichage de la section sur la page de commande.
add_action( 'woocommerce_after_order_notes', 'eauservice_event_delivery_fields' );
function eauservice_event_delivery_fields( $checkout ) {
	echo '<div id="eauservice_event_delivery" class="es-event-section">';
	echo '<h3>' . esc_html__( 'Informations de livraison événementielle', 'woocommerce' ) . '</h3>';
	echo '<p class="es-event-intro">Indiquez les détails du lieu (salon, congrès, événement) pour une livraison et une reprise parfaitement organisées.</p>';

	woocommerce_form_field( 'es_event_name', array(
		'type' => 'text', 'class' => array( 'form-row-wide' ), 'required' => true,
		'label' => 'Nom de l’événement / salon / congrès',
		'placeholder' => 'Ex : Monaco Yacht Show 2026',
	), $checkout->get_value( 'es_event_name' ) );

	woocommerce_form_field( 'es_venue_name', array(
		'type' => 'text', 'class' => array( 'form-row-wide' ), 'required' => true,
		'label' => 'Lieu / site',
		'placeholder' => 'Ex : Palais des Festivals, Cannes',
	), $checkout->get_value( 'es_venue_name' ) );

	woocommerce_form_field( 'es_venue_address', array(
		'type' => 'text', 'class' => array( 'form-row-wide' ), 'required' => true,
		'label' => 'Adresse complète du lieu de livraison',
		'placeholder' => 'N°, rue, code postal, ville',
	), $checkout->get_value( 'es_venue_address' ) );

	woocommerce_form_field( 'es_hall', array(
		'type' => 'text', 'class' => array( 'form-row-first' ),
		'label' => 'Hall / Pavillon', 'placeholder' => 'Ex : Hall 3',
	), $checkout->get_value( 'es_hall' ) );

	woocommerce_form_field( 'es_stand', array(
		'type' => 'text', 'class' => array( 'form-row-last' ),
		'label' => 'N° de stand / emplacement', 'placeholder' => 'Ex : Stand B12',
	), $checkout->get_value( 'es_stand' ) );

	woocommerce_form_field( 'es_delivery_date', array(
		'type' => 'date', 'class' => array( 'form-row-first' ), 'required' => true,
		'label' => 'Date de livraison souhaitée',
	), $checkout->get_value( 'es_delivery_date' ) );

	woocommerce_form_field( 'es_delivery_time', array(
		'type' => 'text', 'class' => array( 'form-row-last' ),
		'label' => 'Créneau horaire de livraison', 'placeholder' => 'Ex : 8h - 10h',
	), $checkout->get_value( 'es_delivery_time' ) );

	woocommerce_form_field( 'es_pickup_date', array(
		'type' => 'date', 'class' => array( 'form-row-first' ),
		'label' => 'Date de reprise / fin de location',
	), $checkout->get_value( 'es_pickup_date' ) );

	woocommerce_form_field( 'es_pickup_time', array(
		'type' => 'text', 'class' => array( 'form-row-last' ),
		'label' => 'Créneau horaire de reprise', 'placeholder' => 'Ex : 18h - 20h',
	), $checkout->get_value( 'es_pickup_time' ) );

	woocommerce_form_field( 'es_onsite_contact', array(
		'type' => 'text', 'class' => array( 'form-row-first' ), 'required' => true,
		'label' => 'Contact sur place (nom)',
	), $checkout->get_value( 'es_onsite_contact' ) );

	woocommerce_form_field( 'es_onsite_phone', array(
		'type' => 'tel', 'class' => array( 'form-row-last' ), 'required' => true,
		'label' => 'Téléphone du contact sur place',
	), $checkout->get_value( 'es_onsite_phone' ) );

	woocommerce_form_field( 'es_access_notes', array(
		'type' => 'textarea', 'class' => array( 'form-row-wide' ),
		'label' => 'Instructions d’accès / logistique',
		'placeholder' => 'Quai de livraison, badges / accréditations nécessaires, horaires de montage, restrictions véhicules, contraintes d’accès…',
	), $checkout->get_value( 'es_access_notes' ) );

	echo '</div>';
}

// 6b. Validation des champs obligatoires.
add_action( 'woocommerce_checkout_process', 'eauservice_validate_event_fields' );
function eauservice_validate_event_fields() {
	$required = array(
		'es_event_name'    => 'Nom de l’événement',
		'es_venue_name'    => 'Lieu / site',
		'es_venue_address' => 'Adresse du lieu de livraison',
		'es_delivery_date' => 'Date de livraison',
		'es_onsite_contact'=> 'Contact sur place',
		'es_onsite_phone'  => 'Téléphone du contact sur place',
	);
	foreach ( $required as $key => $label ) {
		if ( empty( $_POST[ $key ] ) ) {
			wc_add_notice( sprintf( 'Merci de renseigner : %s (livraison événementielle).', $label ), 'error' );
		}
	}
}

// 6c. Enregistrement dans la commande (compatible stockage classique + HPOS).
add_action( 'woocommerce_checkout_create_order', 'eauservice_save_event_fields', 20, 2 );
function eauservice_save_event_fields( $order, $data ) {
	foreach ( array_keys( eauservice_event_fields_list() ) as $key ) {
		if ( ! empty( $_POST[ $key ] ) ) {
			$value = ( 'es_access_notes' === $key )
				? sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) )
				: sanitize_text_field( wp_unslash( $_POST[ $key ] ) );
			$order->update_meta_data( '_' . $key, $value );
		}
	}
}

// 6d. Affichage dans le back-office (sous l'adresse de livraison).
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'eauservice_show_event_fields_admin' );
function eauservice_show_event_fields_admin( $order ) {
	echo '<div class="es-admin-event"><h3 style="margin-top:14px;">Livraison événementielle</h3>';
	foreach ( eauservice_event_fields_list() as $key => $label ) {
		$val = $order->get_meta( '_' . $key );
		if ( $val ) {
			echo '<p style="margin:2px 0;"><strong>' . esc_html( $label ) . ' :</strong> ' . esc_html( $val ) . '</p>';
		}
	}
	echo '</div>';
}

// 6e. Affichage dans les e-mails de commande + page de confirmation.
add_action( 'woocommerce_email_after_order_table', 'eauservice_show_event_fields_email', 20, 4 );
function eauservice_show_event_fields_email( $order, $sent_to_admin, $plain_text, $email ) {
	$rows = '';
	foreach ( eauservice_event_fields_list() as $key => $label ) {
		$val = $order->get_meta( '_' . $key );
		if ( $val ) {
			$rows .= '<tr><td style="padding:6px 10px;border:1px solid #e5e5e5;"><strong>' . esc_html( $label ) . '</strong></td><td style="padding:6px 10px;border:1px solid #e5e5e5;">' . esc_html( $val ) . '</td></tr>';
		}
	}
	if ( $rows ) {
		echo '<h2 style="color:#1E6FD9;">Livraison événementielle</h2>';
		echo '<table cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;margin-bottom:20px;">' . $rows . '</table>';
	}
}
