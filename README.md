A new pool for Lisk for a new era of Lisk
Some BASH, some SQL, some PHP. Very few lines !
=======

# Pré-requis et installation
This script has been coded and tested on Debian9, using mainly BASH and SQL. Some PHP also for public site and paiment processor. Installation process should be similar on any debian-like or linux distribution. If you're using MacOs or Windows, just help yourself ;)

## Steps are :

### Install a lisk node
see "https://lisk.io/documentation/lisk-core/setup/binary.html"
We need this node because many direct SQL request in Postgresql database of the node.

### Install various softs as sqlite3, php, nginx 

	apt-get install sqlite3 php nginx

### git clone this repository in the home of lisk user, but not in lisk node directory.

	git clone https://github.com/liberspirita-lisk/NewEraLiskPool.git
	cd NewEraLiskPool

#### Install lisk-php here, be carefull to install also all its dependencies. Many thanks to @ThePool.io for this excellent tool.
see "(https://github.com/thepool-io/lisk-php)" 

## Set your configuration
edit the file 'config'. It should be enought documented to be self explained.

### edit or create a hidden file .sqliterc in your home
with this inside :

	.mode column
	.headers on

### Launch the script 

	bash bash_engine
When confident, you'd better add a crontab line, like this for every hour (just as an example)

*5 * * * * cd /home/lisk/NewEraLiskPool && /bin/bash /home/lisk/NewEraLiskPool/bash_engine > /home/lisk/NewEraLiskPool/logs.log 2>&1*

This example is also feeding a log file you can monitor :
	---------------------------------------------------------------------
	date        time        rank        current_balance  pending_payouts
	----------  ----------  ----------  ---------------  ---------------
	2020-01-06  21:20:03    101         11.0             11.7           
	Paying 1.00052632 to 10431374778810601967L 
	Paying 1.01476307 to 305922413481072012L 
	Paying 1.02714097 to 16387939607525205671L 
	Paying 1.01737876 to 16379340065696424247L 
	---------------------------------------------------------------------
	date        time        rank        current_balance  pending_payouts
	----------  ----------  ----------  ---------------  ---------------
	2020-01-06  21:25:03    101         7.0              7.64           
	---------------------------------------------------------------------



The script is lasting about 40 seconds with more than 20 HeroesZeroes. During this time lap, the public sweb page may be locked also. I could have bypass this, but i did not ;) 

## Cautions !
NewEra is not set to pay *Once every x days* but *once threshold is reached*. 

NewEra does not scan the blocks forged to calcule the pending payouts, but it is paying all the balance available on the account, forged lisk or any lisk transfered on the address. When LIP23 will be launched, a parameter will set how much to leave outside the distribution.

NewEra does not pay any rewards as long as the delegate is not forging. But still it is accumulating pending payouts to voters with lisk sent on it.

### Public web site
I used a basic template downloaded from i don't remember where. Feel free to copy/paste the PHP code to any other web templates.
Install any web server with PHP module (nginx, apache2, etc.)
restrict the web site to the directory 'public'

## Free to use, if ...
If you want to use this script, no restriction at all. **I am only kindly asking to insert user liberspirita in heroes list**.

This script is working well on testnet "http://clovis.liberspirita.net" and on mainnet "http://newera.liberspirita.net".
