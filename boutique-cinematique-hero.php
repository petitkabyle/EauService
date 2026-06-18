<?php
/**
 * ============================================================================
 *  EAUSERVICE — INTRO CINÉMATIQUE PLEIN ÉCRAN SUR LA BOUTIQUE  (v2)
 *  ---------------------------------------------------------------------------
 *  CE QUE ÇA FAIT
 *   - En arrivant sur la Boutique, la vidéo s'affiche EN PLEIN ÉCRAN (par
 *     dessus tout, même le menu).
 *   - Le scroll NE DESCEND PAS : il est bloqué et FAIT AVANCER LA VIDÉO
 *     (effet POV immersif : cascade -> livraison -> vue aérienne).
 *   - Quand la vidéo est terminée (vue aérienne), le plein écran disparaît
 *     en fondu et on ATTERRIT directement sur le catalogue de produits.
 *   - N'altère EN RIEN la mise en page de la boutique : c'est une couche
 *     posée par-dessus (overlay), déplacée dans <body> au chargement.
 *
 *  OÙ COLLER CE CODE ?
 *   Extension « Code Snippets » > nouveau snippet > coller TOUT ci-dessous
 *   SAUF la 1re ligne <?php > « Exécuter partout » > activer.
 *
 *  ====> ÉTAPE OBLIGATOIRE : METTRE LA VIDÉO EN LIGNE <====
 *   1. WordPress > Médias > Ajouter > téléversez votre vidéo.
 *   2. Copiez « l'URL du fichier ».
 *   3. Collez-la dans EAUSERVICE_CINE_VIDEO ci-dessous.
 *
 *  RÉGLAGES :
 *   - EAUSERVICE_CINE_VIDEO : URL de la vidéo (OBLIGATOIRE).
 *   - EAUSERVICE_CINE_MODE  : 'scrub' = le scroll fait avancer la vidéo
 *                             (immersif, recommandé) ;
 *                             'play'  = la vidéo se lit toute seule, puis on
 *                             débloque à la fin (si 'scrub' saccade).
 *   - EAUSERVICE_CINE_SENS  : sensibilité du scroll (PLUS GRAND = PLUS RAPIDE,
 *                             moins de scroll). 0.0016 par défaut.
 *   - EAUSERVICE_CINE_POSTER: (facultatif) image affichée avant la vidéo.
 *   - EAUSERVICE_CINE_ONCE  : true = ne montrer l'intro qu'1 fois par visite
 *                             (par session). false = à chaque arrivée.
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---- À PERSONNALISER -------------------------------------------------- */
if ( ! defined( 'EAUSERVICE_CINE_VIDEO' ) ) {
	// >>> COLLEZ ICI L'URL DE VOTRE VIDÉO (Médias > URL du fichier) <<<
	define( 'EAUSERVICE_CINE_VIDEO', 'https://eau-service-events.fr/wp-content/uploads/cinematique-video.mp4' );
}
if ( ! defined( 'EAUSERVICE_CINE_MODE' ) )   { define( 'EAUSERVICE_CINE_MODE', 'scrub' ); }  // 'scrub' | 'play'
if ( ! defined( 'EAUSERVICE_CINE_SENS' ) )   { define( 'EAUSERVICE_CINE_SENS', 0.0016 ); }   // + grand = + rapide
if ( ! defined( 'EAUSERVICE_CINE_POSTER' ) ) { define( 'EAUSERVICE_CINE_POSTER', '' ); }      // URL image (facultatif)
if ( ! defined( 'EAUSERVICE_CINE_ONCE' ) )   { define( 'EAUSERVICE_CINE_ONCE', false ); }     // true = 1 fois/session
/* ---------------------------------------------------------------------- */

