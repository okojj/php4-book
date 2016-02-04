<?php
/*
  방명록 (관리자 모드)
  2001.06 by Jungjoon Oh
*/
require("gb-lib.php");

	if( is_admin($PHP_AUTH_USER,$PHP_AUTH_PW) )
	{
		print_alert("관리자 모드로 전환되었습니다.   ","url|$URL[list]");
	}
	else
	{
		header("WWW-Authenticate: Basic realm=\"방명록 관리자 화면\"");
		header("HTTP/1.0 401 Unauthorized");
		print_alert("관리자 접속이 취소되었습니다.   ",'back');
		exit;
	}
?>
