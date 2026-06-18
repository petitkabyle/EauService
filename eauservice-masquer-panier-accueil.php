<?php
/**
 * ============================================================================
 *  EAUSERVICE — MASQUER LE PANIER SUR L'ACCUEIL (méthode universelle)
 *  ---------------------------------------------------------------------------
 *  Cible le panier par SON LIEN (vers /panier ou /cart) + classes connues,
 *  donc fonctionne quel que soit le thème / la version. Agit uniquement sur
 *  la page d'accueil (détection en JS, fiable même si is_front_page diffère).
 *
 *  OÙ COLLER ? « Code Snippets » > nouveau snippet > coller tout SAUF la 1re
 *  ligne <?php > « Exécuter partout » > activer.
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'eauservice_hide_cart_on_home', 99 );
function eauservice_hide_cart_on_home() {
	$home_path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	$home_path = $home_path ? rtrim( $home_path, '/' ) : '';
	?>
	<script>
	(function(){
		var HOME = <?php echo wp_json_encode( $home_path ); ?>;
		function norm(p){ return (p || '').replace(/\/+$/,''); }
		// On agit seulement sur la page d'accueil
		if ( norm(location.pathname) !== norm(HOME) ) { return; }

		function hideCart(){
			// 1) Classes connues (Astra + WooCommerce)
			var sels = ['.ast-site-header-cart','#ast-site-header-cart','.ast-header-woo-cart',
				'.ast-header-cart','.ast-cart-menu-wrap','.astra-cart-drawer','.ast-cart-menu-wrap',
				'a.cart-contents','.menu-item-cart','.wc-block-mini-cart','.site-header-cart','.header-cart'];
			sels.forEach(function(s){
				document.querySelectorAll(s).forEach(function(el){ el.style.setProperty('display','none','important'); });
			});
			// 2) Universel : tout lien d'en-tête pointant vers le panier
			var zones = document.querySelectorAll('header a, #masthead a, .site-header a, .main-header-bar a, .ast-above-header a, .ast-below-header a, nav a');
			zones.forEach(function(a){
				var h = (a.getAttribute('href') || '').toLowerCase();
				var isCart = h.indexOf('panier') > -1 || /\/cart\/?($|\?|#)/.test(h) || a.classList.contains('cart-contents');
				if ( isCart ){
					var wrap = a.closest('li, .ast-site-header-cart, .ast-cart-menu-wrap, .menu-item, .widget') || a;
					wrap.style.setProperty('display','none','important');
				}
			});
		}
		hideCart();
		document.addEventListener('DOMContentLoaded', hideCart);
		window.addEventListener('load', function(){ setTimeout(hideCart, 300); });
	})();
	</script>
	<?php
}
