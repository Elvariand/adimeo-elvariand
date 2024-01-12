Bonjour à tous !

Voici une petite explication de ce que j'ai fait:

Les technologies principales que j'ai utilisées sont: Symfony 7, Php 8, Mysql 8, Bootstrap 5 et Docker (avec PhpMyAdmin sur docker pour ma base de données).

Ma première étape a été de créer le CoreController ainsi une page qui affiche la photo du jour de la NASA où la requête se faisait à chaque chargement de ladite page. Ensuite, je me suis occupé de l'IndexController dans lequel j'ai mis 3 routes: l'index qui mène rapidement au login après avoir démarré une session, le login en lui-même via la connexion google qui était demandée, et le logout. Après quoi, je me suis mis à la création de la base de donnée des photos, j'ai eu quelques problèmes de connexion avec la base de données je ne sais pas si c'est lié à ma config Docker ou à une nouvelle nomenclature liée à Symfony 7 mais j'y reviendrai un peu plus tard.

Et c'est là que ça se complique. Une commande exécutée automatiquement à intervales réguliers, j'avoue je n'avais encore jamais fait ça. Je regarde partout, tout le monde ne jure que la Cron et les servers linux, c'est cool j'ai regardé ça à l'air effectivement mais je n'ai pas fait de containers de server linux et en créer un JUSTE pour lancer un script toutes les 24h, je ne suis pas certain que ce soit très optimisé. Alors j'ai cherché avec un script qui tourne tant qu'un booléen est vrai sur ma BDD et qui va chercher les données puis sleep() pendant 24h. Pareil je ne suis pas certain que ce soit très optimisé. Puis après pas mal de recherche je découvre que depuis Stmfony 6.3 il existe un Scheduler qui permet d'éxecuter des scripts à des moments précis ET SURTOUT IL N'EST PAS DANS LA DOC OFFICELLE ! (Mais ils en parlent dans le blog: https://symfony.com/blog/new-in-symfony-6-3-scheduler-component ). Par conséquent, j'ai opté pour l'execution d'un message tous les jours à 8h du matin, heure française le message étant juste le script d'insciption en BDD. Il suffit de démarrer une fois le plannificateur avec la ligne de commande symfony console messenger:consume scheduler_name

et c'est parti. Chose étrange d'ailleurs c'est là que j'ai dû créer une variable d'environnement alternative pour me connecter à la BDD car la variable qui fonctionnait avec le script lancé à la main ne fonctionnait plus lorsque celui-ci était éxecuté par le Scheduler, je n'ai pas réussi à comprendre pourquoi.

Après quoi j'ai rajouté quelques fonctionnalités supplémentaires afin de rendre l'expérience plus agréable (theme sombre, accès à toutes les photos depuis le 1er janvier 2024, logout, loupe).

J'espère que l'expérience vous plaira autant qu'à moi !

Je reste disponible pour en parler de vive voix.

Passez une excellente journée !
