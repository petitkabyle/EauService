/**
 * EAUSERVICE - LAZY LOADING OPTIMISÉ DES IMAGES
 * Économie: 1558-1896 Kio
 * 
 * Ce script :
 * - Charge les images uniquement quand elles deviennent visibles
 * - Utilise l'API Intersection Observer (moderne et performant)
 * - Ajoute un effet de fondu à l'apparition
 * - Gère le fallback pour les anciens navigateurs
 * - Optimise les images produits WooCommerce
 */

(function() {
  'use strict';

  // Configuration
  const CONFIG = {
    rootMargin: '50px 0px', // Commence à charger 50px avant que l'image soit visible
    threshold: 0.01,        // Déclenche dès que 1% de l'image est visible
    fadeInDuration: 400,    // Durée de l'animation de fondu (ms)
    loadingClass: 'es-img-loading',
    loadedClass: 'es-img-loaded',
    errorClass: 'es-img-error'
  };

  // Ajouter les styles CSS directement
  const style = document.createElement('style');
  style.textContent = `
    img[data-src] {
      opacity: 0;
      transition: opacity ${CONFIG.fadeInDuration}ms ease-in-out;
      background: linear-gradient(135deg, #f0f4f8 0%, #e7edf3 100%);
      min-height: 100px;
    }
    
    img.${CONFIG.loadingClass} {
      opacity: 0;
    }
    
    img.${CONFIG.loadedClass} {
      opacity: 1;
    }
    
    img.${CONFIG.errorClass} {
      opacity: 0.3;
      background: #fee;
    }

    /* Animation de shimmer pendant le chargement */
    img[data-src]::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,0.3),
        transparent
      );
      animation: esShimmer 1.5s infinite;
    }

    @keyframes esShimmer {
      0% { left: -100%; }
      100% { left: 100%; }
    }

    /* Responsive images */
    img[data-src],
    img.${CONFIG.loadedClass} {
      max-width: 100%;
      height: auto;
    }
  `;
  document.head.appendChild(style);

  /**
   * Charger une image
   * @param {HTMLImageElement} img 
   */
  function loadImage(img) {
    const src = img.getAttribute('data-src');
    const srcset = img.getAttribute('data-srcset');
    
    if (!src) return;

    // Ajouter la classe de chargement
    img.classList.add(CONFIG.loadingClass);

    // Créer une nouvelle image pour précharger
    const tempImg = new Image();
    
    // Copier les attributs srcset si présents
    if (srcset) {
      tempImg.srcset = srcset;
    }
    
    // Gérer le chargement réussi
    tempImg.onload = function() {
      // Appliquer l'image
      img.src = src;
      if (srcset) {
        img.srcset = srcset;
      }
      
      // Nettoyer les attributs data-*
      img.removeAttribute('data-src');
      img.removeAttribute('data-srcset');
      
      // Ajouter la classe de succès
      img.classList.remove(CONFIG.loadingClass);
      img.classList.add(CONFIG.loadedClass);
      
      // Déclencher un événement personnalisé
      img.dispatchEvent(new CustomEvent('imageLoaded', {
        detail: { src: src }
      }));
    };
    
    // Gérer les erreurs
    tempImg.onerror = function() {
      console.error('Erreur de chargement de l\'image:', src);
      img.classList.remove(CONFIG.loadingClass);
      img.classList.add(CONFIG.errorClass);
      
      // Événement d'erreur
      img.dispatchEvent(new CustomEvent('imageError', {
        detail: { src: src }
      }));
    };
    
    // Démarrer le chargement
    tempImg.src = src;
  }

  /**
   * Initialiser l'Intersection Observer
   */
  function initLazyLoading() {
    // Vérifier le support de l'Intersection Observer
    if (!('IntersectionObserver' in window)) {
      console.warn('IntersectionObserver non supporté, chargement de toutes les images');
      // Fallback: charger toutes les images immédiatement
      document.querySelectorAll('img[data-src]').forEach(loadImage);
      return;
    }

    // Créer l'observer
    const observer = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          const img = entry.target;
          loadImage(img);
          // Arrêter d'observer cette image
          observer.unobserve(img);
        }
      });
    }, {
      rootMargin: CONFIG.rootMargin,
      threshold: CONFIG.threshold
    });

    // Observer toutes les images avec data-src
    document.querySelectorAll('img[data-src]').forEach(function(img) {
      // Ajouter les attributs de dimensions si manquants
      if (!img.hasAttribute('width') || !img.hasAttribute('height')) {
        // Essayer de déduire les dimensions depuis les styles ou classes
        const computedStyle = window.getComputedStyle(img);
        const width = computedStyle.width;
        const height = computedStyle.height;
        
        if (width && width !== 'auto' && !img.hasAttribute('width')) {
          img.setAttribute('width', parseInt(width));
        }
        if (height && height !== 'auto' && !img.hasAttribute('height')) {
          img.setAttribute('height', parseInt(height));
        }
      }
      
      observer.observe(img);
    });
  }

  /**
   * Convertir les images existantes en lazy loading
   */
  function convertExistingImages() {
    // Sélectionner les images à convertir (sauf celles déjà visibles)
    const selector = [
      '.woocommerce-product-gallery img',
      '.product img',
      '.wp-post-image',
      'article img',
      '.content img',
      '.entry-content img'
    ].join(',');

    document.querySelectorAll(selector).forEach(function(img) {
      // Ignorer les images déjà chargées ou sans src
      if (img.hasAttribute('data-src') || !img.src) return;
      
      // Ignorer les images dans le viewport initial (above the fold)
      const rect = img.getBoundingClientRect();
      if (rect.top < window.innerHeight) return;
      
      // Convertir en lazy loading
      img.setAttribute('data-src', img.src);
      
      // Gérer srcset si présent
      if (img.srcset) {
        img.setAttribute('data-srcset', img.srcset);
        img.removeAttribute('srcset');
      }
      
      // Vider le src temporairement
      img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"%3E%3C/svg%3E';
      
      // Ajouter l'attribut loading="lazy" pour le support natif
      img.setAttribute('loading', 'lazy');
    });
  }

  /**
   * Précharger les images critiques (au-dessus de la ligne de flottaison)
   */
  function preloadCriticalImages() {
    // Images du hero, logo, etc.
    const criticalSelectors = [
      '.hero img',
      '.site-header img',
      '.site-logo img',
      '.hero-visual img'
    ];

    criticalSelectors.forEach(function(selector) {
      document.querySelectorAll(selector).forEach(function(img) {
        if (img.hasAttribute('data-src')) {
          loadImage(img);
        }
      });
    });
  }

  /**
   * Optimiser les images produits WooCommerce
   */
  function optimizeWooCommerceImages() {
    // Ajouter width/height aux images produits si manquants
    document.querySelectorAll('.woocommerce-product-gallery__image img').forEach(function(img) {
      if (!img.hasAttribute('width')) {
        img.setAttribute('width', '800');
      }
      if (!img.hasAttribute('height')) {
        img.setAttribute('height', '800');
      }
    });

    // Ajouter loading="lazy" aux miniatures
    document.querySelectorAll('.woocommerce-product-gallery__image--placeholder img').forEach(function(img) {
      img.setAttribute('loading', 'lazy');
    });
  }

  /**
   * Gérer le chargement dynamique (AJAX, WooCommerce)
   */
  function observeDynamicContent() {
    // Observer les nouveaux éléments ajoutés au DOM
    const bodyObserver = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        mutation.addedNodes.forEach(function(node) {
          if (node.nodeType === 1) { // Element node
            // Chercher les nouvelles images
            const newImages = node.querySelectorAll ? node.querySelectorAll('img[data-src]') : [];
            newImages.forEach(function(img) {
              if (!('IntersectionObserver' in window)) {
                loadImage(img);
              } else {
                // Ré-initialiser l'observer pour les nouvelles images
                initLazyLoading();
              }
            });
          }
        });
      });
    });

    bodyObserver.observe(document.body, {
      childList: true,
      subtree: true
    });
  }

  /**
   * Initialisation au chargement du DOM
   */
  function init() {
    // Attendre que le DOM soit prêt
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init);
      return;
    }

    console.log('🚀 EauService: Initialisation du lazy loading des images');

    // 1. Précharger les images critiques
    preloadCriticalImages();

    // 2. Convertir les images existantes
    convertExistingImages();

    // 3. Initialiser le lazy loading
    initLazyLoading();

    // 4. Optimiser WooCommerce
    optimizeWooCommerceImages();

    // 5. Observer le contenu dynamique
    observeDynamicContent();

    console.log('✅ EauService: Lazy loading activé');
  }

  // Lancer l'initialisation
  init();

  // Exposer une fonction pour forcer le chargement (utile pour le debug)
  window.esForceLoadImages = function() {
    document.querySelectorAll('img[data-src]').forEach(loadImage);
  };

})();
