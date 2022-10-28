Guide de déploiement
Site prédemment hébergé sur Heroku, Heroku devenant payant, cle site a migré sur fly.io Déploiement sur heroku. s'identifier sur heroku, cliquer sur new create new app on le nomme onchoisissez le lieu usa ou europe create app Deployment method on le lie a notre projet github ensuite on choisit deployement automatique Ensuite nous allons dans Resources, nous installons l'add on Jaws DB Une fois celui ci installé nous l'ouvrons, nous obtenons nos identifiants (name host mot de passe ) je vais dans setting je paramètre mes variables d'environnement avec les infos données par jaws DB APP_DEBUG 0 APP_ENV prod APP_SECRET vos id DATABASE_URL vos identifiant

j'ouvre ensuite MySQL Worckbench je crée un nouveau serveur, je paramètre le serveur avec les infos données par Jaws DB j'ouvre le logiciel Heidi SQL afin de faire une migration de ma base de données en local sur mon nouveau serveur crée sur MySQL Worckbench

Migration de Heroku vers Fly.io https://fly.io/launch/heroku je m'identifie, je sélectionne le projet et je fais une simple migration et le site est déployé via fly.io

Guide d'utilisation
Espace Admin, connexion avec votre mail et mdp

dans l'espace administration vous pouvez ajouter un nouveau franchiseur ou une nouvelle salle qui sera liée à son franchiseur. en cliquant sur Détails, vous arrivez sur l'onglet Franchise, permettant la gestion des permissions données. Pour toutes désactivations de contrat, veillez à bien supprimer préalablement toutes les autorisations accordées.


Guide de deploiement en local
Si vous voulez prendre mon projet, veuillez effectuer les instructions suivantes
    git clone https://github.com/Thomas94170/gestion-salle-de-sport.git
    composer install
    Changer la variable APP_ENV de prod à dev dans le fichier .env
    composer require symfony/runtime
    yarn install
    symfony console doctrine:migrations:migrate
    symfony serve
    yarn watch
    Enjoy !
