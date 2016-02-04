drop table member_zip;

create table member_zip
(
	zipcode		varchar(10)	not null,
	address		varchar(50)	not null,
	primary key(zipcode)
);
