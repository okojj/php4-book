<?php
/*
	���԰��� (���԰˻�)
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
	
	$from_string="from=search&k=$k&group=$group&id=$id&where=$where&pn=$pn";

	$start_num=($pn-1) * $max_list;
	$end_num=$pn * $max_list;

        # Ű���� ����
	$keywords = preg_split("/[\s,]+/", $k);
        
	$location_bar="���԰˻� "
	."(�˻���:<font color=RED>$k</font>) ";

	$query2=" from namecard where (nc_pub='1' or nc_id='$id') ";
	if ($group)
	{
		$query2.=" and nc_group='$group' ";
		$group_name=$GROUP_NAME[$group];
	}
	if ($keywords)
	{
		$query2.=" and (";
	}
	for ($i=0; $keywords[$i]; $i++)
	{
		if ($i != 0)
		{
			$query2.=" or ";
		}
		$query2.=" (nc_$where like '%$keywords[$i]%') ";
	}
	if ($keywords)
	{
		$query2.=")";
	}


	// ��ü ���Լ� �˻�
	$query="select count(nc_index) " . $query2;
	$sth=dbquery($dbh,$query);
	list($total_count)=dbselect($sth);

	$query2.=" order by nc_index desc limit $start_num,$max_list";

	// ������ $max_list ��ŭ �̾Ƽ� $LIST_DATA �� ����. 
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

