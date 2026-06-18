<?php
/**
 * ============================================================================
 *  EAUSERVICE — SEO DES CATÉGORIES + ÉTIQUETTES BOUTIQUE
 *  ---------------------------------------------------------------------------
 *  Injecte automatiquement, sur les pages CATÉGORIE et ÉTIQUETTE produit :
 *    - la balise <title> optimisée,
 *    - la <meta name="description">,
 *    - les balises Open Graph (partage réseaux sociaux),
 *    - un lien canonique.
 *
 *  >>> ANTI-CONFLIT : si Yoast SEO / Rank Math / AIOSEO est actif, ce snippet
 *      NE FAIT RIEN (collez alors les titres/métas dans leurs champs).
 *
 *  OÙ COLLER ? « Code Snippets » > nouveau snippet > coller tout SAUF la 1re
 *  ligne <?php > « Exécuter partout » > activer.
 *
 *  ⚠️ VÉRIFIEZ LES SLUGS : Produits > Catégories (et Étiquettes) > colonne
 *     « Slug ». Adaptez les clés des tableaux ci-dessous si besoin.
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Catégories : slug => SEO. */
function eauservice_seo_cat_map() {
	return array(
		'packs' => array(
			'title' => "Packs événementiels clé en main | Location Côte d'Azur",
			'desc'  => "Louez nos packs événementiels clé en main (machine à café, fontaine à eau, réfrigération) pour vos salons et congrès sur la Côte d'Azur. Livraison, installation et reprise incluses.",
		),
		'fontaine-a-eau' => array(
			'title' => "Location fontaine à eau | Salons & événements Côte d'Azur",
			'desc'  => "Location de fontaines à eau pour salons, congrès et événements à Cannes, Nice, Monaco et Antibes. Eau fraîche pour vos visiteurs, livraison et installation sur stand incluses.",
		),
		'machine-a-cafe' => array(
			'title' => "Location machine à café pro | Nespresso, Lavazza, Covim",
			'desc'  => "Location de machines à café professionnelles (Nespresso, Lavazza, Covim) pour vos événements sur la Côte d'Azur. Consommables inclus, livraison et installation sur site.",
		),
		'refrigeration' => array(
			'title' => "Location réfrigérateur & frigo | Événements Côte d'Azur",
			'desc'  => "Location de réfrigérateurs et frigos pour salons, congrès et stands sur la Côte d'Azur. Gardez boissons et produits au frais. Livraison, installation et reprise incluses.",
		),
	);
}

