# Guide SEO EauService — Faire indexer le site et grimper sur Google

> Site : https://eau-service-events.fr/
> Objectif : passer de "1 page indexée" à toutes les pages indexées, puis grimper sur les requêtes locales (Cannes, Nice, Monaco, Antibes).

---

## ⚡ Pourquoi tu n'apparais pas (le vrai problème)

Avoir tout au vert dans Yoast = la page est **bien écrite**. Ça ne dit RIEN à Google.
Le classement dépend de 3 choses :
1. **L'indexation** — Google a-t-il vu et accepté la page ? (← ton blocage : 1 seule page indexée)
2. **L'autorité** — d'autres sites parlent-ils de toi ? (= backlinks)
3. **Le temps + l'activité** — un site neuf met 1 à 6 mois à émerger.

On attaque les 3, dans l'ordre.

---

## ÉTAPE 1 — Débloquer l'indexation (URGENT, cette semaine)

### 1.1 Vérifier que le site n'est PAS bloqué
WordPress → **Réglages → Lecture** → la case
**« Demander aux moteurs de recherche de ne pas indexer ce site »** doit être **DÉCOCHÉE**.
(Si elle est cochée, c'est l'explication à 100 % — c'est l'oubli le plus fréquent après une mise en ligne.)

### 1.2 Soumettre le sitemap dans Search Console
- Search Console → **Sitemaps**
- Ajoute : `sitemap_index.xml`  (Yoast le génère automatiquement)
- Vérifie qu'il est "Réussi" et compte le nombre d'URL découvertes.

### 1.3 Forcer l'indexation page par page
Dans Search Console → barre **« Inspection de l'URL »** en haut, colle chaque URL importante puis clique **« Demander une indexation »** :
- la page d'accueil
- la page boutique
- les 5 pages catégories (packs, machines-a-cafe, fontaines-a-eau, refrigeration, mobilier-confort)
- les 4 nouvelles pages locales (voir étape 3)

> Fais-le pour ~10 URL prioritaires. Google les met ensuite en file d'indexation (quelques jours).

### 1.4 Diagnostiquer les pages "non indexées"
Search Console → **Indexation → Pages** → regarde la colonne **"Pourquoi les pages ne sont pas indexées"**.
Causes fréquentes et solutions :
- *"Détectée, actuellement non indexée"* → normal sur site neuf, redemande l'indexation + crée des liens internes (étape 4).
- *"Explorée, actuellement non indexée"* → contenu jugé trop léger : étoffe le texte.
- *"Bloquée par robots.txt"* → débloque dans Yoast / robots.txt.
- *"Balise noindex"* → enlève le noindex (Yoast → réglages de la page).

---

## ÉTAPE 2 — Vérifier que le schema est correct

Le code `eauservice-functions.php` contient maintenant tes vraies infos
(adresse Antibes, tél 07 61 46 57 20, fiche Google).
Après mise en ligne, teste-le ici :
**https://search.google.com/test/rich-results** → colle ton URL → tu dois voir
"LocalBusiness" et "FAQPage" détectés sans erreur.

---

## ÉTAPE 3 — Publier les 4 pages locales (gros levier)

Les fichiers sont prêts dans le dépôt :
- `seo-page-cannes.html`   → page "Location ... à Cannes"
- `seo-page-nice.html`     → page "Location ... à Nice"
- `seo-page-monaco.html`   → page "Location ... à Monaco"
- `seo-page-antibes.html`  → page "Location ... à Antibes"