add_action( 'wp_footer', 'eauservice_cine_overlay', 99 );
function eauservice_cine_overlay() {
	// Uniquement sur la 1re page de la Boutique (pas sous-pages / catégories).
	if ( ! ( function_exists( 'is_shop' ) && is_shop() ) ) { return; }
	if ( function_exists( 'is_paged' ) && is_paged() ) { return; }

	$video  = esc_url( EAUSERVICE_CINE_VIDEO );
	$mode   = ( EAUSERVICE_CINE_MODE === 'play' ) ? 'play' : 'scrub';
	$sens   = (float) EAUSERVICE_CINE_SENS;
	$once   = EAUSERVICE_CINE_ONCE ? 'true' : 'false';
	$poster = EAUSERVICE_CINE_POSTER ? ' poster="' . esc_url( EAUSERVICE_CINE_POSTER ) . '"' : '';
	?>
	<style>
	/* ===== INTRO CINÉMATIQUE — tout scopé sous #es-cine-ov ===== */
	html.es-cine-lock, body.es-cine-lock{ overflow:hidden !important; height:100% !important; }
	#es-cine-ov{
		position:fixed; inset:0; z-index:2147483000;
		background:#000; overflow:hidden;
		opacity:1; transition:opacity .6s ease;
		font-family:'Sora',system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;
		touch-action:none; -webkit-tap-highlight-color:transparent;
	}
	#es-cine-ov.is-hiding{ opacity:0; }
	#es-cine-ov .cine-video{
		position:absolute; inset:0; width:100%; height:100%;
		object-fit:cover; background:#000; display:block;
	}
	#es-cine-ov .cine-grad{
		position:absolute; inset:0; pointer-events:none;
		background:linear-gradient(180deg, rgba(0,0,0,.35) 0%, rgba(0,0,0,0) 24%, rgba(0,0,0,0) 64%, rgba(0,0,0,.55) 100%);
	}
	/* Titre (haut centre), s'efface quand on avance */
	#es-cine-ov .cine-head{
		position:absolute; left:0; right:0; top:7%; z-index:3; text-align:center;
		padding:0 18px; pointer-events:none; transition:opacity .25s ease, transform .25s ease;
	}
	#es-cine-ov .cine-kicker{
		display:inline-block; color:#6fe0ff; font-size:clamp(10px,1.4vw,13px);
		font-weight:700; letter-spacing:3px; text-transform:uppercase; margin-bottom:10px;
		text-shadow:0 2px 16px rgba(0,0,0,.6);
	}
	#es-cine-ov .cine-title{
		margin:0; color:#fff; font-weight:800; line-height:1.05;
		font-size:clamp(30px,6vw,72px); letter-spacing:-1.5px;
		text-shadow:0 6px 40px rgba(0,0,0,.6);
	}
	/* Indice "scroll pour avancer" (bas), s'efface dès qu'on avance */
	#es-cine-ov .cine-hint{
		position:absolute; left:50%; bottom:8%; transform:translateX(-50%); z-index:3;
		display:flex; flex-direction:column; align-items:center; gap:10px;
		color:#dff1ff; font-size:13px; font-weight:600; letter-spacing:.3px;
		text-shadow:0 2px 14px rgba(0,0,0,.7); transition:opacity .25s ease; pointer-events:none;
	}
	#es-cine-ov .cine-hint svg{ animation:esCineB 1.7s ease-in-out infinite; }
	@keyframes esCineB{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(7px)} }
	/* CTA "Découvrez le catalogue" (apparaît à la fin) */
	#es-cine-ov .cine-enter{
		position:absolute; left:50%; bottom:8%; transform:translateX(-50%); z-index:4;
		display:flex; flex-direction:column; align-items:center; gap:8px;
		color:#fff; font-weight:700; font-size:clamp(15px,2vw,20px);
		opacity:0; pointer-events:none; text-shadow:0 2px 20px rgba(0,0,0,.7);
		transition:opacity .3s ease;
	}
	#es-cine-ov .cine-enter svg{ animation:esCineB 1.5s ease-in-out infinite; }
	/* Barre de progression (bas de l'écran) */
	#es-cine-ov .cine-prog{
		position:absolute; left:0; right:0; bottom:0; height:4px; z-index:5;
		background:rgba(255,255,255,.18);
	}
	#es-cine-ov .cine-prog > i{
		display:block; height:100%; width:0%;
		background:linear-gradient(90deg,#35c6f0,#6fe0ff); box-shadow:0 0 12px rgba(53,198,240,.7);
	}
	/* Bouton "Passer l'intro" */
	#es-cine-ov .cine-skip{
		position:absolute; top:18px; right:18px; z-index:6;
		background:rgba(0,0,0,.4); color:#fff; border:1px solid rgba(255,255,255,.35);
		border-radius:30px; padding:9px 18px; font-size:13px; font-weight:600;
		cursor:pointer; backdrop-filter:blur(6px); transition:background .2s, transform .2s;
	}
	#es-cine-ov .cine-skip:hover{ background:rgba(0,0,0,.7); transform:translateY(-1px); }
	@media (max-width:768px){
		#es-cine-ov .cine-head{ top:9%; }
		#es-cine-ov .cine-hint, #es-cine-ov .cine-enter{ bottom:11%; }
	}
	@media (prefers-reduced-motion:reduce){
		#es-cine-ov .cine-hint svg, #es-cine-ov .cine-enter svg{ animation:none; }
	}
	</style>

	<div id="es-cine-ov" data-mode="<?php echo esc_attr( $mode ); ?>"
	     data-sens="<?php echo esc_attr( $sens ); ?>" data-once="<?php echo $once; ?>">
		<video class="cine-video" src="<?php echo $video; ?>"<?php echo $poster; ?>
		       muted playsinline webkit-playsinline preload="auto" disablepictureinpicture></video>
		<div class="cine-grad"></div>
		<div class="cine-head">
			<span class="cine-kicker">De la source à votre événement</span>
			<h2 class="cine-title">EauService · Côte d'Azur</h2>
		</div>
		<div class="cine-hint">
			<span>Scrollez pour avancer dans la vidéo</span>
			<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
		</div>
		<div class="cine-enter">
			<span>Découvrez notre catalogue</span>
			<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
		</div>
		<div class="cine-prog"><i></i></div>
		<button type="button" class="cine-skip">Passer l'intro &rarr;</button>
	</div>

	<script>
	(function(){
		var ov = document.getElementById('es-cine-ov');
		if(!ov) return;
		var mode = ov.getAttribute('data-mode') || 'scrub';
		var SENS = parseFloat(ov.getAttribute('data-sens')) || 0.0016;
		var ONCE = ov.getAttribute('data-once') === 'true';

		// Ne pas re-montrer si déjà vu dans cette session (option ONCE)
		try{ if(ONCE && sessionStorage.getItem('esCineSeen')==='1'){ ov.parentNode.removeChild(ov); return; } }catch(e){}

		var video = ov.querySelector('.cine-video');
		var head  = ov.querySelector('.cine-head');
		var hint  = ov.querySelector('.cine-hint');
		var enter = ov.querySelector('.cine-enter');
		var bar   = ov.querySelector('.cine-prog > i');
		var skip  = ov.querySelector('.cine-skip');

		var html = document.documentElement, body = document.body;
		var target = 0, cur = 0, duration = 0, ready = false, finished = false, rafOn = false;

		function clamp(v,a,b){ return Math.max(a, Math.min(b, v)); }
		function smoothstep(a,b,x){ var t=clamp((x-a)/(b-a),0,1); return t*t*(3-2*t); }

		// L'overlay devient enfant direct de <body> (évite tout clipping/transform).
		if(ov.parentNode !== body){ body.appendChild(ov); }

		function lock(){ html.classList.add('es-cine-lock'); body.classList.add('es-cine-lock'); window.scrollTo(0,0); }
		function unlock(){ html.classList.remove('es-cine-lock'); body.classList.remove('es-cine-lock'); }

		function finish(){
			if(finished) return; finished = true;
			try{ if(ONCE) sessionStorage.setItem('esCineSeen','1'); }catch(e){}
			ov.classList.add('is-hiding');
			unlock();
			window.scrollTo(0,0);
			setTimeout(function(){ if(ov && ov.parentNode){ ov.parentNode.removeChild(ov); } }, 650);
			removeListeners();
		}

		function updateUI(p){
			bar.style.width = (p*100) + '%';
			var fade = 1 - smoothstep(0.02, 0.30, p);
			head.style.opacity = fade;
			head.style.transform = 'translateY(' + (-18*(1-fade)) + 'px)';
			hint.style.opacity = (1 - smoothstep(0, 0.10, p));
			enter.style.opacity = smoothstep(0.90, 1, p);
		}

		function render(){
			if(finished) return;
			// lissage : la vidéo "tourne" doucement vers la cible
			cur += (target - cur) * 0.14;
			if(Math.abs(target - cur) < 0.0005) cur = target;
			if(mode === 'scrub' && ready && duration){
				try{ video.currentTime = clamp(cur,0,1) * (duration - 0.05); }catch(e){}
			}
			updateUI(cur);
			if(rafOn) requestAnimationFrame(render);
		}

		// ----- Entrées : molette + tactile -----
		function onWheel(e){
			e.preventDefault();
			if(mode === 'play'){ if(target >= 0.999) finish(); target = clamp(target + e.deltaY*0.0006, 0, 1); return; }
			var prev = target;
			target = clamp(target + e.deltaY * SENS, 0, 1);
			if(prev >= 0.999 && e.deltaY > 0) finish();
		}
		var touchY = 0;
		function onTouchStart(e){ touchY = e.touches[0].clientY; }
		function onTouchMove(e){
			e.preventDefault();
			var y = e.touches[0].clientY, dy = touchY - y; touchY = y;
			if(mode === 'play'){ if(target >= 0.999) finish(); target = clamp(target + dy*0.004, 0, 1); return; }
			var prev = target;
			target = clamp(target + dy * (SENS*3.2), 0, 1);
			if(prev >= 0.999 && dy > 0) finish();
		}
		function onKey(e){
			if(e.key === 'Escape'){ finish(); }
			else if(e.key === 'ArrowDown' || e.key === ' '){ e.preventDefault(); var p=target; target=clamp(target+0.06,0,1); if(p>=0.999) finish(); }
			else if(e.key === 'ArrowUp'){ e.preventDefault(); target=clamp(target-0.06,0,1); }
		}

		function addListeners(){
			window.addEventListener('wheel', onWheel, {passive:false});
			window.addEventListener('touchstart', onTouchStart, {passive:false});
			window.addEventListener('touchmove', onTouchMove, {passive:false});
			window.addEventListener('keydown', onKey, {passive:false});
		}
		function removeListeners(){
			window.removeEventListener('wheel', onWheel);
			window.removeEventListener('touchstart', onTouchStart);
			window.removeEventListener('touchmove', onTouchMove);
			window.removeEventListener('keydown', onKey);
		}

		skip.addEventListener('click', finish);

		function start(){
			duration = video.duration || 0;
			ready = isFinite(duration) && duration > 0;
			if(mode === 'scrub'){ video.pause(); try{ video.currentTime = 0; }catch(e){} }
			else {
				video.loop = false;
				video.addEventListener('ended', finish);
				var pr = video.play(); if(pr && pr.catch){ pr.catch(function(){}); }
			}
		}

		// Si la vidéo ne charge pas, on ne bloque jamais l'utilisateur.
		video.addEventListener('error', function(){ finish(); });
		// Sécurité : si rien n'est prêt après 12s, on libère.
		var safety = setTimeout(function(){ if(!ready && !finished){ finish(); } }, 12000);
		video.addEventListener('canplay', function(){ clearTimeout(safety); }, {once:true});

		lock();
		addListeners();
		rafOn = true; requestAnimationFrame(render);
		if(video.readyState >= 1){ start(); } else { video.addEventListener('loadedmetadata', start); }
	})();
	</script>
	<?php
}

/* ===========================================================================
 * (FACULTATIF) Police "Sora" pour le titre de l'intro. Supprimez si déjà chargée.
 * =========================================================================== */
add_action( 'wp_enqueue_scripts', 'eauservice_cine_fonts' );
function eauservice_cine_fonts() {
	if ( ! ( function_exists( 'is_shop' ) && is_shop() ) ) { return; }
	wp_enqueue_style( 'eauservice-cine-font', 'https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&display=swap', array(), null );
}
