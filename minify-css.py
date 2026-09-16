#!/usr/bin/env python3
"""
EAUSERVICE - Minification et optimisation du CSS
Ce script prend le CSS original et crée une version optimisée
"""

import re
import sys

def minify_css(css_content):
    """
    Minifie le CSS en supprimant les espaces inutiles, commentaires, etc.
    """
    # Supprimer les commentaires
    css = re.sub(r'/\*.*?\*/', '', css_content, flags=re.DOTALL)
    
    # Supprimer les espaces autour des accolades, virgules, deux-points, etc.
    css = re.sub(r'\s*{\s*', '{', css)
    css = re.sub(r'\s*}\s*', '}', css)
    css = re.sub(r'\s*:\s*', ':', css)
    css = re.sub(r'\s*;\s*', ';', css)
    css = re.sub(r'\s*,\s*', ',', css)
    css = re.sub(r';\s*}', '}', css)  # Supprimer le dernier point-virgule avant }
    
    # Supprimer les espaces multiples
    css = re.sub(r'\s+', ' ', css)
    
    # Supprimer les espaces au début et à la fin
    css = css.strip()
    
    # Supprimer les espaces autour des opérateurs
    css = re.sub(r'\s*>\s*', '>', css)
    css = re.sub(r'\s*\+\s*', '+', css)
    css = re.sub(r'\s*~\s*', '~', css)
    
    return css

def optimize_css(css_content):
    """
    Optimisations supplémentaires:
    - Supprimer les règles dupliquées
    - Raccourcir les valeurs de couleur
    - Optimiser les valeurs 0
    """
    css = css_content
    
    # Raccourcir les couleurs hex (#ffffff → #fff)
    css = re.sub(r'#([0-9a-fA-F])\1([0-9a-fA-F])\2([0-9a-fA-F])\3', r'#\1\2\3', css)
    
    # Optimiser les valeurs 0 (0px → 0, 0em → 0, etc.)
    css = re.sub(r'\b0(?:px|em|rem|%|vh|vw|pt)\b', '0', css)
    
    # Supprimer les unités pour les valeurs 0
    css = re.sub(r':0(?:px|em|rem|%|vh|vw|pt)', ':0', css)
    
    # Optimiser les marges et padding (margin:0 0 0 0 → margin:0)
    css = re.sub(r'(margin|padding):0 0 0 0', r'\1:0', css)
    css = re.sub(r'(margin|padding):0 0', r'\1:0', css)
    
    return css

def add_header_comment(css):
    """
    Ajoute un commentaire d'en-tête au CSS minifié
    """
    header = """/*! EauService - CSS Optimisé v2 | Minifié pour performance | eau-service-events.fr */\n"""
    return header + css

def count_savings(original, minified):
    """
    Calcule les économies réalisées
    """
    original_size = len(original.encode('utf-8'))
    minified_size = len(minified.encode('utf-8'))
    savings = original_size - minified_size
    savings_pct = (savings / original_size) * 100
    
    return {
        'original_kb': original_size / 1024,
        'minified_kb': minified_size / 1024,
        'savings_kb': savings / 1024,
        'savings_pct': savings_pct
    }

def main():
    # Lire le fichier CSS original
    input_file = 'boutique-woocommerce-v2.css'
    output_file = 'boutique-woocommerce-OPTIMIZED.css'
    
    print(f"📖 Lecture de {input_file}...")
    
    try:
        with open(input_file, 'r', encoding='utf-8') as f:
            original_css = f.read()
    except FileNotFoundError:
        print(f"❌ Erreur: Le fichier {input_file} n'existe pas")
        sys.exit(1)
    
    print("🔧 Minification en cours...")
    minified = minify_css(original_css)
    
    print("⚡ Optimisation en cours...")
    optimized = optimize_css(minified)
    
    # Ajouter l'en-tête
    final_css = add_header_comment(optimized)
    
    print(f"💾 Écriture de {output_file}...")
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(final_css)
    
    # Statistiques
    stats = count_savings(original_css, final_css)
    
    print("\n" + "="*60)
    print("✅ OPTIMISATION TERMINÉE!")
    print("="*60)
    print(f"📊 Taille originale:  {stats['original_kb']:.2f} Ko")
    print(f"📊 Taille optimisée:  {stats['minified_kb']:.2f} Ko")
    print(f"💰 Économies:         {stats['savings_kb']:.2f} Ko ({stats['savings_pct']:.1f}%)")
    print("="*60)
    print(f"\n✨ Fichier créé: {output_file}")
    print("👉 Copiez le contenu dans 'Apparence → Personnaliser → CSS additionnel'")

if __name__ == '__main__':
    main()
