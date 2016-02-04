create table guestbook
(
	gb_index	mediumint unsigned	auto_increment	not null,
	gb_date		datetime,
	gb_ip		varchar(20),
	gb_name		varchar(20),
	gb_email	varchar(50),
	gb_location	varchar(10),
	gb_url		varchar(100),
	gb_note		text,
	primary key(gb_index)
);
