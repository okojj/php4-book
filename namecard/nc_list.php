<?php
/*
	���԰��� (���Ը��)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("nc-lib.php");

	$mem_id=$REMOTE_USER;

	if (!isset($pn))
	{
		$pn=1;
	}
	/* CONNECT DB */
	$dbh=dbconnect();
	
	$from_string="from=list&group=$group&id=$id&pn=$pn";

	$start_num=($pn-1) * $max_list;
	$end_num=$pn * $max_list;

	$location_bar="���Ը�� ";

	if ( $id && ($mem_id == $id) )
	{
		$query2=" from namecard where nc_id='$id' ";
	}
	else
	{
		$query2=" from namecard where nc_pub='1' ";
	}
	if ($group)
	{
		$query2.=" and nc_group='$group' ";
		$group_name=$GROUP_NAME[$group];
		$location_bar.=" >> $group_name ";
	}
	if ( $id && ($mem_id == $id) )
	{
		$location_bar.=" (�����:$id) ";
		$location_bar.="</td><td align=right><font size=2><b>"
		."<a href=\"$URL[list]?m=list\">��ü</a></b></font>";
	}

	// ��ü ���Լ� �˻�
	$query="select count(nc_index) " . $query2;
	$sth=dbquery($dbh,$query);
	list($total_count)=dbselect($sth);

	$query2.=" order by nc_index desc limit $start_num,$max_list";

	// ������ $max_list ��ŭ �̾Ƽ� @LIST_DATA �� ����. 
	$query="select $column $query2";
	
	$sth=dbquery($dbh,$query);

	$i=0;
	$LIST_DATA=array();

	while ( $field = dbselect($sth) )
	{
		array_push($LIST_DATA,"$field[0]|$field[1]|$field[2]|$field[3]|$field[4]|$field[5]|$field[6]|$field[7]|$field[8]|$field[9]");
		$i++;
	}
	dbclose($dbh);

	include("nc_show_list.php");
?>
