<?php
/*
	�Խ��� (�� �˻�)
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
		$m='search';
	}
	/* Table �̸� ���� */
	$table_name="bbs_" . $db;

	if (!$pn)
	{
		$pn=1;
	}
	
	/* DB���� */
	$dbh=dbconnect();
	
	$from_string="from=search";

	$start_num=($pn-1) * $max_list;
	$end_num=$pn * $max_list;
	
	$from_string="from=search&k=$k&w=$w";

        # Ű���� ����
	$keywords = preg_split("/[\s,]+/", $k);
        
	$query2=" from $table_name where (";
	for ($i=0; $keywords[$i]; $i++)
	{
		if ($i != 0)
		{
			$query2.=" or ";
		}
		if ($w == 'both')
		{
			$query2.=" ((subject like '%$keywords[$i]%') or (note like '%$keywords[$i]%')) ";
		}
		else
		{
			$query2.=" ($w like '%$keywords[$i]%') ";
		}
	}
	if ($keywords)
	{
		$query2.=")";
	}

	/* �˻��� �� �� */
	$query="select count(idx) " . $query2;
	$sth=dbquery($dbh,$query);
	list($total_count)=dbselect($sth);

	$query2.=" order by idx desc,replynum limit $start_num,$max_list";

	/* ������ $max_list ��ŭ �̾Ƽ� $LIST_DATA �� ���� */
	$query="select $column" . $query2;
	
	$sth=dbquery($dbh,$query);

	$i=0;
	$LIST_DATA=array();

	while ( $field = dbselect($sth) )
	{
		array_push($LIST_DATA,"$field[0]|$field[1]|$field[2]|$field[3]|$field[4]|$field[5]|$field[6]|$field[7]");
		$i++;
	}
	dbclose($dbh);

	include("show_list.php");
?>
