## Getting started

```bash
docker-compose build --pull --no-cache
docker-compose up -d
```

```
# URL
http://127.0.0.1 ou http://localhost/

# Env DB (à mettre dans .env, si pas déjà présent)
DATABASE_URL="postgresql://postgres:password@db:5432/db?serverVersion=13&charset=utf8"
```

## Commandes utiles
```
# Lister l'ensemble des commandes existances 
docker-compose exec php bin/console

# Supprimer le cache du navigateur
docker-compose exec php bin/console cache:clear

# Création de fichier vierge
docker-compose exec php bin/console make:controller
docker-compose exec php bin/console make:form

# Création d'un CRUD complet
docker-compose exec php bin/console make:crud

# Lister les routes
docker-compose exec php bin/console debug:router

# FAST DEV Mode with vitejs (hmr)
yarn && yarn dev
```

## Gestion de base de données

#### Commandes de création d'entité
```
docker-compose exec php bin/console make:entity
```
Document sur les relations entre les entités
https://symfony.com/doc/current/doctrine/associations.html

#### Mise à jour de la base de données
```
# Ouvrir adminer
127.0.0.1:8080

# Voir les requètes qui seront jouer avec force
docker-compose exec php bin/console doctrine:schema:update --dump-sql

# Executer les requètes en DB
docker-compose exec php bin/console doctrine:schema:update --force

# Supprimer la DB
docker-compose exec php bin/console d:d:d --force

# Creer la DB
docker-compose exec php bin/console d:d:c

# Faire des requetes SQL en CLI
docker-compose exec php bin/console d:q:s "SQL_REQUEST"
```

#### Fixtures
```
docker-compose exec php bin/console doctrine:fixtures:load
```
https://github.com/fzaninotto/Faker

https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html

## Gestion des messages flash
https://symfony.com/doc/current/controller.html#flash-messages

## Vitejs configuration
https://vitejs.dev/guide/api-plugin.html#configureserver

## Autres outils utils
Messages de validation

https://symfony.com/doc/current/validation.html

Systeme de verification d'accès

https://symfony.com/doc/current/security/voters.html
