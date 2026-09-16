# ⚡ QUICK START SEO - 7 JOURS
## Eau-Service-Events.fr

**Objectif : Débloquer votre référencement EN 1 SEMAINE**

Ce plan est conçu pour obtenir des résultats RAPIDES avec un minimum d'effort par jour (30min à 2h selon le jour).

---

## 🎯 JOUR 1 - LUNDI (30 minutes)
### 🔓 DÉBLOQUER L'INDEXATION

**PRIORITÉ ABSOLUE : Vérifier que Google PEUT indexer votre site**

### Actions :

#### 1. Vérifier la case "ne pas indexer" (5 min)
```
WordPress → Réglages → Lecture
```
- Descendre jusqu'à la section "Visibilité pour les moteurs de recherche"
- Vérifier que la case **"Demander aux moteurs de recherche de ne pas indexer ce site"** est **DÉCOCHÉE**
- Si elle est cochée ➜ LA DÉCOCHER immédiatement
- Enregistrer

**✅ Si elle était cochée, c'était ÇA votre problème d'indexation.**

#### 2. Créer compte Google Search Console (15 min)
```
https://search.google.com/search-console
```
- Cliquer "Ajouter une propriété"
- Choisir "Préfixe d'URL"
- Entrer : `https://eau-service-events.fr/`
- Vérification via WordPress (plugin Yoast génère un code) OU via fichier HTML

#### 3. Soumettre le sitemap (10 min)
```
Search Console → Sitemaps (menu gauche)
```
- Dans "Ajouter un sitemap", entrer : `sitemap_index.xml`
- Cliquer "Envoyer"
- Attendre quelques secondes
- Vérifier statut "Réussi" (peut prendre quelques heures)

### ✅ Résultat Jour 1 :
- [ ] Case "ne pas indexer" DÉCOCHÉE
- [ ] Compte Search Console créé
- [ ] Sitemap soumis

**📝 Note :** Search Console met 24-48h à remonter les premières données. Normal.

---

## 🎯 JOUR 2 - MARDI (1h30)
### 🗺️ GOOGLE BUSINESS PROFILE (IMPACT ÉNORME)

**Le levier n°1 du référencement local. À faire ABSOLUMENT.**

### Actions :

#### 1. Créer/Réclamer la fiche Google Business (20 min)
```
https://www.google.com/business/
```
- Se connecter avec compte Google
- "Ajouter votre établissement"
- OU si la fiche existe déjà : "Revendiquer cet établissement"
- Suivre les étapes de vérification (code postal ou téléphone)

#### 2. Remplir les informations (30 min)

**Informations de base :**
- Nom : `EauService`
- Adresse : `2 chemin des Frères Garberro, Galerie Marchande, 06600 Antibes`
- Téléphone : `07 61 46 57 20`
- Site web : `https://eau-service-events.fr/`

**Catégories (CRUCIAL) :**
- **Principale** : Service de location de matériel pour événements
- **Secondaires** (ajouter 2-3) :
  - Location de matériel audiovisuel
  - Service d'organisation d'événements
  - Distributeur de café

**Zone desservie** (ajouter TOUTES ces villes) :
- Cannes
- Nice
- Monaco
- Antibes
- Juan-les-Pins
- Grasse
- Menton
- Cagnes-sur-Mer
- Saint-Laurent-du-Var
- Valbonne
- Mougins
- Villeneuve-Loubet

**Horaires :**
- Définir vos horaires d'ouverture
- Si pas de local physique ouvert au public : choisir "Entreprise en ligne"

#### 3. Rédiger la description (20 min)

**Copier-coller ce texte (puis personnaliser si besoin) :**

```
EauService est spécialiste de la location de matériel événementiel sur la Côte d'Azur. Nous équipons vos salons, congrès, séminaires et événements professionnels à Cannes, Nice, Monaco et Antibes.

Notre gamme : machines à café professionnelles (Nespresso, Lavazza, Covim, Gemini), fontaines à eau à bonbonne, réfrigérateurs et mobilier événementiel.

Service clé en main : livraison sur stand, installation, entretien et reprise après l'événement. Nous intervenons au Palais des Festivals de Cannes, Grimaldi Forum Monaco, Palais des Congrès Acropolis Nice et tous sites événementiels de la région.

Devis gratuit sous 24h. Location courte durée (événements) et longue durée (bureaux/entreprises).
```

