<?php
/*
	게시판 (등록폼)
	2001.06 by Jungjoon Oh
*/

require("bbs-lib.php");
require("db-lib.php");

	require($header);
	if (!$db)
	{
		print_alert("DB를 지정하셔야 합니다.",'back');
		exit;
	}
	if ($m == 'reply')
	{
		/* Table 이름 지정 */
		$table_name="bbs_" . $db;
		$query="select name,subject,note from $table_name where idx=$idx and replynum=$rn";
		
		$dbh=dbconnect();
		$sth=dbquery($dbh,$query);
		list($name,$subject,$note)=dbselect($sth);
		dbclose($dbh);
		
		$subject="Re: " . $subject;
		$note="\n\n\n$name 님이 쓴글 : \n" . $note;
	}
	else
	{
		$m='write';
	}
?>

<script language="JavaScript">
<!--
function checkForm(form)
{
	var msg="";
	if(form.name.value==""){
		msg+="- 이름을 입력하세요.\n";
	}
	if(form.subject.value==""){
		msg+="- 제목을 입력하세요.\n";
	}
	if(form.note.value==""){
		msg+="- 내용을 입력하세요.\n";
  	}
  	if (msg)
  	{
  		alert("* 아래 사항을 확인하시기 바랍니다.         \n\n" + msg);
  		return false;
  	}
	return confirm('위의 내용대로 등록하시겠습니까 ?   ');
}
-->
</script>

<form enctype='multipart/form-data' action="<?echo $URL[write]?>" 
  method="POST" name="f" onSubmit="return checkForm(document.f);">
<input type=hidden name="db" value="<?echo $db?>">
<input type=hidden name="m" value="<?echo $m?>">
<input type=hidden name="idx" value="<?echo $idx?>">
<input type=hidden name="reply" value="<?echo $rn?>">

    <table border="0" width=600 align=center cellspacing="2" cellpadding="2">
      <tr> 
        <td width="120" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>이름</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="name" size=40 maxlength=30></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>E-mail</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="email" size=40 maxlength=50></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>홈페이지</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="url" size=40 maxlength=100></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>제목</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="subject" value="<?echo $subject?>"size=40 maxlength=50></td>
      </tr>
      <tr> 
        <th bgcolor=#BBDDFF align="center"><font size="2" color=black>내용 <font color="red">*</font></th>
        <td bgcolor=#f0f0f0> 
          <textarea name="note" rows="15" cols="62" wrap=soft><?echo $note?></textarea>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>파일첨부</strong></font></td>
        <td bgcolor=#f0f0f0><input type=file name="userfile" size=30></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>문서형태</strong></font></td>
        <td bgcolor=#f0f0f0><font size=2><input type=radio name="type" value="1" checked>TEXT &nbsp;&nbsp;
        <input type=radio name="type" name="2">HTML</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>비밀번호</strong></font></td>
        <td bgcolor=#f0f0f0><input type=password name="passwd" size=10 maxlength=10></td>
      </tr>
      <tr>
        <td align=center colspan=2>
        <input type="submit" value="          등    록          ">&nbsp; 
        <input type="reset" value="취  소" name="reset">
        </td>
      </tr>
    </table>
</form>

<?php

	require($footer);
	exit;
?>
