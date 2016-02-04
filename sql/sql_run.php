<html>
<head><title>SQL Commander</title>
</head>

<body>
<center>

<?php

// DB ¿ÀÇÂ
$dbh=mysql_connect($host,$id,$pw);
mysql_select_db($db);

$query=stripslashes($query);
$sth=mysql_query($query,$dbh);

if (!$sth)
{
	echo "Error(",mysql_errno(),") - ",mysql_error();
	exit;
}

if ( preg_match("/select */i",$query) || preg_match("/show */i",$query) || 
     preg_match("/desc */i",$query) || preg_match("/describe */i",$query) )
{
	$query_type=1;
	$fieldnum=mysql_num_fields($sth);
	for ($i=0; $i < $fieldnum; $i++)
	{
		$column_list[$i]=mysql_field_name($sth,$i);
	}
}
else
{
	$query_type=2;
}


if ($query_type==1)
{
	echo "<table border=1 cellspacing=0 align=center>\n";
	if ($column_list)
	{
	   echo "<tr><th><font size=2>No.</font></th>\n";
	   foreach ($column_list as $name)
	   {
		echo "  <th><font size=2>$name</font></th>\n";
	   }
	   echo "</tr>\n";
	}
	$count=1;
   
	while ( $fields=mysql_fetch_row($sth) )
	{
	   echo "<tr><td align=center><font size=2>$count</font></td>\n";
	   $colnum=0;
	   foreach ($fields as $data)
	   {
		echo "  <td><span title=\"[$column_list[$colnum]]\n$data\">
		<input type=text value=\"$data\"></span></td>\n";
		$colnum++;
	   }
	   echo "</tr>\n";
	   $count++;
	}
	echo "</table>\n";
	$count--;
	echo "<br>selected $count rows"; 
}
else
{
   	echo "<br>Processed !!<br><br>$query";
}

?>

</center>
</body>
</html>
