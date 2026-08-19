LocAchat



\## Informations à destination de l'évaluateur

pour avoir accès au Dashboard Administrateur voir le fichier INFORMATIONS\_EVALUATEUR.md







LocAchat est une application web en PHP permettant la gestion de location et de vente de véhicule.

Ce projet permet:

* La consultation d'un catalogue de véhicule disponible  à la vente ou en location sur l'application.
* Création de compte utilisateur
* Connexion Utilisateur
* La visualisation du détail d'un véhicule
* La réservation de véhicule à la location
* La commande de véhicule à l'achat
* La visualisation et suivi des commande dans l'espace client
* La gestion du parc de véhicule depuis un espace administrateur

Les fonctionnalités

Utilisateur:

* Création de compte
* Connexion/ Déconnexion
* Recherche véhicule
* Affichage et consultation du catalogue de véhicules
* Consultation des détails des véhicules
* Commande de véhicules
* Réservation de véhicule
* Suivi de commande
* Téléversement de documents lors des commandes

Administration:

* Espace d’administration
* Affichage des commandes en attente de validation
* Validation ou rejet des commandes
* Ajout/suppression des véhicules à la vente
* Ajout/suppression des véhicules à la location



Technologies utilisées
PHP
Mysql/MariaDB(XAMPP)
PHPAdmin interface graphique pour gérer les données
HTML
CSS
PHPUnit
Git/GitHub
VSCode

Les tables principaux

users
vehicule
table\_statu\_command
table\_commandes



Structure

index.php
index\_catalogue\_globale.php
index\_detail\_voiture.php
car\_sale.php(Commande achat véhicule)
index\_detail\_voiture\_location.php
commande\_voiture\_location.php
index\_cnxn\_creacompte.php
cnxn.php
creacompte.php
espace\_client\_news.php
annul\_commandes.php
enreg\_document.php

dashboard\_admin.php
admin\_ajout\_location.php
insert\_v\_loc.php
supp\_vehicule.php
ajout\_achat.php
insert\_v\_achat.php
delete\_cara.php



Installation
Cloner le projet:
git clone   https://github.com/Jas-974/sit-achat-loc-auto.git

Accéder au projet:

cd sit-achat-loc-auto

Créer une base de donnée:

CREATE DATABASE bd\_locachat;

Modifier les paramètres dans :
config.php, enreg\_document.php, espace\_client\_news.php, index.php, index\_catalogue\_globale.php

$host = "localhost";
$dbname = "bd\_locachat";
$user = "root";
$pass = "";



Les tests à faire sur PHPUnit
vendor\\bin\\phpunit.bat
Exemple:
vendor\\bin\\phpunit.bat "tests\\Test command voiture location\\RecupUtilisateurDeLaCommandeTest.php"



Les branches Git :
Bug 					> Correction de bug
Dev 					> Développement
Hotfix 					> Correctif Urgent
Release 				> Gestion des version
Tests 					> Les Tests
feature					> Fonctionalité
main 					> version stable
maj-code-en-ligne 			> Validation de vesrion avant le merge avec le main



Projet réalisé dans le cadre de la formation de Bachelor Devloppement WEB

Auteur : AMABLE Jasmin

