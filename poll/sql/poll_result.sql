create table poll_result
(
	result_idx	int(11)		auto_increment	not null,
	poll_idx	int(11)		not null,
	answer		tinyint(2)	not null,
	ip		varchar(15),
	date		datetime,
	primary key(result_idx)
)
