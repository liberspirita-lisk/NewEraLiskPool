VACUUM;
CREATE TABLE IF NOT EXISTS voters_raw(
	     username TEXT,
	     address TEXT,
	     publickey TEXT,
	     power INTEGER);

CREATE TABLE IF NOT EXISTS voters(
	     username TEXT,
	     address TEXT UNIQUE,
	     publickey TEXT UNIQUE,
	     power INTEGER,
	     pending_payouts REAL DEFAULT 0.0);

CREATE TABLE IF NOT EXISTS delegates(
	     username TEXT,
	     address TEXT,
	     publickey TEXT,
	     balance INTEGER,
	     rank INTEGER,
	     UNIQUE (address,publickey)    
	    );
	
DELETE FROM voters_raw ;
DELETE FROM delegates ;
.mode csv
.separator ,
.import voters.csv voters_raw
.import delegates.csv delegates
INSERT or IGNORE INTO voters(username, address,publickey,power) SELECT username,address,publickey,power FROM voters_raw ;
DELETE FROM voters where address not in (select address from voters_raw);
update voters set pending_payouts = pending_payouts+ ((power / (select total(power) from voters)) * ((select total(balance) from delegates)-(select total(pending_payouts) from voters )));