#### 4. Ajouter 1ère photo (20 min)

**Minimum aujourd'hui : 3 photos**
- 1 photo de logo
- 1 photo d'une machine à café
- 1 photo d'une fontaine à eau

**Formats acceptés :** JPG ou PNG
**Taille recommandée :** 720 x 720 px minimum

### ✅ Résultat Jour 2 :
- [ ] Fiche Google Business créée/réclamée
- [ ] Informations complètes (nom, adresse, tél, catégories)
- [ ] Description optimisée
- [ ] Zones desservies (12 villes)
- [ ] 3 photos minimum

---

## 🎯 JOUR 3 - MERCREDI (1h)
### 📸 PHOTOS & 📊 DONNÉES STRUCTURÉES

### Actions :

#### 1. Ajouter 7 photos supplémentaires à Google Business (30 min)

**Photos à ajouter (objectif : 10 photos total) :**
- Photo de couverture (mise en scène de votre activité)
- 2-3 photos de produits supplémentaires (frigo, pack complet...)
- 1 photo d'installation sur stand (si vous en avez)
- 1 photo de l'équipe (humanise)
- 1-2 photos de véhicules de livraison (si possible)

**Comment :**
```
Google Business Profile → Photos → Ajouter des photos
```

**💡 Astuce :** Utiliser les images que vous avez déjà dans votre projet (Pack complet covim.png, fontaine_a_eau_grise_everest.png, etc.)

#### 2. Remplir les données structurées (30 min)

**Fichier à modifier : `eauservice-functions.php`**

**Localiser la section 9 (ligne ~570-600) :**

```php
// ---- À PERSONNALISER ----------------------------------------------
$nom        = 'EauService';
$telephone  = '+33 7 61 46 57 20';                  // ✅ DÉJÀ BON
$rue        = '2 chemin des Frères Garberro, Galerie Marchande';  // ✅ VÉRIFIER
$code_postal= '06600';                              // ✅ VÉRIFIER
$ville      = 'Antibes';                            // ✅ VÉRIFIER
$lien_maps  = 'https://share.google/Lc43vOOKwCr2ybn0o'; // ✅ DÉJÀ BON
$image      = 'https://eau-service-events.fr/wp-content/uploads/logo.png'; // ⚠️ À VÉRIFIER
// -------------------------------------------------------------------
```

**Action :**
1. Vérifier que ces infos sont exactes
2. Remplacer l'URL de l'image par celle de votre vrai logo uploadé
3. Sauvegarder le fichier
4. Mettre en ligne (via FTP OU via Code Snippets)

#### 3. Tester les données structurées (5 min)

```
https://search.google.com/test/rich-results
```
- Coller l'URL : `https://eau-service-events.fr/`
- Cliquer "Tester l'URL"
- Vérifier que "LocalBusiness" et "FAQPage" sont détectés **SANS erreur**
- Si erreur → noter et corriger

### ✅ Résultat Jour 3 :
- [ ] 10 photos sur Google Business Profile
- [ ] Données structurées remplies et en ligne
- [ ] Test rich-results SANS erreur

---

## 🎯 JOUR 4 - JEUDI (1h30)
### 🔍 DEMANDER L'INDEXATION + 🖼️ OPTIMISER IMAGES

### Actions :

#### 1. Demander l'indexation des 10 pages prioritaires (45 min)

```
Google Search Console → Inspection de l'URL (barre en haut)
```

**Pour CHAQUE URL ci-dessous :**
1. Coller l'URL complète
2. Appuyer sur Entrée
3. Attendre l'analyse (30 secondes)
4. Cliquer "Demander une indexation"
5. Confirmer
6. Attendre confirmation (1-2 min)

