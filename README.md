Erobot 
========================

Banque d'images de monnaie avec pages personnelles et publications sous Symfony 3.2 (projet de fin d'année)
========================


1. Récupérer le code

Vous avez deux solutions pour le faire :

Via Git, en clonant ce dépôt

Via le téléchargement du code source en une archive ZIP

2. Définir vos paramètres d'application

Pour ne pas qu'on se partage tous nos mots de passe, vous devez modifier le fichier app/config/parameters.yml

3. Télécharger les vendors

Avec Composer bien évidemment : 

php composer.phar install

4. Créez la base de données

php bin/console doctrine:database:create

php bin/console doctrine:schema:update --dump-sql

php bin/console doctrine:schema:update --force

php bin/console doctrine:fixtures:load

5. Publiez les assets

Publiez les assets dans le répertoire web :

php bin/console assets:install web