/** Étiquettes (tags) : slug => SEO. */
function eauservice_seo_tag_map() {
	return array(
		'accessoire-cafe' => array(
			'title' => "Accessoires café en location | Événements Côte d'Azur",
			'desc'  => "Location d'accessoires café (gobelets, sucre, touillettes, mousseur à lait…) pour vos événements sur la Côte d'Azur. Complétez votre service café, livraison sur stand incluse.",
		),
		'alpes-maritimes' => array(
			'title' => "Location matériel événementiel Alpes-Maritimes (06)",
			'desc'  => "Location de machines à café, fontaines à eau et réfrigération pour vos événements dans les Alpes-Maritimes : Nice, Cannes, Antibes, Grasse, Menton. Livraison et installation incluses.",
		),
		'boissons' => array(
			'title' => "Solutions boissons pour événements | Café & eau Côte d'Azur",
			'desc'  => "Café, eau fraîche et accessoires boissons en location pour salons et congrès sur la Côte d'Azur. Désaltérez visiteurs et collaborateurs, livraison et installation sur site.",
		),
		// --- Étiquettes par marque ---
		'nespresso' => array(
			'title' => "Location machine à café Nespresso | Événements Côte d'Azur",
			'desc'  => "Location de machines à café Nespresso pour vos salons, congrès et séminaires sur la Côte d'Azur. Café de qualité, capsules et accessoires, installation sur stand incluse.",
		),
		'lavazza' => array(
			'title' => "Location machine à café Lavazza | Côte d'Azur",
			'desc'  => "Location de machines à café Lavazza pour vos événements professionnels à Cannes, Nice, Monaco et Antibes. Consommables fournis, livraison et installation incluses.",
		),
		'covim' => array(
			'title' => "Location machine à café Covim | Événements Côte d'Azur",
			'desc'  => "Location de machines à café Covim pour salons, congrès et séminaires sur la Côte d'Azur. Café professionnel, consommables et installation sur site inclus.",
		),
		// --- Étiquettes par type d'événement ---
		'salon' => array(
			'title' => "Équipement de salon professionnel | Location Côte d'Azur",
			'desc'  => "Machines à café, fontaines à eau et réfrigération en location pour votre stand de salon sur la Côte d'Azur. Livraison, installation et reprise incluses.",
		),
		'congres' => array(
			'title' => "Location matériel pour congrès | Côte d'Azur",
			'desc'  => "Équipez votre congrès sur la Côte d'Azur : machines à café, fontaines à eau et réfrigération en location. Service clé en main, livraison et installation sur site.",
		),
		'seminaire' => array(
			'title' => "Location matériel pour séminaire | Côte d'Azur",
			'desc'  => "Café, eau et réfrigération en location pour vos séminaires d'entreprise sur la Côte d'Azur. Matériel professionnel, livraison et installation incluses.",
		),
		// --- Étiquettes par ville ---
		'cannes' => array(
			'title' => "Location matériel événementiel à Cannes | EauService",
			'desc'  => "Location de machines à café, fontaines à eau et réfrigération pour vos événements à Cannes (Palais des Festivals). Livraison, installation et reprise sur stand incluses.",
		),
		'nice' => array(
			'title' => "Location matériel événementiel à Nice | EauService",
			'desc'  => "Location de machines à café, fontaines à eau et réfrigération pour vos événements à Nice (Palais des Congrès Acropolis). Livraison et installation incluses.",
		),
		'monaco' => array(
			'title' => "Location matériel événementiel à Monaco | EauService",
			'desc'  => "Location de machines à café, fontaines à eau et réfrigération pour vos événements à Monaco (Grimaldi Forum). Livraison, installation et reprise sur site incluses.",
		),
		'antibes' => array(
			'title' => "Location matériel événementiel à Antibes | EauService",
			'desc'  => "Location de machines à café, fontaines à eau et réfrigération pour vos événements à Antibes et Juan-les-Pins. Livraison et installation sur stand incluses.",
		),
	);
}

/** Détecte un plugin SEO actif (pour éviter les doublons). */
function eauservice_seo_plugin_active() {
	return ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || class_exists( 'The_SEO_Framework\\Load' ) );
}

/** Renvoie les données SEO de la page courante (catégorie OU étiquette). */
function eauservice_seo_current() {
	if ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$term = get_queried_object();
		$map  = eauservice_seo_cat_map();
		if ( $term && isset( $map[ $term->slug ] ) ) { return array( $term, $map[ $term->slug ] ); }
	}
	if ( function_exists( 'is_product_tag' ) && is_product_tag() ) {
		$term = get_queried_object();
		$map  = eauservice_seo_tag_map();
		if ( $term && isset( $map[ $term->slug ] ) ) { return array( $term, $map[ $term->slug ] ); }
	}
	return null;
}

/** 1) Titre <title>. */
add_filter( 'pre_get_document_title', 'eauservice_seo_title', 20 );
function eauservice_seo_title( $title ) {
	if ( eauservice_seo_plugin_active() ) { return $title; }
	if ( function_exists( 'is_paged' ) && is_paged() ) { return $title; }
	$cur = eauservice_seo_current();
	return $cur ? $cur[1]['title'] : $title;
}

/** 2) Méta description + Open Graph + canonical. */
add_action( 'wp_head', 'eauservice_seo_meta', 1 );
function eauservice_seo_meta() {
	if ( eauservice_seo_plugin_active() ) { return; }
	$cur = eauservice_seo_current();
	if ( ! $cur ) { return; }
	list( $term, $seo ) = $cur;
	$desc  = $seo['desc'];
	$title = $seo['title'];
	$url   = get_term_link( $term );
	if ( is_wp_error( $url ) ) { $url = home_url( '/' ); }
	echo "\n<meta name=\"description\" content=\"" . esc_attr( $desc ) . "\">\n";
	echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
}
