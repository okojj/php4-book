create table poll_data2
(
	poll_idx	int(11)		auto_increment	not null,
	question	varchar(100)	not null,
	sdate		date,
	edate		date,
	status		char(1),
	answer_no	tinyint(2)	unsigned	not null,
	answer1		varchar(50),
	answer2		varchar(50),
	answer3		varchar(50),
	answer4		varchar(50),
	answer5		varchar(50),
	answer6		varchar(50),
	answer7		varchar(50),
	answer8		varchar(50),
	answer9		varchar(50),
	answer10	varchar(50),
	primary key(poll_idx)
)
