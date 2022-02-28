# Installation

## Contexte
Jimmy Sweat est un entrepreneur ambitieux passionné de snowboard. Son objectif est la création d'un site collaboratif pour faire connaître ce sport auprès du grand public et aider à l'apprentissage des figures (tricks).

Il souhaite capitaliser sur du contenu apporté par les internautes afin de développer un contenu riche et suscitant l’intérêt des utilisateurs du site. Par la suite, Jimmy souhaite développer un business de mise en relation avec les marques de snowboard grâce au trafic que le contenu aura généré.

Pour ce projet, nous allons nous concentrer sur la création technique du site pour Jimmy.

Votre mission : créer un site communautaire pour apprendre les figures de snowboard
Votre mission : créer un site communautaire pour apprendre les figures de snowboard

## Description du besoin
Vous êtes chargé de développer le site répondant aux besoins de Jimmy. Vous devez ainsi implémenter les fonctionnalités suivantes : 

un annuaire des figures de snowboard. Vous pouvez vous inspirer de la liste des figures sur Wikipédia. Contentez-vous d'intégrer 10 figures, le reste sera saisi par les internautes ;
la gestion des figures (création, modification, consultation) ;
un espace de discussion commun à toutes les figures.

Pour implémenter ces fonctionnalités, vous devez créer les pages suivantes :

- la page d’accueil où figurera la liste des figures ; 
- la page de création d'une nouvelle figure ;
- la page de modification d'une figure ;
- la page de présentation d’une figure (contenant l’espace de discussion commun autour d’une figure).
- L’ensemble des spécifications détaillées pour les pages à développer est accessible ici : Spécifications détaillées.

## Identifiants administrateur
- ruiz.nico64@gmail.com
- Test64170

## Configuration nécessaire
- Serveur web local ou en ligne
- Système de gestion de base de données relationnelle MySQL
- Installer Composer sur sa machine

## Instructions d'installation

##### 1/ Récupérez le projet github 
```
git clone https://github.com/nicrz/snowtricks
```
##### 2/ Créez une base de données dans PHPMyAdmin et importez-y le fichier P6_05_bdd.sql

##### 3/ Remplacez la ligne suivante de votre fichier .env avec les informations de connexions à la base de données que vous venez de créer.
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
##### 4/ Récupérez les dépendances du projet grâce à la commande suivante
```
composer install
```
##### 5/ Lancez le serveur Symfony grâce à la commande suivante
```
php bin/console server:start
```
##### 5/ Vous pouvez accéder à votre application depuis l'adresse suivante
```
http://127.0.0.1:8000/
```
