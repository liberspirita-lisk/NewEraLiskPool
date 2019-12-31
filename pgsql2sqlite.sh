#!/bin/bash

# ***** Modifier les paramètres ci-dessous *****

path_pool='/home/lisk/pool/' 				# Chemin absolu vers la pool
path_psql='/home/lisk/lisk-main/pgsql/bin/' 		# Chemin absolu executables postgresql de lisk

# les delegates sur lesquels on recherche les votants, on peut en mettre tant qu'on veut, pour sponsorer des potes
declare -a pubkey=('32f20bee855238630b0f791560c02cf93014977b4b25c19ef93cd92220390276' 'de918e28b554600a81cbf119abf5414648b58a8efafbc3b0481df0242684dc1b' '6b221c994ba2a69d8893f59a55431dd3e94327830f8818fc7fbffdbbb55b6fa9')

taulier='7695675674841127110L'			# Adresse du patron de la pool. Ce compte doit voter la pool pour que ça marche
tx_redistribution='60'				#taux de redistribution ex: 60 = 60 aux poolers, 40% au taulier
min_balance='10000000000' 			# Solde minimum des votants à comptabiliser. Pour éviter les morts ou dormants.

# ***** ne rien modifier ensuite, sauf si vous savez ce que vous faites *****
touch $patch_pool"voters.csv"
touch $patch_pool"delegates.csv"
cd $path_pool

# Extraction des votants 
for elem in "${pubkey[@]}" ; do
$path_psql"psql" -d lisk_main -t -A -F"," -c " SELECT t1.\"dependentId\", t2.\"username\",t2.\"address\",t2.\"publicKey\", t2.\"balance\" power 
from mem_accounts2delegates t1 
join mem_accounts t2 on t2.\"address\" = t1.\"accountId\" where t1.\"dependentId\"='$elem' and  t2.\"balance\" > $min_balance 
order by t2.\"balance\" desc" >> $path_pool"voters.csv"
done
/usr/bin/sqlite3 $path_pool"pool.db3" < $path_pool"import_votants.sql"

# Extraction des données delegate
for elem in "${pubkey[@]}" ; do
$path_psql"psql" -d lisk_main -t -A -F"," -c "select \"username\",\"address\",\"publicKey\",\"balance\",\"rank\" from \"mem_accounts\" where \"publicKey\" = '\\x$elem'" >> $path_pool"delegates.csv"
done

# Reprise de respiration
sleep 1
sync
sync
# import dans SQLITE3 base pool.db3
# et pleins de traitements
/usr/bin/sqlite3 $path_pool"pool.db3" < $path_pool"import_sqlite.sql"

#Nettoyage fichiers interface
rm $path_pool"delegates.csv"
rm $path_pool"voters.csv"
