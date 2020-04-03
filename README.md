# Exercice 2

__Vous devez réaliser une application sur Symfony 5 qui permet de gérer des séries__ (les données peuvent être fictives).

### Détails importants

Tout formulaire doit faire l'objet :

- d'une vérification des champs envoyés,
- d'un message indiquant le succès ou les erreurs éventuellement rencontrées (les messages d'erreurs par défaut de _Symfony_ suffisent).

## Pages et fonctionnalités

### Page d'accueil
Cette page doit être découpée en 2 sections :

- Séries,
- Catégories (_humour_, _action_, _SF_, _horreur_, etc).

#### Section Series
Cette section doit afficher :

- le nombre de séries présentes dans la base de données,
- un lien vers la page Series.

#### Section Categorie
Cette section doit afficher :

- le nombre de catégories présentes dans la base de données,
- la liste des catégories présentes dans la base de données,
- un formulaire permettant de créer une catégorie.

La __liste des catégories__ doit afficher :

- le nom de la catégorie,
- un lien vers la fiche d'une catégorie,
- le nombre de films présents dans cette catgéorie.

Le __formulaire de création__ d'une catégorie doit seulement demander le nom de la catégorie.

### Page Serie
Cette page doit afficher la liste de toutes les séries présentes dans la base et posséder un formulaire permettant d'ajouter une nouvelle série.

La __liste des séries__ doit afficher :

- le nom de la série,
- l'année de début,
- l'année de fin (si la série n'est pas terminée, afficher "_en cours_")
- l'affiche de la série (image),
- le nombre de saisons,
- la catégorie de la série.

Au clic d'une série, on doit arriver sur sa fiche.

Le __formulaire d'ajout__ d'une série doit posséder les champs suivants :

- nom de la série,
- année de début,
- année de fin (si la série n'est pas terminée, ce champ doit pouvoir être vide)
- affiche de la série (image),
- nombre de saisons
- catégorie de la série (liste déroulante automatiquement renseigné grâce à la base de données).

### Fiche Série
Cette page doit afficher :

- le nom de la série,
- l'année de début,
- l'année de fin (si la série n'est pas terminée, afficher "_en cours_")
- l'affiche de la série (image),
- le nombre de saisons
- la catégorie de la série.

Elle doit également posséder un formulaire de modification de la série (comportant tous les champs), et un bouton de suppression permettant de supprimer cette série.

Une série peut ne pas avoir de catégorie.
Lorsqu'une série est supprimée, il faut également supprimer son affiche du serveur.

### Fiche Catégorie
Cette page doit afficher :

- le nom de la catégorie.

Elle doit également posséder un formulaire de modification de la catégorie, et un bouton de suppression permettant de supprimer cette catégorie.

Lorsqu'une catégorie est supprimée, si elle possède des séries, il faut les conserver.
Ces séries seront alors sans catégories, mais toujours visibles sur le site.

### Toutes les pages
Toutes les pages doivent posséder un menu qui permet d'accéder rapidement :

- à la page d'accueil,
- à la page Series