Pour chacune :
1. WordPress → **Pages → Ajouter** → mets le **Titre de page** indiqué en haut du fichier (c'est le H1).
2. Bloc **HTML personnalisé** → colle le contenu (sans les lignes de commentaire `<!-- -->`).
3. Renseigne les **réglages Yoast** indiqués (expression clé, titre SEO, slug, meta description).
4. Remplace l'URL d'image par une vraie photo de ta médiathèque (avec un `alt` descriptif).
5. Publie, puis demande l'indexation (étape 1.3).

> Règle d'or SEO : **1 page = 1 mot-clé principal**. C'est pour ça qu'on fait une page par ville
> au lieu de tout mettre sur l'accueil.

---

## ÉTAPE 4 — Maillage interne (aide énormément l'indexation)

Google découvre les pages en suivant les liens. Une page sans lien entrant = quasi invisible.
- Dans le **menu** ou le **pied de page**, ajoute une rubrique "Zones desservies" avec des liens vers les 4 pages locales.
- Sur la page d'accueil et la boutique, ajoute une phrase avec liens :
  "Nous intervenons à [Cannes](...), [Nice](...), [Monaco](...) et [Antibes](...)."
- Chaque page locale renvoie déjà vers les catégories produits (déjà intégré).

---

## ÉTAPE 5 — Google Business Profile (le n°1 du SEO LOCAL)

- Profil rempli à **100 %** : catégorie principale "Service de location de matériel", catégories secondaires, zone desservie (Cannes, Nice, Monaco, Antibes), horaires, description avec mots-clés.
- **10+ photos** du matériel, du logo, d'installations sur stand.
- **Avis clients** : demande systématiquement un avis Google à chaque client satisfait.
  C'est LE critère n°1 pour apparaître dans le "pack local" (la carte Google). Vise 10 avis pour démarrer.
- Publie un **"Post Google"** toutes les 1-2 semaines (nouvelle offre, événement équipé...).
- Vérifie que **NAP** (Nom, Adresse, Téléphone) est **identique** partout : site, Google, annuaires.

---

## ÉTAPE 6 — Backlinks & visibilité (sur la durée)

Plus de sites sérieux pointent vers toi, plus Google te fait confiance. Pistes faciles :
- Annuaires pro et locaux : Pages Jaunes, annuaires CCI Nice Côte d'Azur, annuaires événementiel.
- Partenaires : traiteurs, agences événementielles, loueurs de mobilier, organisateurs de salons.
- Sites des lieux / offices de tourisme d'affaires si possible.
- Réseaux sociaux pro (LinkedIn, Instagram) avec lien vers le site.

---

## ÉTAPE 7 — Les bons mots-clés (par intention)

> Cœur de métier EauService : **fontaines à eau à bonbonne** + **machines à café**, et aussi **réfrigérateurs**.
> On met donc ces 3 produits en avant, pas le terme vague "matériel événementiel".

**Priorité 1 — local + intention d'achat :**
- location fontaine à eau Cannes / Nice / Monaco / Antibes
- location machine à café Cannes / Nice / Monaco / Antibes
- location fontaine à eau à bonbonne [ville]
- location fontaine à eau entreprise / bureau [ville]
- location réfrigérateur [ville]

**Priorité 2 — longue traîne (facile à gagner) :**
- location fontaine à eau bonbonne avec livraison
- louer une machine à café professionnelle pour bureau
- fontaine à eau bureau Côte d'Azur prix
- location machine à café Nespresso / Lavazza professionnelle PACA
- location fontaine à eau courte durée pour événement

**Où les placer (par ordre d'importance) :**
1. Titre SEO (Yoast) — facteur n°1
2. H1 (titre de la page)
3. URL / slug
4. 100 premiers mots du texte
5. Sous-titres (H2) et balises alt des images

> Astuce : dans Search Console → **Performances → Requêtes**, tu verras les mots exacts
> tapés par les gens qui te trouvent. Crée/optimise une page pour chaque requête intéressante.

---

## ⏱️ À quoi s'attendre (réaliste)

- **Semaine 1-2** : pages indexées (après demande d'indexation).
- **Mois 1-2** : premières apparitions sur les requêtes longue traîne et le nom de marque.
- **Mois 3-6** : montée progressive sur les requêtes locales si les avis Google et le contenu suivent.

⚠️ Personne ne peut garantir la 1re position : ça dépend de la concurrence et du temps.
Mais avec l'indexation débloquée + pages locales + avis Google, tu vas commencer à exister
et grimper régulièrement.

---

## ✅ Checklist rapide

- [ ] Case "ne pas indexer" décochée (Réglages → Lecture)
- [ ] Sitemap soumis dans Search Console
- [ ] Indexation demandée pour 10 URL prioritaires
- [ ] Schema testé (rich-results) sans erreur
- [ ] 4 pages locales publiées + réglages Yoast
- [ ] Liens vers les pages locales ajoutés (menu / pied de page)
- [ ] Google Business à 100 % + 10 photos
- [ ] Premiers avis Google demandés
- [ ] Inscription sur 3-5 annuaires
