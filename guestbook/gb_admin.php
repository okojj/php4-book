<?php
/*
  ���� (������ ���)
  2001.06 by Jungjoon Oh
*/
require("gb-lib.php");

	if( is_admin($PHP_AUTH_USER,$PHP_AUTH_PW) )
	{
		print_alert("������ ���� ��ȯ�Ǿ����ϴ�.   ","url|$URL[list]");
	}
	else
	{
		header("WWW-Authenticate: Basic realm=\"���� ������ ȭ��\"");
		header("HTTP/1.0 401 Unauthorized");
		print_alert("������ ������ ��ҵǾ����ϴ�.   ",'back');
		exit;
	}
?>
