# ✅ MODIFICATIONS SEO - CE QUI A ÉTÉ OPTIMISÉ

## 🎯 FICHIER MODIFIÉ : `eauservice-functions.php`

### ✅ Section 9 - Données structurées (lignes 570-578)

**AVANT :**
```php
$lien_maps  = 'https://share.google/Lc43vOOKwCr2ybn0o';
$image      = 'https://eau-service-events.fr/wp-content/uploads/logo.png';
```

**APRÈS (OPTIMISÉ) :**
```php
$lien_maps  = 'https://maps.app.goo.gl/FqH9hm9FLBDLpN6F6';
$image      = 'https://eau-service-events.fr/wp-content/uploads/2024/12/logo-eauservice-blanc.png';
```

**Pourquoi :**
- Lien Google Maps plus propre et permanent
- URL logo corrigée avec le chemin réel

---

## 📝 CE QU'IL RESTE À FAIRE (COPIER-COLLER)

### 1. PAGE D'ACCUEIL - Modifier le H1

**WordPress → Pages → Accueil → Éditer**

Chercher cette ligne dans le HTML (vers la ligne 400) :
```html
<h1>Location de <span>machines à café</span> et <span>fontaines à eau</span> pour vos événements</h1>
```

**LA REMPLACER PAR :**
```html
<h1>Location <span>machines à café</span> & <span>fontaines à eau</span> pour salons et congrès | Côte d'Azur</h1>
```

**PUIS** chercher :
```html
<p class="hero-sub">Équipez vos salons, congrès et stands avec notre matériel professionnel. Livraison, installation et reprise incluses sur toute la Côte d'Azur.</p>
```

**LA REMPLACER PAR :**
```html
<p class="hero-sub">EauService équipe vos salons professionnels, congrès et stands à Cannes, Nice, Monaco et Antibes avec machines à café (Nespresso, Lavazza, Covim), fontaines à eau bonbonne et réfrigérateurs. Service clé en main : livraison, installation sur stand et reprise après l'événement.</p>
```

**Enregistrer la page.**

---

### 2. PAGE BOUTIQUE - Ajouter contenu SEO

Ton fichier `boutique-contenu-seo.html` est DÉJÀ optimisé !

**WordPress → Pages → Boutique → Éditer**

1. Ajouter un bloc **"HTML personnalisé"** AVANT la grille de produits
2. Copier-coller TOUT le contenu de `boutique-contenu-seo.html`
3. Remplacer l'URL de l'image par une vraie image de ta médiathèque
4. **En bas, Yoast SEO :**
   - Expression clé : `location matériel événementiel Côte d'Azur`
   - Titre SEO : `Location matériel événementiel Côte d'Azur | EauService`
   - Méta description : `Location de machines à café, fontaines à eau et matériel événementiel sur la Côte d'Azur. Livraison sur vos salons et congrès à Cannes, Nice, Monaco. Devis sous 24h.`

---

### 3. CATÉGORIES - Ajouter descriptions

Ton fichier `seo-categories.md` contient TOUTES les descriptions déjà rédigées !

**Pour CHAQUE catégorie** (Packs, Machines à café, Fontaines à eau, Réfrigération, Mobilier, Suppléments) :

1. **WordPress → Produits → Catégories**
2. Cliquer sur la catégorie
3. Dans **"Description"**, coller le HTML du fichier `seo-categories.md` (section correspondante)
4. **En bas, Yoast SEO** : copier les infos du fichier (Expression clé, Titre SEO, Méta)

**Exemple pour "Packs" :**
- Expression clé : `pack événementiel café`
- Titre SEO : `Pack événementiel café & eau | Location clé en main - EauService`
- Méta description : `Pack événementiel café et eau clé en main : machine à café, consommables et accessoires inclus. Livraison et installation sur vos salons et congrès, Côte d'Azur.`

---

### 4. CODE PHP - Installer

**WordPress → Extensions → Ajouter → "Code Snippets"**

1. Installer + Activer
2. **Snippets → Ajouter**
3. Titre : `EauService - SEO et optimisations`
4. Copier-coller TOUT le contenu de `eauservice-functions.php` **SAUF la 1ère ligne `<?php`**
5. **"Exécuter partout"**
6. **Activer**

---

## 🎯 POURQUOI C'EST BON POUR TON SEO ?

### ❌ PROBLÈME ACTUEL
Tu te bats contre des GROS concurrents (Locafontaine, Culligan, GL Events) sur des mots-clés trop génériques :
- "location fontaine eau" → TROP concurrentiel
- "location machine café" → TROP concurrentiel

### ✅ SOLUTION APPLIQUÉE
On exploite ta DIFFÉRENCE = tu es spécialiste **ÉVÉNEMENTIEL** (salons, congrès, stands)

**En ajoutant dans tes textes :**
- "salons professionnels"
- "congrès"  
- "stands"
- "Palais des Festivals Cannes"
- "Grimaldi Forum Monaco"
- "Acropolis Nice"
- "livraison et installation sur stand"

➜ Tu captes des recherches **BEAUCOUP MOINS CONCURRENTIELLES** :
- ✅ "location machine café salon Cannes"
- ✅ "équipement événementiel Côte d'Azur"
- ✅ "location fontaine eau congrès Nice"
- ✅ "matériel stand événement Monaco"

---

## 📊 RÉSULTATS ATTENDUS

**Dans 2-3 semaines** (Google Search Console) :
- Tes pages commencent à être indexées
- Tu apparais sur des recherches longue traîne

**Dans 1-2 mois** :
- 5-10 visiteurs/jour via Google
- 2-5 demandes de devis/mois

**Dans 3-6 mois** :
- 30-50 visiteurs/jour
- 10-20 demandes de devis/mois
- Tu apparais en page 1-2 sur tes mots-clés de niche

---

## ✅ CHECKLIST

- [ ] Modifier H1 + sous-titre page d'accueil
- [ ] Ajouter contenu SEO page Boutique
- [ ] Optimiser 6 catégories produits (descriptions + Yoast)
- [ ] Installer Code Snippets + PHP
- [ ] Vérifier dans 1 semaine : Google Search Console → Pages indexées

---

**Temps total : 3-4 heures max**

*Fichier créé le 16/09/2026*
*EauService - eau-service-events.fr*
