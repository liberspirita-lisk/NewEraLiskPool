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
$stat_page="<TABLE border=4px cellpadding=15 align=center><TR><TH>Goods</TH><TH>Bads</TH></TR>";
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
$stat_page="<TABLE border=2px cellpadding=3><TR><TH>Address</TH><tH>power</TH><TH>  Scoring  </TH><TH>lisk pending payout</TH></TR>";

while ($voters= $v->fetcharray()) {

$x = $db->query("select distinct power from tempo where address = '".$voters['address']."' and power > 0 limit 1");
$power= $x->fetcharray();
	$stat_page = $stat_page."<TR><TD><a href=\"vote_report.php?a=".$voters['address']."\">".$voters['address']."</a> </TD>
				<TD align=right>".number_format($power['power']/100000000,0)."</TD>
				<TD align=right>".number_format($voters['scoring']/10000000000,0) ."</TD>
				<TD align=right>".number_format($voters['pending_payouts']/100000000,3) ."</TD></TR>";

}
$stat_page = $stat_page."</TABLE>";
echo $stat_page;

}


function vote_report()
{	$db = new SQLite3('../db_pool');
	$address=$_GET['a'];
	echo "<h2>Votes report for address ".$address."<br></h2>";
//$sql = $db->query("SELECT * from voters_raw where address='$address' ; ");
//$votes= $sql->fetcharray();
//		while ($votes= $v-> fetcharray()) {}

$conf = $db->query('SELECT * from config limit 1; ');
$config= $conf->fetcharray();
$h = $db->query('SELECT total(pending_payouts) pending_payouts from voters ');
$stat_page="<TABLE border=4px cellpadding=15 align=center><TR><TH bgcolor=green>Votes on Goods<br>perfect if all green</TH><TH bgcolor=red>Votes on Bads<br>perfect if all white</TH></TR>";
$stat_page = $stat_page."<TR><TD><TABLE>";
$h = $db->query('SELECT substr(publickey,3,100) publickey, address, rank, username from heroes where rank >= 1 order by rank');
while ($heroes= $h->fetcharray()) {
	
		$sql = $db->query("SELECT count(*) from voters_raw where delegate='".$heroes['publickey']."' and address='$address' ; ");
		$count_votes= $sql->fetcharray();
		if ($count_votes[0]>0) {$color='green';} else { $color='white';}
	        $stat_page = $stat_page."<TR><TD bgcolor=$color>#".$heroes['rank']." ".$heroes['username']."</TD></TR>";
		                }
$stat_page = $stat_page."</TABLE>";
$stat_page = $stat_page."<TD><TABLE>";


$z = $db->query('SELECT substr(publickey,3,100) publickey, address, rank, username from zeroes where rank <= 202 order by rank');
while ($zeroes= $z->fetcharray()) {
		$sql = $db->query("SELECT count(*) from voters_raw where delegate='".$zeroes['publickey']."' and address='$address' ; ");
		$count_votes= $sql->fetcharray();
		if ($count_votes[0]>0) {$color='red';} else { $color='white';}
	        $stat_page = $stat_page."<TR><TD bgcolor=$color>#".$zeroes['rank']." ".$zeroes['username']."</TD></TR>";
		                }
$stat_page = $stat_page."</TABLE>";
$stat_page = $stat_page."</TABLE>";
echo $stat_page;

}
?>
