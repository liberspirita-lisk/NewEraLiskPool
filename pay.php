<?php
require_once('./lisk-php/main.php');
$fee=10000000;
$db = new SQLite3('db_pool');
$conf = $db->query('SELECT * from config where rank>0 limit 1; ');
$conf_row= $conf->fetcharray();
$res = $db->query("SELECT address, cast(pending_payouts as int) pending_payouts from voters where pending_payouts>". $conf_row['payout_seuil']." ; ");
$okpay = $db->query("SELECT dispo from config limit 1 ; ");
$okpay_row = $okpay->fetcharray();
echo $okpay_row['dispo']*100000000 ;
if ($conf_row['rank']<=101 && $okpay_row['dispo']>=0) {
while ($row = $res->fetchArray())  	{
	$payout=$row['pending_payouts']-$fee;
	$withdraw=CreateTransaction("{$row['address']}","$payout","{$conf_row['secret1']}",false,false,-10);
	$send=SendTransaction(json_encode($withdraw),$server);
	echo var_dump($send)."\r\n";
	$db->query("UPDATE voters set pending_payouts=pending_payouts-'".$row['pending_payouts']."' WHERE address ='".$row['address']."'; ");
	echo      ("Paying ".($row['pending_payouts']/100000000)." to ".$row['address']." \n");
	$db->query("UPDATE config set current_balance=current_balance-'".$row['pending_payouts']."'; ");

}} else {
echo "No payout till not forging, current rank = ".$conf_row['rank']."\n";
	}
echo "******************************************************";
$db->close();
?>