**10 URLs à indexer :**
```
https://eau-service-events.fr/
https://eau-service-events.fr/boutique/
https://eau-service-events.fr/categorie-produit/packs/
https://eau-service-events.fr/categorie-produit/machines-a-cafe/
https://eau-service-events.fr/categorie-produit/fontaines-a-eau/
https://eau-service-events.fr/categorie-produit/refrigeration/
https://eau-service-events.fr/categorie-produit/mobilier-confort/
https://eau-service-events.fr/location-fontaine-eau-machine-cafe-cannes/
https://eau-service-events.fr/location-fontaine-eau-machine-cafe-nice/
https://eau-service-events.fr/location-fontaine-eau-machine-cafe-monaco/
```

**⏱️ Temps : ~4-5 min par URL = 45 min total**

#### 2. Installer Smush (compression images) (10 min)

```
WordPress → Extensions → Ajouter
```
- Rechercher "Smush"
- Installer "Smush – Lazy Load Images, Optimize & Compress Images"
- Activer
- Aller dans Smush → Tableau de bord
- Cliquer "Bulk Smush" (compression automatique de toutes les images)
- Attendre la fin (peut prendre 5-10 min selon le nombre d'images)

#### 3. Ajouter attributs ALT sur 5 produits (35 min)

**Aller sur 5 fiches produits et optimiser les images :**

```
WordPress → Produits → Tous les produits
```

**Pour chaque produit :**
1. Ouvrir le produit
2. Cliquer sur l'image principale
3. Dans "Texte alternatif", écrire une description :

**Exemples :**
```
❌ Mauvais : "Pack complet covim"
✅ Bon : "Location Pack complet machine à café Covim pour salon et événement"

❌ Mauvais : "Fontaine eau"
✅ Bon : "Location fontaine à eau à bonbonne Everest avec eau fraîche et chaude"

❌ Mauvais : "Zenius"
✅ Bon : "Location machine à café Nespresso Zenius professionnelle pour événement"
```

**Faire pour 5 produits** (vous ferez les autres plus tard)

### ✅ Résultat Jour 4 :
- [ ] 10 pages demandées en indexation
- [ ] Smush installé et images compressées
- [ ] 5 produits avec attribut ALT optimisé

---

## 🎯 JOUR 5 - VENDREDI (2h)
### 📝 CRÉER 1ÈRE PAGE LIEU (PALAIS DES FESTIVALS)

**Aujourd'hui on crée LA page qui va vous différencier : expertise d'un lieu événementiel.**

### Actions :

#### 1. Créer la page (1h30)

```
WordPress → Pages → Ajouter
```

1. **Titre de la page** : `Location de matériel événementiel au Palais des Festivals de Cannes`

2. **Ajouter un bloc "HTML personnalisé"**

3. **Copier-coller le contenu** depuis le fichier `PAGES-PRIORITAIRES-A-CREER.md` → PAGE 1

4. **Remplacer [À REMPLACER PAR URL IMAGE MEDIATHEQUE]** :
   - Cliquer sur "Ajouter média"
   - Uploader une image (une photo de machine à café ou fontaine eau)
   - Copier l'URL
   - Remplacer dans le code HTML

5. **Renseigner Yoast SEO** (en bas de page) :
   - Expression clé : `location matériel Palais des Festivals`
   - Titre SEO : `Location matériel Palais des Festivals Cannes | EauService`
   - Slug : `location-materiel-palais-festivals-cannes`
   - Méta description : `Location de machines à café, fontaines à eau et matériel événementiel au Palais des Festivals de Cannes. Livraison et installation sur stand. Connaissance des contraintes logistiques. Devis sous 24h.`

6. **Vérifier voyants Yoast AU VERT**

7. **Publier**

#### 2. Demander l'indexation (5 min)

```
Search Console → Inspection URL
```
- Coller : `https://eau-service-events.fr/location-materiel-palais-festivals-cannes/`
- Demander une indexation

#### 3. Ajouter le lien dans le menu (15 min)

```
WordPress → Apparence → Menus
```
- Créer un élément de menu "Palais des Festivals Cannes"
- Lien : `/location-materiel-palais-festivals-cannes/`
- Placer dans sous-menu "Zones desservies" (ou créer cette rubrique)
- Enregistrer

#### 4. Ajouter le lien en footer (10 min)

```
WordPress → Apparence → Widgets → Footer
```
- Ajouter widget "Navigation"
- Titre : "Nos lieux d'intervention"
- Sélectionner le lien vers la page Palais des Festivals
- Enregistrer

### ✅ Résultat Jour 5 :
- [ ] Page "Palais des Festivals Cannes" créée et publiée
- [ ] Yoast au vert
- [ ] Indexation demandée
- [ ] Lien dans menu et footer

---

## 🎯 JOUR 6 - SAMEDI (1h)
### ⭐ OBTENIR LES PREMIERS AVIS GOOGLE

**Les avis sont LE critère n°1 pour le pack local Google.**

### Actions :

#### 1. Créer un lien court Google Review (15 min)

**Dans Google Business Profile :**
```
Google Business Profile → Accueil → Obtenir plus d'avis
```
- Copier le lien généré (format court)
- Ou utiliser : `https://g.page/r/VOTRE_CODE/review`

**💡 Astuce :** Raccourcir le lien avec bit.ly pour le rendre plus facile à partager

#### 2. Préparer le message email/SMS (15 min)

**Template email :**

```
Objet : Votre avis nous aide énormément 🙏

Bonjour [Prénom],

Merci d'avoir fait confiance à EauService pour [événement/salon/bureau].
Nous espérons que notre matériel et notre service vous ont pleinement satisfait.

Votre avis nous aide énormément à nous faire connaître et à rassurer
de futurs clients. Pourriez-vous prendre 2 minutes pour partager votre
expérience sur Google ?

👉 [LIEN GOOGLE REVIEW]

Un immense merci pour votre soutien !

Cordialement,
L'équipe EauService
07 61 46 57 20
```

**Template SMS :**

```
Bonjour [Prénom], merci pour votre confiance ! 
Votre avis nous aiderait énormément ⭐ 
[LIEN COURT] 
Merci ! - EauService
```

#### 3. Envoyer à 5 clients récents satisfaits (30 min)

**Sélectionner 5 clients :**
- Qui ont été satisfaits
- Événements récents (< 6 mois)
- Avec qui vous avez un bon contact

**Envoyer l'email OU le SMS**

**⏱️ Objectif : 2-3 avis dans les 7 jours**

### ✅ Résultat Jour 6 :
- [ ] Lien Google Review créé et raccourci
- [ ] Template email/SMS prêt
- [ ] 5 emails/SMS envoyés

---

## 🎯 JOUR 7 - DIMANCHE (30 min)
### 📊 SUIVI & PLANNING SEMAINE 2

**Aujourd'hui = jour de repos et de bilan.**

### Actions :

#### 1. Vérifier Search Console (15 min)

```
Google Search Console → Indexation → Pages
```

**Regarder :**
- Nombre de pages indexées (a-t-il augmenté ?)
- Pages "Détectées mais non indexées" → noter lesquelles
- Erreurs éventuelles → noter

**📝 Note :** Il est normal que toutes les pages ne soient pas indexées après 7 jours.
L'indexation prend 7-30 jours selon les pages.

#### 2. Vérifier Google Business (5 min)

```
Google Business Profile
```

**Regarder :**
- Des avis sont-ils arrivés ? (si oui, RÉPONDRE immédiatement)
- Statistiques : vues, clics (peuvent être à 0 les 1ers jours = normal)

#### 3. Remplir le tableau de suivi (10 min)

| Métrique | Valeur J7 |
|----------|-----------|
| Pages indexées (Search Console) | ? |
| Avis Google | ? |
| Photos Google Business | 10 |
| Trafic organique/semaine | ? (si Analytics installé) |
| Pages créées | 1 (Palais Festivals) |

#### 4. Planifier semaine 2 (10 min)

**Semaine 2 (à faire) :**
- [ ] Lundi : Créer page Grimaldi Forum Monaco
- [ ] Mardi : Créer page Acropolis Nice
- [ ] Mercredi : Optimiser 10 autres images produits (attribut ALT)
- [ ] Jeudi : Inscription 3 annuaires (Pages Jaunes, Yelp, Bedouk)
- [ ] Vendredi : Relance avis Google (clients qui n'ont pas répondu)
- [ ] Samedi : Repos
- [ ] Dimanche : Bilan semaine 2

### ✅ Résultat Jour 7 :
- [ ] Search Console vérifié et noté
- [ ] Google Business vérifié
- [ ] Tableau de suivi rempli
- [ ] Planning semaine 2 fait

---

## 🎉 BILAN SEMAINE 1

### ✅ Ce que vous avez accompli :

**JOUR 1 :**
- ✅ Indexation débloquée
- ✅ Search Console créé
- ✅ Sitemap soumis

**JOUR 2 :**
- ✅ Google Business Profile optimisé à 80%
- ✅ 12 zones desservies
- ✅ Description SEO

**JOUR 3 :**
- ✅ 10 photos sur Google Business
- ✅ Données structurées en ligne

**JOUR 4 :**
- ✅ 10 pages demandées en indexation
- ✅ Images compressées
- ✅ 5 produits optimisés

**JOUR 5 :**
- ✅ 1ère page lieu (Palais Festivals) créée
- ✅ Maillage interne commencé

**JOUR 6 :**
- ✅ Campagne avis Google lancée

**JOUR 7 :**
- ✅ Suivi et planning

---

## 📈 RÉSULTATS ATTENDUS (semaine 1-2)

**Semaine 1-2 :**
- Premières pages indexées (5-10)
- Google Business apparaît dans Maps
- 1-2 avis Google
- Site commence à être crawlé par Google

**Ne vous inquiétez pas si :**
- Le trafic est encore très faible (0-5 visiteurs/jour) = NORMAL
- Toutes les pages ne sont pas indexées = NORMAL
- Vous n'apparaissez pas encore en 1ère page Google = NORMAL

**Le SEO prend 3-6 mois. Vous venez de poser les fondations. Continuez !**

---

## 🚀 SEMAINE 2 - APERÇU

**Semaine 2 = créer les pages lieux manquantes + backlinks**

- Lundi : Page Grimaldi Forum Monaco
- Mardi : Page Acropolis Nice
- Mercredi : Optimisation images (10 produits)
- Jeudi : Inscription 3 annuaires
- Vendredi : Relance avis + répondre aux avis reçus

**Objectif fin semaine 2 :**
- 3 pages lieux créées
- 15 pages indexées
- 3-5 avis Google
- 5 backlinks (annuaires)

---

## ❓ FAQ - SEMAINE 1

**Q : Je ne vois aucun résultat dans Search Console après 7 jours**
R : Normal. Search Console met 3-7 jours à afficher les données. Patience.

**Q : Mes pages ne sont toujours pas indexées après 7 jours**
R : Normal. L'indexation prend 7 à 30 jours. Continuez les actions.

**Q : Je n'ai reçu aucun avis Google**
R : Relancez gentiment vos clients. Proposez d'appeler ceux qui ne répondent pas.

**Q : Google Business ne remonte pas dans la recherche**
R : Il faut 10-15 jours et au moins 3-5 avis pour commencer à apparaître.

**Q : C'est trop technique, je suis perdu**
R : Suivez le guide étape par étape. Demandez de l'aide si besoin.

**Q : Puis-je sauter des étapes ?**
R : NON. Chaque étape est cruciale. L'ordre est optimisé.

**Q : Combien de temps avant d'avoir du trafic ?**
R : 1-2 mois pour les 1ers visiteurs. 3-6 mois pour trafic significatif.

---

## 💪 MOTIVATION

**Vous avez fait 7 jours. Continuez 7 semaines. Puis 7 mois.**

**Le SEO récompense la constance, pas les rushs.**

1 heure par semaine pendant 6 mois > 10 heures d'un coup puis rien.

**Vous êtes sur la bonne voie. Ne lâchez rien ! 🚀**

---

## 📞 BESOIN D'AIDE ?

Si vous êtes bloqué sur une étape, demandez-moi de l'aide.
Je suis là pour vous guider.

**Prochaine étape : SEMAINE 2 → Créer les 2 autres pages lieux**

---

*Quick Start créé le 16 septembre 2026*
*EauService - Location matériel événementiel Côte d'Azur*
