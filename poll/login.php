<?php
/*
  �������� (������ �α���)
  2001.06 by Jungjoon Oh
*/
require("poll-lib.php");

	if( is_admin($PHP_AUTH_USER,$PHP_AUTH_PW) )
	{
		if ($url)
		{
			$next_url=$url;
		}
		else
		{
			$next_url=$URL['list'];
		}

		print_alert("������ ���� ��ȯ�Ǿ����ϴ�.   ","url|$next_url");
	}
	else
	{
		header("WWW-Authenticate: Basic realm=\"�������� ������ ȭ��\"");
		header("HTTP/1.0 401 Unauthorized");
		print_alert("������ ������ ��ҵǾ����ϴ�.   ",'back');
		exit;
	}
?>
