create table member_data
(
	mem_id		varchar(20)	binary	not null,
	mem_pw		varchar(20)	binary	not null,
	mem_date	datetime,
	mem_name	varchar(20),
	mem_idnum	varchar(14),
	mem_email	varchar(50),
	mem_url		varchar(100),
	mem_tel		varchar(20),
	mem_hp	varchar(20),
	mem_addr1	varchar(50),
	mem_addr2	varchar(50),
	mem_zip		varchar(10),
	primary key(mem_id)
);
