<?php


function tab_headers()
{
	$db = new SQLite3('../db_pool');
	$conf = $db->query('SELECT * from config limit 1 ');
	$config= $conf->fetcharray();
	$pay = $db->query('SELECT total(pending_payouts) pending_payouts from voters ');
	$pending_payouts= $pay->fetcharray();
	if ($config['rank']<102) $forging="YES<BR> sharing ".$config['tx_redistribution']."%";
	else    $forging="NO<BR>funded by ".$config['delegate']."";

	$stat_page =            "<TABLE align=center border=4px cellpadding=15><TR><TH>";
	$stat_page = $stat_page."Network";              $stat_page = $stat_page."</TH><TH>";
	$stat_page = $stat_page."Delegate";             $stat_page = $stat_page."</TH><TH>";
	$stat_page = $stat_page."Rank";                 $stat_page = $stat_page."</TH><TH>";
	$stat_page = $stat_page."Forging";              $stat_page = $stat_page."</TH><TH>";
	$stat_page = $stat_page."Pending payouts";      $stat_page = $stat_page."</TH><TH>";
	$stat_page = $stat_page."Payout threshold";     $stat_page = $stat_page."</TH></TR>";
	$stat_page = $stat_page."<TR><TD>";
	$stat_page = $stat_page.$config['psql_db'];                             $stat_page = $stat_page."</TD><TD>";
	$stat_page = $stat_page.$config['delegate'];                            $stat_page = $stat_page."</TD><TD>";
	$stat_page = $stat_page.$config['rank'];                                $stat_page = $stat_page."</TD><TD>";
	$stat_page = $stat_page.$forging;                                       $stat_page = $stat_page."</TD><TD>";
	$stat_page = $stat_page.$pending_payouts['pending_payouts']/100000000;  $stat_page = $stat_page."</TD><TD>";
	$stat_page = $stat_page.$config['payout_seuil']/100000000;                              $stat_page = $stat_page."</TD><TR>";
	$stat_page = $stat_page."</TABLE";
	echo $stat_page;

}

function heroeszeroes()
{
$db = new SQLite3('../db_pool');
$conf = $db->query('SELECT * from config limit 1; ');
$config= $conf->fetcharray();
$h = $db->query('SELECT total(pending_payouts) pending_payouts from voters ');
$z = $db->query('SELECT total(pending_payouts) pending_payouts from voters ');
$stat_page="<TABLE border=4px cellpadding=15 align=center><TR><TH>Heroes</TH><TH>Zeroes</TH></TR>";
$stat_page = $stat_page."<TR><TD><TABLE>";
$h = $db->query('SELECT * from heroes where rank >= 1 order by rank');
while ($heroes= $h->fetcharray()) {
	        $stat_page = $stat_page."<TR><TD>#".$heroes['rank']." ".$heroes['username']."</TD></TR>";
		                }
$stat_page = $stat_page."</TABLE>";
$stat_page = $stat_page."<TD><TABLE>";
$z = $db->query('SELECT * from zeroes where rank <= 202  order by rank desc');
while ($zeroes= $z->fetcharray()) {
	        $stat_page = $stat_page."<TR><TD>#".$zeroes['rank']." ".$zeroes['username']."</TD></TR>";
		                }
$stat_page = $stat_page."</TABLE>";
$stat_page = $stat_page."</TABLE>";
echo $stat_page;
}

function stats()
{$db = new SQLite3('../db_pool');
$conf = $db->query('SELECT * from config limit 1; ');
$config= $conf->fetcharray();
$v = $db->query("SELECT * from voters where address != '".$config['address_revenues']."'order by scoring desc");
$stat_page="<TABLE border=2px cellpadding=3><TR><TH>Address</TH><TH>  Scoring  </TH><TH>lisk pending payout</TH></TR>";

while ($voters= $v->fetcharray()) {
	$stat_page = $stat_page."<TR><TD>".$voters['address']."</TD><TD align=right>".number_format($voters['scoring']/10000000000,0) ."</TD><TD align=right>".number_format($voters['pending_payouts']/100000000,3) ."</TD></TR>";

}
$stat_page = $stat_page."</TABLE>";
echo $stat_page;

}

?>
