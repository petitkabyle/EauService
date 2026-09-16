# ✅ OPTIMISATIONS SIMPLES - SITE & BOUTIQUE
## Ce qu'il faut faire CONCRÈTEMENT (sans créer de pages inutiles)

---

## 🎯 VOTRE VRAIE SITUATION

Vous avez DÉJÀ :
- ✅ Google Search Console
- ✅ Fiche Google Business avec avis
- ✅ Site WordPress + WooCommerce
- ✅ Du contenu dans vos fichiers (HTML, PHP)

**Problème actuel :**
Votre site est mal référencé parce que vous vous battez contre des concurrents (Locafontaine, Culligan, GL Events) sur des mots-clés trop génériques ("location fontaine eau", "location machine café").

**Solution :**
Exploiter votre DIFFÉRENCE = vous êtes spécialiste **ÉVÉNEMENTIEL** (salons, congrès), pas bureaux.

---

## 📝 CE QUI MANQUE À VOTRE SITE (5 ACTIONS CONCRÈTES)

### ✅ ACTION 1 : Optimiser votre page d'accueil (2h)

**Problème actuel :**
Votre page d'accueil ne dit probablement pas assez clairement QUI vous êtes.

**Ce qu'il faut faire :**

1. **Ouvrir WordPress → Pages → Accueil → Modifier**

2. **Dans votre H1 (titre principal), ajoutez vos mots-clés :**
   ```
   Mauvais : "EauService - Location de matériel"
   
   Bon : "Location machines à café & fontaines à eau pour salons et congrès | Côte d'Azur"
   ```

3. **Dans le 1er paragraphe (les 100 premiers mots), ajoutez :**
   - Votre spécialité : événementiel (salons, congrès, stands)
   - Vos produits : machines à café, fontaines à eau bonbonne, frigos
   - Vos villes : Cannes, Nice, Monaco, Antibes
   - Votre différence : livraison + installation sur stand

   **Exemple :**
   ```
   EauService est spécialiste de la location de matériel événementiel sur la Côte d'Azur. 
   Nous équipons vos salons, congrès et stands à Cannes, Nice, Monaco et Antibes avec 
   machines à café professionnelles (Nespresso, Lavazza, Covim), fontaines à eau à bonbonne 
   et réfrigérateurs. Service clé en main : livraison, installation sur stand et reprise 
   après l'événement.
   ```

4. **Ajouter une section "Nous équipons" avec 3 blocs :**
   - 📍 **Salons professionnels** : Palais des Festivals Cannes, MIPIM, Cannes Lions...
   - 📍 **Congrès internationaux** : Grimaldi Forum Monaco, Acropolis Nice...
   - 📍 **Séminaires d'entreprise** : conventions, formations, événements privés

5. **Footer (pied de page) :**
   Ajouter une ligne :
   ```
   "Zones d'intervention : Cannes • Nice • Monaco • Antibes • Côte d'Azur"
   ```

**Temps : 2 heures**

---

### ✅ ACTION 2 : Optimiser la page Boutique (1h)

**Vous avez DÉJÀ le contenu dans `boutique-contenu-seo.html` !**

**Ce qu'il faut faire :**

1. **WordPress → Pages → Boutique → Modifier**

2. **Ajouter un bloc "HTML personnalisé" AVANT la grille de produits**

