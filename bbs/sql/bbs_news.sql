create table bbs_news
(
	idx		int(11)		auto_increment	not null,
	replynum	smallint(5)	unsigned	default 1	not null,
	name		varchar(30),
	email		varchar(50),
	url		varchar(100),
	hit		int(11),
	date		datetime,
	passwd		varchar(10),
	ip		varchar(20),
	type		char(1),
	filename	varchar(100),
	subject		varchar(50),
	note		text,
	primary key(idx,replynum)
);
