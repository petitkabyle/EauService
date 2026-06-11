# 🧾 Installer le style de facture PDF professionnel — EauService

Vous utilisez l'extension **WooCommerce PDF Invoices & Packing Slips**.
Voici **2 méthodes** pour appliquer le nouveau design. Commencez par la plus simple.

---

## ✅ MÉTHODE 1 (la plus SIMPLE, recommandée) — Custom CSS du plugin

Beaucoup de versions du plugin offrent un champ "CSS personnalisé" :

1. **WooCommerce → Factures PDF → Réglages** (PDF Invoices)
2. Onglet **« Documents » → « Facture »** (Invoice)
3. Cherchez une option **« Custom CSS »** / **« CSS personnalisé »**
   (parfois dans un onglet "Advanced" ou via l'extension Premium)
4. Collez tout le contenu du fichier **style.css**
5. Enregistrez, puis régénérez une facture pour voir le rendu.

> Si vous ne trouvez PAS de champ Custom CSS (version gratuite), utilisez la Méthode 2.

---

## 🛠️ MÉTHODE 2 — Copier le template dans le thème (méthode officielle)

C'est ce que le message du plugin vous demandait. Il faut un accès aux
fichiers du site (FTP, ou Gestionnaire de fichiers de votre hébergeur,
ou plugin "File Manager").

### Étape A — Créer le dossier du template
Dans votre thème, créez ce dossier (exactement ce chemin) :
```
wp-content/themes/astra/woocommerce/pdf/eauservice/
```
> ⚠️ Idéalement, utilisez un **thème enfant** (astra-child) pour ne pas
> perdre la perso lors des mises à jour d'Astra :
> `wp-content/themes/astra-child/woocommerce/pdf/eauservice/`

### Étape B — Copier les fichiers de base du plugin
Copiez TOUT le contenu de :
```
wp-content/plugins/woocommerce-pdf-invoices-packing-slips/templates/Simple/
```
vers le dossier que vous venez de créer (`.../pdf/eauservice/`).
Vous devez y retrouver des fichiers comme : `invoice.php`, `packing-slip.php`,
`style.css`, etc.

### Étape C — Remplacer le style
Remplacez le fichier **style.css** copié par le **style.css** fourni ici
(celui d'EauService).

### Étape D — Sélectionner le template
1. **WooCommerce → Factures PDF → Réglages → onglet « Général »**
2. Champ **« Choisissez un modèle »** → sélectionnez **« eauservice »**
   (le nom du dossier apparaît dans la liste)
3. Enregistrez.

### Étape E — Régler les infos de la boutique (en-tête)
Toujours dans les réglages du plugin :
- **En-tête / Logo** : uploadez votre logo (idéalement version foncée ou
  avec contour, car le haut de la facture est clair).
- **Nom & adresse de la boutique** : renseignez votre raison sociale,
  adresse, SIRET, TVA, etc. (ils s'affichent en haut à droite).
- **Pied de page** : ajoutez vos mentions (SIRET, TVA, conditions, contact).

---

## 🧪 Vérifier le rendu
- Ouvrez une commande → bouton **« Créer facture PDF »** → **Aperçu/Télécharger**.
- Vérifiez : bandeau "FACTURE" bleu nuit, adresses en cadres bleutés,
  tableau produits avec en-tête foncé, total TTC mis en valeur.

---

## 💡 Conseils PRO pour une vraie facture conforme
Pensez à renseigner dans les réglages du plugin / de la boutique :
- **Numéro de facture** automatique (le plugin le gère)
- **SIRET** et **n° de TVA intracommunautaire**
- **Mentions légales** (ex : "TVA non applicable, art. 293 B du CGI" si auto-entrepreneur)
- **Conditions de location** / pénalités de retard si pertinent
- **Coordonnées de contact** (tél + e-mail) dans le pied de page

> Besoin d'aide pour le pied de page légal ou les mentions ? Dites-moi votre
> statut (auto-entrepreneur, SARL, SAS…) et je vous rédige le texte adapté.
