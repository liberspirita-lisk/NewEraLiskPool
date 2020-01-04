<!DOCTYPE HTML>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>New Era liberspirita lisk pool</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="header">
		<div>
			<ul id="navigation">
				<li class="active">
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="stats.php">Figures</a>
				</li>
			</ul>
		</div>
	</div>
        <div id="header">
                <div class="clearfix">
                        <img src="images/logo.png" alt="Img" height="100" width="230">
                </div>
        </div>

	<div id="features" align=center>
		<div >
			<h1>Summarize</h1>
		<div>
</html> <?php
$db = new SQLite3('../db_pool');
$conf = $db->query('SELECT * from config limit 1; ');
$config= $conf->fetcharray();
$pay = $db->query('SELECT total(pending_payouts) pending_payouts from voters ');
$pending_payouts= $pay->fetcharray();
if ($config['rank']<102) $forging="YES<BR> sharing ".$config['tx_redistribution']."%"; 
else	$forging="NO<BR>funded by ".$config['delegate'].""; 
				
$stat_page =		"<TABLE align=center border=4px cellpadding=15><TR><TH>";
$stat_page = $stat_page."Network"; 		$stat_page = $stat_page."</TH><TH>";
$stat_page = $stat_page."Delegate"; 		$stat_page = $stat_page."</TH><TH>";
$stat_page = $stat_page."Rank";			$stat_page = $stat_page."</TH><TH>";
$stat_page = $stat_page."Forging";		$stat_page = $stat_page."</TH><TH>";
$stat_page = $stat_page."Pending payouts";	$stat_page = $stat_page."</TH><TH>";
$stat_page = $stat_page."Payout threshold";	$stat_page = $stat_page."</TH></TR>";
$stat_page = $stat_page."<TR><TD>";
$stat_page = $stat_page.$config['psql_db']; 				$stat_page = $stat_page."</TD><TD>";
$stat_page = $stat_page.$config['delegate']; 				$stat_page = $stat_page."</TD><TD>";
$stat_page = $stat_page.$config['rank']; 				$stat_page = $stat_page."</TD><TD>";
$stat_page = $stat_page.$forging; 					$stat_page = $stat_page."</TD><TD>";
$stat_page = $stat_page.$pending_payouts['pending_payouts']/100000000;	$stat_page = $stat_page."</TD><TD>";
$stat_page = $stat_page.$config['payout_seuil']/100000000; 				$stat_page = $stat_page."</TD><TR>";
$stat_page = $stat_page."</TABLE";
echo $stat_page;
?> <html>
		<div><br><br>
			<h1>List of Heroes Zeroes</h1>
</html> <?php
$db = new SQLite3('../db_pool');
$conf = $db->query('SELECT * from config limit 1; ');
$config= $conf->fetcharray();
$h = $db->query('SELECT total(pending_payouts) pending_payouts from voters ');
$heroes= $pay->fetcharray();
$z = $db->query('SELECT total(pending_payouts) pending_payouts from voters ');
$zeroes= $pay->fetcharray();
$stat_page="<TABLE border=4px cellpadding=15><TR><TH>Heroes</TH><TH>Zeroes</TH></TR>";
$stat_page = $stat_page."<TR><TD><TABLE>";
$h = $db->query('SELECT * from heroes where rank > 101 order by rank');

while ($heroes= $h->fetcharray()) {
	$stat_page = $stat_page."<TR><TD>".$heroes['username']."</TD></TR>";
		}
$stat_page = $stat_page."</TABLE>";

$stat_page = $stat_page."<TD><TABLE>";
$z = $db->query('SELECT * from zeroes where rank <= 101 order by rank');
while ($zeroes= $z->fetcharray()) {
	$stat_page = $stat_page."<TR><TD>".$zeroes['username']."</TD></TR>";
		}
$stat_page = $stat_page."</TABLE>";


$stat_page = $stat_page."</TABLE>";
echo $stat_page;
?> <html>
		<div><br><br>
			<h1>Pending payouts</h1>
		</div><p><a href="pending_payouts.csv">Download here CSV of pending payouts, as a basic API if you manage a tool for community.</a></p>
</html> <?php
$db = new SQLite3('../db_pool');
$conf = $db->query('SELECT * from config limit 1; ');
$config= $conf->fetcharray();
$v = $db->query("SELECT * from voters where address != '".$config['address_revenues']."'order by pending_payouts desc");
$stat_page="<TABLE border=2px cellpadding=1><TR><TH>Address</TH><TH>lisk pending payout</TH></TR>";

while ($voters= $v->fetcharray()) {
$stat_page = $stat_page."<TR><TD>".$voters['address']."</TD><TD align=right>".number_format($voters['pending_payouts']/100000000,3) ."</TD></TR>";

}
$stat_page = $stat_page."</TABLE>";
echo $stat_page;
?> <html>
			</div>
		</div>
	</div>
</body>
</html>
