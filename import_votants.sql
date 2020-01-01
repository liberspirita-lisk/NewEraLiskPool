VACUUM;
CREATE TABLE IF NOT EXISTS voters_raw(
	     delegate TEXT,
	     username TEXT,
	     address TEXT,
	     publickey TEXT,
	     power INTEGER);
.mode csv
.separator ,

DELETE FROM VOTERS_RAW ;

.import votersheroes.csv voters_raw
.import voterszeroes.csv voters_raw
