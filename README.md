A new pool for Lisk for a new era of Lisk
Some BASH, some SQL, some PHP. Very few lines !
=======

# Pré-requis et installation
This script has been coded and tested on Debian9, using mainly BASH and SQL. Some PHP also for public site and paiment processor. Installation process should be similar on any debian-like or linux distribution. If you're using MacOs or Windows, just help yourself ;)

##Steps are :

###Install a lisk node
see "https://lisk.io/documentation/lisk-core/setup/binary.html"
We need this node because many direct SQL request in Postgresql database of the node.

###Install various softs as sqlite3, php, nginx 

	apt-get install sqlite3 php nginx

###git clone this repository in the home of lisk user, but not in lisk node directory

	git clone https://github.com/liberspirita-lisk/NewEraLiskPool.git
	cd NewEraLiskPool

####Install lisk-php here, be carefull to install also all its dependencies
see "https://github.com/thepool-io/lisk-php" 

## Set your configuration
###edit the file 'config'
### edit or create a hidden file .sqliterc in your home
with this inside :

	.mode column
	.headers on
### Launch the script 

	'''bash bash_engine'''
When confident, you'd better add a crontab line, like this for every hour each 5:

5 * * * * cd /home/lisk/NewEraLiskPool && /bin/bash /home/lisk/NewEraLiskPool/bash_engine > /home/lisk/NewEraLiskPool/logs.log 2>&1

### Public web site
I used a basic template downloaded from i don't remember where. Feel free to copy/paste the PHP code to any other web templates.
Install any web server with PHP module (nginx, apache2, etc.)
restrict the web site to the directory 'public'
