<<<<<<< HEAD
Nouveau pool dédié à la blockchain Lisk
Some BASH, some SQL, some PHP. Very few lines !
=======

# Pré-requis et installation
This script has been coded and tested on Debian9. Installation process should be similar on any debian like linux distribution.

##Steps are :

###Install a lisk node
see "https://lisk.io/documentation/lisk-core/setup/binary.html"

###Install various softs as sqlite3, php, nginx 
'''sh
apt-get install sqlite3 php nginx

###git clone this repository in the home of lisk user, but not in lisk node directory
'''sh
git clone https://github.com/liberspirita-lisk/NewEraLiskPool.git
cd NewEraLiskPool

###Install lisk-php here, be carefull to install also all its dependencies
see "https://github.com/thepool-io/lisk-php" 

## Set your configuration
###edit the file 'config'
### edit or create a hidden file .sqliterc in your home
with this inside :
'''sh
.mode column
.headers on
# 
Des données sont extraites de la base Postgresql utilisée par Lisk,
puis insérées et remodelées sur une base SQLite
Le solde du compte pool est évalué, comparé aux paiements en attente de chaque pooler. Puis le reliquat du solde est réparti sur chaque pooler.

Donc, dans la table 'voters', la colonne 'pending_payouts' est à jour après chaque lancement de pgsql2sqlite.sh. A partir de ça, il reste à automatiser et paramétrer un paiment régulier, puis à forker ou concevoir une interface de monitoring utilisateurs.
