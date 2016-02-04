<?php
/*
  설문조사 (관리자 로그인)
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

		print_alert("관리자 모드로 전환되었습니다.   ","url|$next_url");
	}
	else
	{
		header("WWW-Authenticate: Basic realm=\"설문조사 관리자 화면\"");
		header("HTTP/1.0 401 Unauthorized");
		print_alert("관리자 접속이 취소되었습니다.   ",'back');
		exit;
	}
?>
