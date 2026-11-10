# Architecture du prototype

Le backend sépare les responsabilités en trois couches :

```text
frontend/
  index.html, assets/main.js   Interface et appels HTTP
backend/
  api/controllers/             Réception des requêtes HTTP et réponses JSON
  services/                    Validation et règles métier
  dao/                         Lecture et écriture des matières
  class/                       Modèle Matiere
  data/                        Stockage JSON
```

Le parcours d'une requête est `Frontend → Controller → Service → DAO → fichier JSON`.
Pour lister les matières, l'API répond à `GET /backend/api/controllers/controllerMatiere.php`.
Pour en ajouter une, elle accepte `POST` avec un corps JSON contenant `nom` et `description`.

Depuis le dossier `prototype`, lancer `php -S localhost:8000`, puis ouvrir
`http://localhost:8000/frontend/`.
