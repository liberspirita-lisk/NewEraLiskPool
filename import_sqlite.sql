VACUUM;
CREATE TABLE IF NOT EXISTS voters(
	     delegate TEXT,
	     username TEXT,
	     address TEXT UNIQUE ,
	     publickey TEXT UNIQUE,
	     scoring INTEGER,
	     pending_payouts REAL DEFAULT 0.0);

CREATE TABLE IF NOT EXISTS delegates(
	     username TEXT,
	     address TEXT,
	     publickey TEXT,
	     balance INTEGER,
	     rank INTEGER,
	     UNIQUE (address,publickey)    
	    );

CREATE TABLE IF NOT EXISTS config(
	delegate TEXT, 
	address TEXT,
	publickey TEXT,
	rank INTEGER,
	address_revenues TEXT,
	path_pool TEXT,
	path_psql TEXT,
	psql_db TEXT,
	db_sqlite TEXT,
	tx_redistribution INTEGER,
	min_balance INTEGER
	);

CREATE TABLE IF NOT EXISTS heroes(
	delegate TEXT, 
	address TEXT,
	publickey TEXT,
	rank INTEGER
	);

CREATE TABLE IF NOT EXISTS zeroes(
	delegate TEXT, 
	address TEXT,
	publickey TEXT,
	rank INTEGER
	);

DELETE FROM delegates ;
.mode csv
.separator ,
.import delegates.csv delegates

INSERT or IGNORE INTO voters( delegate, username, address,publickey,scoring)
	SELECT delegate, username,address,publickey,power FROM voters_raw ;

DELETE FROM voters where  address not in (select address from voters_raw);

/*UPDATE voters SET scoring = (SELECT total(voters_raw.power) from voters_raw WHERE voters_raw.address=voters.address GROUP BY voters_raw.address) ;*/

/*update voters set pending_payouts = pending_payouts+ ((scoring / (select total(scoring) from voters)) * ((select total(balance) from delegates where address='3897910504949673529L')-(select total(pending_payouts) from voters ))); */


