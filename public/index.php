<?php
$db = new SQLite3('../db_pool');
$res = $db->query('SELECT address, round((pending_payouts/100000000),2) pending_payouts from voters limit 30; ');
while ($row = $res->fetchArray()) {
    echo "{$row['address']} {$row['pending_payouts']} \n";
}
?>

