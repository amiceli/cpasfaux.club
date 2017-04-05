# cpasfaux.club

cpasfaux.club est un projet réalisé avec Sandrine Martinez et Florian Fauchier
dans le cadre de notre formation.

Nous n'avons pas eu le temps de faire évoluer le projet du coup 
nous souhaitons le passer en open source.

Le domains cpasfaux.club ou était hébergé le site sera disponible fin avril.

## Installation

Suivre les étapes suivantes une fois que le repo a été cloné.

## Installation des dépendances PHP

* Installer composer (gestionnaire de paquets pour PHP) : [site officiel de composer](https://getcomposer.org/)
* Une fois composer installé, lancer la commande : **composer install**

## Installation de nodeJS et de Grunt

Grunt est un outil de gestion de tâches basé sur NodeJS. Il permet par exemple de concaténer de fichiers, de les minifier etc ..

Dans le projet on l'utilisera pour compiler les fichiers LESS en CSS ([pour en savoir plus sur LESS](http://lesscss.org/))

* Installer nodeJS : [site officiel de NodeJS](http://nodejs.org/)
* Installer la commande Grunt : **npm install -g grunt-cli**
* Installer grunt et ses dépendances, lancer la commande : **npm install**

## Installation de bower (gestionnaire de packages pour JavaScript)

* lancer la commande : **npm install -g bower**
* Installer les librairies **bower install**
* Pour en savoir plus sur bower : [site officiel de bower](http://bower.io/)

## Mettre en place grunt

Une fois que grunt est installé on peut lui demander de surveiller si nos fichiers LESS changent et de les compiler 
automatiquement en fichier CSS. Il suffit de lancer la commande suivante : 

    grunt watch