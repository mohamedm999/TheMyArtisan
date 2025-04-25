# MyArtisan Platform

MyArtisan est une plateforme qui connecte des artisans qualifiés avec des clients recherchant des services spécialisés. La plateforme facilite la découverte, la réservation et le paiement de services artisanaux.

## Structure du Projet

Le projet est organisé comme suit :

### Documentation

Tous les livrables du projet sont disponibles dans le dossier `/Documentation` :

- **Cahier des Charges** - Contient les user stories et exigences fonctionnelles
- **Conception** - Inclut les diagrammes UML (cas d'utilisation, classes)
- **Maquette** - Contient les maquettes pour versions desktop et mobile
- **Présentation** - Contient la présentation du projet et le Scrum Board

### Application

L'application est développée avec Laravel (PHP) et suit une architecture MVC:

- **/app** - Logique métier de l'application
  - **/Console** - Commandes personnalisées
  - **/Exceptions** - Gestion des erreurs
  - **/Http** - Contrôleurs et middlewares
  - **/Models** - Modèles de données
  - **/Notifications** - Notifications système
  - **/Observers** - Observateurs pour les modèles
  - **/Providers** - Fournisseurs de services
  - **/Repositories** - Accès aux données
  - **/Services** - Services métier

- **/config** - Fichiers de configuration
- **/database** - Migrations et seeders
- **/public** - Point d'entrée et assets web
- **/resources** - Views et assets non-compilés
- **/routes** - Définition des routes
- **/storage** - Fichiers générés par l'application
- **/tests** - Tests unitaires et d'intégration

## Installation

### Prérequis
- PHP >= 7.4
- Composer
- MySQL ou MariaDB
- Node.js et NPM

### Étapes d'installation

1. Cloner le dépôt :
   ```
   git clone https://github.com/mohamedm999/TheMyArtisan.git
   cd MyArtisan-platform
   ```

2. Installer les dépendances :
   ```
   composer install
   npm install
   ```

3. Configurer l'environnement :
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Configurer la base de données dans le fichier `.env`

5. Exécuter les migrations :
   ```
   php artisan migrate --seed
   ```

6. Compiler les assets :
   ```
   npm run dev
   ```

7. Démarrer le serveur de développement :
   ```
   php artisan serve
   ```

## Accès au Projet

- **Application** : http://localhost:8000 après démarrage du serveur local
- **Documentation** : Disponible dans le dossier `/Documentation`
- **GitHub** : [https://github.com/mohamedm999/TheMyArtisan](https://github.com/mohamedm999/TheMyArtisan)

## Fonctionnalités Principales

- Inscription et authentification des utilisateurs (clients et artisans)
- Recherche d'artisans par catégorie et localisation
- Réservation et paiement de services
- Système d'évaluation et d'avis
- Messagerie entre clients et artisans
- Tableau de bord pour artisans et clients
- Gestion des disponibilités pour artisans
- Système de certification des artisans
- Administration de la plateforme

## Technologies Utilisées

- **Backend** : Laravel (PHP)
- **Frontend** : Blade, JavaScript, Vue.js
- **Base de données** : MySQL/MariaDB
- **Authentification** : Laravel Sanctum
- **Emails** : Laravel Mail
- **Files Storage** : Laravel Storage
