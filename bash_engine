#!/bin/bash

source config
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
sync;sync

# import dans SQLITE3 base pool.db3
# et pleins de traitements
/usr/bin/sqlite3 $path_pool"pool.db3" < $path_pool"import_sqlite.sql"

#Nettoyage fichiers interface
rm $path_pool"delegates.csv"
rm $path_pool"voters.csv"
