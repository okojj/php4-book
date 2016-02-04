<?php
/*
	게시판 (글목록)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB를 지정하셔야 합니다.",'back');
		exit;
	}
	if (!$m)
	{
		$m='list';
	}

	/* Table 이름 지정 */
	$table_name="bbs_" . $db;

	if (!$pn)
	{
		$pn=1;
	}
	
	/* DB접속 */
	$dbh=dbconnect();
	
	$from_string="from=list";

	$start_num=($pn-1) * $max_list;
	$end_num=$pn * $max_list;

	/* 전체 글수 */
	$query="select count(idx) from $table_name";
	$sth=dbquery($dbh,$query);
	list($total_count)=dbselect($sth);

	/* 데이터 $max_list 만큼 뽑아서 @LIST_DATA 에 저장. */
	$query="select $column from $table_name order by idx desc,replynum limit $start_num,$max_list";
	
	$sth=dbquery($dbh,$query);

	$i=0;
	$LIST_DATA=array();

	while ( $field = dbselect($sth) )
	{
		array_push($LIST_DATA,"$field[0]|$field[1]|$field[2]|
		$field[3]|$field[4]|$field[5]|$field[6]|$field[7]");
		$i++;
	}
	dbclose($dbh);

	include("show_list.php");
?>
