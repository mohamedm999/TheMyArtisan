# Diagramme de Cas d'Utilisation - MyArtisan Platform

## Description
Ce diagramme de cas d'utilisation représente les principales interactions des différents acteurs avec la plateforme MyArtisan.

```
                                +------------------------+
                                |                        |
                                |  MyArtisan Platform    |
                                |                        |
                                +------------------------+
                                        ^    ^    ^
                                       /     |     \
                                      /      |      \
                                     /       |       \
                +----------------+  /        |        \  +------------------+
                |                | /         |         \ |                  |
                |    Client      |/          |          \|    Artisan       |
                |                |           |           |                  |
                +----------------+           |           +------------------+
                        |                    |                    |
                        |                    |                    |
                        v                    v                    v
                +--------------+    +-----------------+    +----------------+
                | - S'inscrire |    | - Gérer profil  |    | - S'inscrire   |
                | - Se connecter|    | - Gérer comptes |    | - Se connecter |
                | - Chercher   |    | - Modérer avis  |    | - Créer profil |
                | - Réserver   |    | - Créer catég.  |    | - Offrir service|
                | - Payer      |    |                 |    | - Disponibilités|
                | - Évaluer    |    |                 |    | - Accepter/refus|
                +--------------+    +-----------------+    +----------------+
                                             ^
                                             |
                                    +------------------+
                                    |                  |
                                    | Administrateur   |
                                    |                  |
                                    +------------------+
```

## Acteurs principaux
1. **Client** - Utilisateur cherchant des services d'artisans
2. **Artisan** - Professionnel offrant ses services sur la plateforme
3. **Administrateur** - Gestionnaire de la plateforme

## Cas d'utilisation principaux

### Client
- S'inscrire et créer un compte
- Se connecter à son compte
- Rechercher des artisans par catégorie/localisation
- Consulter les profils d'artisans
- Réserver un service
- Payer un service
- Évaluer un artisan
- Communiquer avec un artisan

### Artisan
- S'inscrire et créer un profil professionnel
- Se connecter à son compte
- Configurer ses services et tarifs
- Gérer ses disponibilités
- Accepter/refuser des réservations
- Recevoir des paiements
- Communiquer avec les clients

### Administrateur
- Gérer les comptes utilisateurs
- Modérer les avis
- Gérer les catégories de services
- Surveiller les transactions
- Extraire des rapports d'activité

*Note: Ce fichier est un placeholder. Dans un projet réel, ce document serait accompagné d'un fichier image (.png, .jpg, ou .svg) créé avec un outil de modélisation UML comme StarUML, Draw.io, Lucidchart, Visual Paradigm, etc.*
