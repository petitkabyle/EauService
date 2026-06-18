<?php
/**
 * ============================================================================
 *  EAUSERVICE — CORRECTIF LIVRAISON MONACO (checkout débloqué)  v3
 *  ---------------------------------------------------------------------------
 *  PROBLÈME RÉEL IDENTIFIÉ (via le message d'erreur) :
 *    « Merci de renseigner : Adresse du lieu de livraison (livraison
 *      événementielle). »
 *    -> Ce message vient de VOTRE champ OBLIGATOIRE es_venue_address.
 *    -> Une barre de recherche (Google) est branchée sur ce champ : si on ne
 *       CLIQUE PAS une suggestion (cas de Monaco, non proposé), la valeur
 *       n'est pas enregistrée -> le champ est vu "vide" -> blocage.
 *
 *  SOLUTION FIABLE (côté serveur, indépendante de Google) :
 *    Juste AVANT la validation, si es_venue_address est vide, on le REMPLIT
 *    automatiquement à partir de l'adresse de facturation / livraison saisie
 *    par le client. -> Plus jamais de blocage, même sans suggestion Google.
 *    + On débranche aussi l'autocomplétion sur ce champ (pour pouvoir taper
 *      Monaco à la main) et on autorise Monaco au niveau WooCommerce.
 *
 *  OÙ COLLER ? « Code Snippets » > nouveau snippet > coller tout SAUF la 1re
 *  ligne <?php > « Exécuter partout » > activer.
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------------------------------------------------------------------------
 * 1) AUTORISER MONACO À LA VENTE ET À LA LIVRAISON
 * ------------------------------------------------------------------------- */
add_filter( 'woocommerce_countries_allowed_countries', 'eauservice_allow_monaco', 20 );
add_filter( 'woocommerce_countries_shipping_countries', 'eauservice_allow_monaco', 20 );
function eauservice_allow_monaco( $countries ) {
	if ( is_array( $countries ) && ! isset( $countries['MC'] ) ) {
		$all = WC()->countries->get_countries();
		$countries['MC'] = isset( $all['MC'] ) ? $all['MC'] : 'Monaco';
	}
	return $countries;
}

/* ---------------------------------------------------------------------------
 * 2) VALIDATION DU CODE POSTAL DE MONACO (980xx)
 * ------------------------------------------------------------------------- */
add_filter( 'woocommerce_validate_postcode', 'eauservice_validate_mc_postcode', 10, 3 );
function eauservice_validate_mc_postcode( $valid, $postcode, $country ) {
	$pc = preg_replace( '/\s+/', '', (string) $postcode );
	if ( 'MC' === $country ) { return (bool) preg_match( '/^980\d{2}$/', $pc ); }
	if ( 'FR' === $country && preg_match( '/^98\d{3}$/', $pc ) ) { return true; }
	return $valid;
}

/* ---------------------------------------------------------------------------
 * 3) LE CORRECTIF CLÉ : remplir automatiquement "Adresse du lieu de livraison"
 *    si elle est vide, à partir de l'adresse saisie par le client.
 *    Priorité 1 = s'exécute AVANT votre validation (qui est en priorité 10),
 *    donc le champ n'est jamais vu comme vide. Fonctionne même si Google
 *    n'a rien proposé pour Monaco.
 * ------------------------------------------------------------------------- */
add_action( 'woocommerce_checkout_process', 'eauservice_fill_venue_address', 1 );
function eauservice_fill_venue_address() {
	if ( ! empty( $_POST['es_venue_address'] ) ) { return; } // déjà rempli : on ne touche pas

	$pick = function( $keys ) {
		foreach ( $keys as $k ) {
			if ( ! empty( $_POST[ $k ] ) ) { return sanitize_text_field( wp_unslash( $_POST[ $k ] ) ); }
		}
		return '';
	};

	$rue   = $pick( array( 'billing_address_1', 'shipping_address_1' ) );
	$cp    = $pick( array( 'billing_postcode', 'shipping_postcode' ) );
	$ville = $pick( array( 'billing_city', 'shipping_city' ) );

	$adresse = trim( $rue . ' ' . $cp . ' ' . $ville );
	if ( '' !== $adresse ) {
		$_POST['es_venue_address'] = $adresse; // -> la validation et l'enregistrement le verront
	}
}

/* ---------------------------------------------------------------------------
 * 4) FILET DE SÉCURITÉ : ne pas bloquer pour un code postal Monaco.
 * ------------------------------------------------------------------------- */
add_action( 'woocommerce_after_checkout_validation', 'eauservice_unblock_monaco', 20, 2 );
function eauservice_unblock_monaco( $data, $errors ) {
	$pc      = isset( $data['shipping_postcode'] ) ? $data['shipping_postcode'] : ( $data['billing_postcode'] ?? '' );
	$pc      = preg_replace( '/\s+/', '', (string) $pc );
	$country = isset( $data['shipping_country'] ) ? $data['shipping_country'] : ( $data['billing_country'] ?? '' );
	$is_monaco = ( 'MC' === $country ) || preg_match( '/^98\d{3}$/', $pc );
	if ( ! $is_monaco || ! is_wp_error( $errors ) ) { return; }
	foreach ( $errors->get_error_codes() as $code ) {
		foreach ( $errors->get_error_messages( $code ) as $msg ) {
			if ( stripos( $msg, 'postal' ) !== false || stripos( $msg, 'postcode' ) !== false || stripos( $msg, 'code postal' ) !== false ) {
				$errors->remove( $code ); break;
			}
		}
	}
}

/* ---------------------------------------------------------------------------
 * 5) DÉBRANCHER L'AUTOCOMPLÉTION GOOGLE SUR LE CHAMP ADRESSE (pour taper
 *    Monaco à la main). Complémentaire au point 3 (qui suffit déjà).
 * ------------------------------------------------------------------------- */
add_action( 'wp_footer', 'eauservice_unlock_address_field', 999 );
function eauservice_unlock_address_field() {
	if ( ! ( function_exists( 'is_checkout' ) && is_checkout() ) ) { return; }
	?>
	<script>
	(function(){
		function unlock(){
			['#es_venue_address','#billing_address_1','#shipping_address_1'].forEach(function(sel){
				var inp = document.querySelector(sel);
				if(!inp || inp._esUnlocked) return;
				inp.readOnly = false; inp.disabled = false;
				var clone = inp.cloneNode(true); clone.value = inp.value; clone._esUnlocked = true;
				inp.parentNode.replaceChild(clone, inp);
			});
			document.querySelectorAll('.pac-container, .pac-item').forEach(function(el){ el.remove(); });
		}
		function boot(){ setTimeout(unlock,300); setTimeout(unlock,1000); }
		if(document.readyState !== 'loading'){ boot(); }
		document.addEventListener('DOMContentLoaded', boot);
		window.addEventListener('load', function(){ setTimeout(unlock,600); });
		var obs = new MutationObserver(function(){ document.querySelectorAll('.pac-container').forEach(function(el){ el.style.display='none'; }); });
		try{ obs.observe(document.body, {childList:true, subtree:true}); }catch(e){}
	})();
	</script>
	<?php
}

/* ===========================================================================
 *  NOTE : les frais de livraison Monaco sont déjà gérés dans votre fichier
 *  principal (eauservice_coords renvoie les coordonnées de Monaco pour tout
 *  code 98xxx). Aucun impact ici.
 * =========================================================================== */