3. **Copier-coller TOUT le contenu de `boutique-contenu-seo.html`**
   (C'est déjà optimisé avec vos mots-clés)

4. **Remplacer l'URL de l'image** (ligne avec `<img src=...`) par une vraie image de votre médiathèque

5. **En bas de page, dans Yoast SEO :**
   - Expression clé : `location matériel événementiel Côte d'Azur`
   - Titre SEO : `Location matériel événementiel Côte d'Azur | EauService`
   - Méta description : `Location de machines à café, fontaines à eau et matériel événementiel sur la Côte d'Azur. Livraison sur vos salons et congrès à Cannes, Nice, Monaco. Devis sous 24h.`

6. **Mettre à jour**

**Temps : 1 heure**

---

### ✅ ACTION 3 : Optimiser les 6 catégories produits (2h)

**Vous avez DÉJÀ les descriptions dans `seo-categories.md` !**

**Ce qu'il faut faire pour CHAQUE catégorie :**

1. **WordPress → Produits → Catégories**

2. **Cliquer sur une catégorie (ex: "Packs")**

3. **Dans "Description", coller le HTML** (voir `seo-categories.md` section 1, 2, 3...)

4. **En bas, dans Yoast SEO :**
   - Expression clé : copier celle du fichier
   - Titre SEO : copier celui du fichier
   - Méta description : copier celle du fichier

5. **Mettre à jour**

**Répéter pour les 6 catégories :**
1. Packs événementiels
2. Machines à café
3. Fontaines à eau
4. Réfrigération
5. Mobilier & confort
6. Suppléments & accessoires

**Temps : 20 min par catégorie = 2 heures total**

---

### ✅ ACTION 4 : Ajouter le code PHP (30 min)

**Vous avez DÉJÀ le code dans `eauservice-functions.php` !**

**Ce qu'il fait :**
- Trie les produits (packs en premier)
- Ajoute des boutons "En savoir plus"
- Injecte du contenu SEO automatiquement sur la boutique
- Ajoute des données structurées (Google comprend mieux votre site)

**Comment l'installer :**

1. **WordPress → Extensions → Ajouter**

2. **Rechercher "Code Snippets"**

3. **Installer + Activer**

4. **Snippets → Ajouter**

5. **Titre : "EauService - Optimisations boutique et SEO"**

6. **Dans le code, coller TOUT le contenu de `eauservice-functions.php`**
   MAIS **ENLEVER la 1ère ligne** `<?php`

7. **IMPORTANT : Remplacer vos vraies infos (section 9, vers la ligne 570) :**
   ```php
   $nom        = 'EauService';
   $telephone  = '+33761465720';  // ✅ VÉRIFIER
   $rue        = '2 chemin des Frères Garberro, Galerie Marchande';  // ✅ VÉRIFIER
   $code_postal= '06600';
   $ville      = 'Antibes';
   $lien_maps  = 'https://share.google/Lc43vOOKwCr2ybn0o'; // ✅ METTRE VOTRE LIEN
   $image      = 'https://eau-service-events.fr/wp-content/uploads/VOTRE-LOGO.png'; // ✅ METTRE URL LOGO
   ```

8. **Choisir "Exécuter partout"**

9. **Activer**

**Temps : 30 minutes**

---

### ✅ ACTION 5 : Optimiser 10 images produits (1h)

**Pourquoi :**
Google "lit" vos images via l'attribut ALT. Si c'est vide ou mal rempli, vous perdez du référencement.

**Ce qu'il faut faire :**

1. **WordPress → Produits → Tous les produits**

2. **Pour 10 produits (à faire progressivement) :**

   a. Ouvrir le produit
   
   b. Cliquer sur l'image principale
   
   c. Dans "Texte alternatif" (ALT), écrire une description avec vos mots-clés :

**Exemples :**

```
❌ Mauvais : "IMG_1234.jpg"
✅ Bon : "Location Pack complet machine à café Nespresso avec fontaine à eau pour salon"

❌ Mauvais : "fontaine"
✅ Bon : "Location fontaine à eau à bonbonne Everest avec eau fraîche et chaude pour événement"

❌ Mauvais : "machine nespresso"
✅ Bon : "Location machine à café Nespresso Zenius professionnelle pour stand de salon"

❌ Mauvais : "frigo"
✅ Bon : "Location réfrigérateur table top pour stand événementiel Côte d'Azur"
```

**Formule magique pour l'ALT :**
```
Location [produit] [marque si applicable] pour [usage] [où]
```

3. **Mettre à jour le produit**

**Temps : 5-6 min par produit = 1 heure pour 10 produits**

---

## 🎨 POUR GARDER VOTRE SITE BEAU

**Vous avez raison : pas besoin d'ajouter des pages vides !**

Voici ce que vous pouvez faire à la place :

### Option A : Ajouter une section "Événements équipés" sur la page d'accueil

Au lieu de créer des pages par ville, ajoutez sur votre page d'accueil :

```html
<section>
  <h2>Les événements que nous équipons</h2>
  <p>Nous intervenons sur les plus grands salons et congrès de la Côte d'Azur :</p>
  <ul>
    <li><strong>Palais des Festivals de Cannes</strong> : MIPIM, MIPTV, Cannes Lions, Tax Free World</li>
    <li><strong>Grimaldi Forum Monaco</strong> : Monaco Yacht Show, Top Marques, congrès médicaux</li>
    <li><strong>Palais des Congrès Acropolis Nice</strong> : salons professionnels et conventions</li>
    <li><strong>Tous sites événementiels</strong> à Antibes, Juan-les-Pins, Grasse, Menton...</li>
  </ul>
  <p>Demandez votre devis gratuit sous 24h.</p>
</section>
```

**Avantage :**
- Google voit ces mots-clés (Palais des Festivals, Grimaldi Forum...)
- Ça reste joli et informatif
- Pas de page vide

### Option B : Enrichir la page À Propos / Qui sommes-nous

Si vous avez une page "À propos", ajoutez-y :

```
Notre expertise des lieux événementiels

Depuis X années, nous équipons les stands sur les principaux sites de la Côte d'Azur :
- Palais des Festivals de Cannes
- Grimaldi Forum Monaco
- Palais des Congrès Acropolis Nice

Nous connaissons parfaitement les contraintes logistiques de chaque lieu 
(horaires de montage, accès, badges...) et assurons une livraison et 
installation sans stress.
```

---

## 📊 CE QUE ÇA VA CHANGER

**Avant ces optimisations :**
- Vous êtes invisible sur Google (mots-clés trop génériques)
- Pas de différenciation vs concurrents
- Contenu pas optimisé

**Après ces 5 actions :**
- ✅ Google comprend que vous êtes spécialiste **ÉVÉNEMENTIEL**
- ✅ Vous apparaissez sur des recherches comme :
  - "location machine café salon Cannes"
  - "équipement événementiel Côte d'Azur"
  - "location fontaine eau congrès Nice"
  - "matériel stand Palais des Festivals"
- ✅ Meilleur référencement images (ALT optimisés)
- ✅ Site plus rapide et mieux structuré (code PHP)

---

## ⏱️ TEMPS TOTAL : 6H30

| Action | Temps |
|--------|-------|
| 1. Page d'accueil | 2h |
| 2. Page Boutique | 1h |
| 3. 6 catégories | 2h |
| 4. Code PHP | 30min |
| 5. 10 images | 1h |
| **TOTAL** | **6h30** |

**À faire sur 1 semaine = 1h par jour pendant 7 jours**

---

## ✅ CHECKLIST SIMPLE

### Cette semaine :
- [ ] Optimiser page d'accueil (H1 + 1er paragraphe + section événements)
- [ ] Coller contenu SEO page Boutique
- [ ] Optimiser 2 catégories (Packs + Machines à café)
- [ ] Installer Code Snippets + coller le PHP
- [ ] Vérifier infos (adresse, téléphone, lien Maps)
- [ ] Optimiser ALT de 5 produits

### Semaine prochaine :
- [ ] Optimiser 4 autres catégories (Fontaines, Frigos, Mobilier, Suppléments)
- [ ] Optimiser ALT de 5 autres produits
- [ ] Ajouter section "Événements équipés" sur page d'accueil (optionnel mais recommandé)

---

## 🎯 COMMENT SAVOIR SI ÇA MARCHE ?

**Dans 2-3 semaines, allez dans Google Search Console :**
```
Performances → Requêtes
```

Vous devriez commencer à voir des impressions (= apparitions dans Google) sur :
- location matériel événementiel
- location machine café salon
- location fontaine eau congrès
- équipement stand [ville]

**Dans 1-2 mois :**
- Vos pages commencent à être bien indexées
- Vous apparaissez sur des recherches longue traîne
- Vous recevez 2-5 demandes de devis via le site

**Dans 3-6 mois :**
- Vous apparaissez en page 1-2 sur vos mots-clés de niche
- 10-20 demandes de devis/mois via le site

---

## 💡 RÈGLES D'OR

### ✅ À FAIRE :
- Écrire naturellement pour l'humain (pas pour Google)
- Répéter vos mots-clés 3-5 fois par page (pas 50 fois)
- Garder votre site beau et professionnel
- Ajouter du contenu utile et informatif

### ❌ À NE PAS FAIRE :
- Créer des pages vides juste pour le SEO (vous avez raison !)
- Répéter 50 fois "location fontaine eau" sur une page
- Copier-coller du contenu de concurrents
- Acheter des backlinks

---

## 🚀 PAR OÙ COMMENCER MAINTENANT ?

**AUJOURD'HUI (30 min) :**
1. Lire ce document ✅
2. Ouvrir WordPress
3. Aller dans Pages → Accueil → Modifier
4. Modifier le H1 et le 1er paragraphe (voir ACTION 1)
5. Enregistrer

**DEMAIN (1h) :**
1. Installer Code Snippets
2. Coller le PHP (ACTION 4)
3. Vérifier vos infos (adresse, téléphone, Maps)

**APRÈS-DEMAIN (1h) :**
1. Optimiser page Boutique (ACTION 2)

Etc...

---

## 📞 BESOIN D'AIDE ?

Si vous voulez que je vous aide à :
- Rédiger un paragraphe spécifique
- Vérifier si une action est bien faite
- Clarifier une étape

➜ **Demandez-moi !**

---

**Prêt à optimiser votre site SIMPLEMENT ? 🚀**

*Document créé le 16 septembre 2026*
*EauService - Location matériel événementiel Côte d'Azur*
