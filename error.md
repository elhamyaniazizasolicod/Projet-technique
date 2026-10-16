---
marp: true
theme: default
paginate: true
---

### Correction des erreurs JavaScript

**Problème 1 : Variable non définie**

La variable `value` était utilisée sans être déclarée, ce qui provoquait une erreur `ReferenceError`.

**Solution :** utiliser `nom_matiere.value` pour récupérer la valeur saisie dans le champ du formulaire.
---
---
**Problème 2 : Erreur dans le header HTTP**

Le nom `Content-Tupe` était incorrect.

**Solution :** remplacer par `Content-Type` pour indiquer que les données envoyées sont au format JSON.
---
---
**Problème 3 : Duplication des données affichées**

Les anciennes lignes du tableau n'étaient pas supprimées avant le nouvel affichage.

**Solution :** vider le tableau avec `tablebody.innerHTML = ""` avant d'ajouter les nouvelles données.
---
**Résultat attendu :** le formulaire récupère correctement les informations, envoie les données à l'API et actualise le tableau après l'ajout d'une matière.