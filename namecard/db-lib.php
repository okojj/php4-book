<?php

$MYSQL['hostname']="localhost";
$MYSQL['database']="test";
$MYSQL['id']="test";
$MYSQL['pw']="testpass";


function dbconnect() 
{
	global $MYSQL;

	return mysql_connect($MYSQL['hostname'],$MYSQL['id'],$MYSQL['pw']);
}

function dbclose($dbh)
{
	return mysql_close($dbh);
}

function dbquery($dbh,$query) 
{
	global $MYSQL;
	mysql_select_db($MYSQL['database']);
	return mysql_query($query,$dbh);
}


function dbselect($sth) 
{
	return mysql_fetch_row($sth);
}


function dbquote($input) 
{
	return str_replace("\'","''",$input);
}

?>
