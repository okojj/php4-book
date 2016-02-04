<?php
/*
	�Խ��� (�۸��)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB�� �����ϼž� �մϴ�.",'back');
		exit;
	}
	if (!$m)
	{
		$m='list';
	}

	/* Table �̸� ���� */
	$table_name="bbs_" . $db;

	if (!$pn)
	{
		$pn=1;
	}
	
	/* DB���� */
	$dbh=dbconnect();
	
	$from_string="from=list";

	$start_num=($pn-1) * $max_list;
	$end_num=$pn * $max_list;

	/* ��ü �ۼ� */
	$query="select count(idx) from $table_name";
	$sth=dbquery($dbh,$query);
	list($total_count)=dbselect($sth);

	/* ������ $max_list ��ŭ �̾Ƽ� @LIST_DATA �� ����. */
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
