<<<<<<< HEAD
Nouveau pool dédié à la blockchain Lisk
Some bash, some SQL, some Python. Very few lines !
=======

# Pré-requis et installation
développé et testé sur Linux Debian 9,
Installer un node lisk,
Avec le même utilisateur que celui qui fait fonctionner le node Lisk, copier les fichiers lisk-basic-pool dans un répertoire indépendant de votre installation lisk
Modifier les paramètres, dans le fichier pgsql2sqlite.sh
Lancer manuellement 'sh pgsql2sqlite.sh' 
Inscrivez ce script en crontab.. 

# Fonctionnement
Des données sont extraites de la base Postgresql utilisée par Lisk,
puis insérées et remodelées sur une base SQLite
Le solde du compte pool est évalué, comparé aux paiements en attente de chaque pooler. Puis le reliquat du solde est réparti sur chaque pooler.

Donc, dans la table 'voters', la colonne 'pending_payouts' est à jour après chaque lancement de pgsql2sqlite.sh. A partir de ça, il reste à automatiser et paramétrer un paiment régulier, puis à forker ou concevoir une interface de monitoring utilisateurs.
