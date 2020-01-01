VACUUM;
CREATE TABLE IF NOT EXISTS voters(
	     delegate TEXT,
	     username TEXT,
	     address TEXT UNIQUE ,
	     publickey TEXT UNIQUE,
	     scoring INTEGER,
	     pending_payouts INTEGER DEFAULT 0);

CREATE TABLE IF NOT EXISTS heroes(
	     username TEXT,
	     address TEXT,
	     publickey TEXT,
	     balance INTEGER,
	     rank INTEGER,
	     UNIQUE (address,publickey)    
	    );

CREATE TABLE IF NOT EXISTS zeroes(
	     username TEXT,
	     address TEXT,
	     publickey TEXT,
	     balance INTEGER,
	     rank INTEGER,
	     UNIQUE (address,publickey)    
	    );

CREATE TABLE IF NOT EXISTS config(
	delegate TEXT, 
	address TEXT UNIQUE,
	publickey TEXT UNIQUE,
	rank INTEGER,
	address_revenues TEXT,
	path_pool TEXT,
	path_psql TEXT,
	psql_db TEXT,
	db_sqlite TEXT,
	tx_redistribution INTEGER,
	min_balance INTEGER,
	current_balance INTEGER
	);



.mode csv
.separator ,

DELETE FROM heroes;
.import heroes.csv heroes

DELETE FROM zeroes;
.import zeroes.csv zeroes
/*INSERT or IGNORE INTO voters( delegate, username, address,publickey, scoring)
	SELECT delegate, username,address,publickey,power FROM voters_raw ;

DELETE FROM voters where  address not in (select address from voters_raw);*/


