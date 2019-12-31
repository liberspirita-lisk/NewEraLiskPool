VACUUM;
CREATE TABLE IF NOT EXISTS voters(
	     delegate TEXT,
	     username TEXT,
	     address TEXT UNIQUE ,
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
	
DELETE FROM delegates ;
.mode csv
.separator ,
.import delegates.csv delegates

INSERT or IGNORE INTO voters( delegate, username, address,publickey,power)
	SELECT delegate, username,address,publickey,power FROM voters_raw ;

DELETE FROM voters where  address not in (select address from voters_raw);

update voters set pending_payouts = pending_payouts+ ((power / (select total(power) from voters)) * ((select total(balance) from delegates where address='2004134067472288525L')-(select total(pending_payouts) from voters )));

UPDATE voters SET power = (SELECT total(voters_raw.power) from voters_raw WHERE voters_raw.address=voters.address GROUP BY voters_raw.address) ;

/*DELETE FROM voters_raw ;*/
/*UPDATE voters_raw SET delegate= (select username FROM delegates WHERE voters_raw.delegate=delegates.publickey);*/
