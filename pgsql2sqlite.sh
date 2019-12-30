#!/bin/sh

# ***** Modifier les paramètres ci-dessous *****
path_pool='/home/lisk/pool/' # Chemin absolu vers la pool
path_psql='/home/lisk/lisk-main/pgsql/bin/' # Chemin absolu executables postgresql de lisk
pubkey1='de918e28b554600a81cbf119abf5414648b58a8efafbc3b0481df0242684dc1b' # Clef publique du delegate pool
min_balance='10000000000' # Solde minimum des votants à comptabiliser
# ***** ne rien modifier ensuite, sauf si vous savez ce que vous faites *****

# Extraction des votants 
$path_psql"psql" -d lisk_main -t -A -F"," -c "select t2.\"username\",t2.\"address\",t2.\"publicKey\", t2.\"balance\" power 
from mem_accounts2delegates t1 
join mem_accounts t2 on t2.\"address\" = t1.\"accountId\" 
where t1.\"dependentId\"='$pubkey1'
and  t2.\"balance\" > $min_balance 
order by t2.\"balance\" desc" > $path_pool"voters.csv"

# Extraction des données delegate
$path_psql"psql" -d lisk_main -t -A -F"," -c "
select \"username\",\"address\",\"publicKey\",\"balance\",\"rank\" from \"mem_accounts\" where \"publicKey\" = '\xde918e28b554600a81cbf119abf5414648b58a8efafbc3b0481df0242684dc1b'
	" > $path_pool"delegates.csv"
# Reprise de respiration
sleep 1
sync
sync
cd $path_pool
# import dans SQLITE3 base pool.db3
# et pleins de traitements
sqlite3 $path_pool"pool.db3" < $path_pool"import_sqlite.sql"

#Nettoyage fichiers interface
rm $path_pool"delegates.csv"
rm $path_pool"voters.csv"
