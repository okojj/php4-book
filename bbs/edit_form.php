<?php
/*
	게시판 (글수정 폼)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB를 지정하셔야 합니다.",'back');
		exit;
	}
	/* 글번호 지정 여부 */
	if (!$idx || !$rn)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
	/* Table 이름 지정 */
	$table_name="bbs_" . $db;
	/* return url 설정 */
	$from_string="pn=$pn";
	if ($from == 'search')
	{
		$from_string.="&k=$k&w=$w";
	}
	$back_url="$URL[read]?db=$db&idx=$idx&rn=$rn&from=$from&" 
	         . $from_string;
	
	/* 데이타 가져오기 */
	$dbh=dbconnect();
	$query="select * from $table_name where idx=$idx and replynum=$rn";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	$data=dbselect($sth);
	for ($i=0; $i<13; $i++)
	{
		$data[$i]=ereg_replace("\"","'",$data[$i]);
	}
	list($idx,$replynum,$name,$email,$url,$hit,$date,$passwd,$ip,
	$type,$filename,$subject,$note)=$data;

	/* 존재하지 않을때 */
	if (!$idx)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
	}
	elseif (!$passwd)
	{
		print_alert("비밀번호가 입력되지 않은 글은 수정할수 없습니다.   ",'back');
	}
	
	$varname="type" . $type;
	$$varname="checked";
	
	if ($filename)
	{
		$current_file="<br><font size=2>현재첨부파일:<font color=BLUE>$filename</font></font>";
	}
	else
	{
		$current_file="<br><font size=2 color=RED>첨부파일이 없습니다.</font>";
	}

	require($header);
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
	if(form.passwd.value==""){
		msg+="- 비밀번호를 입력하세요.\n";
  	}
  	
  	if (msg)
  	{
  		alert("* 아래 사항을 확인하시기 바랍니다.         \n\n" + msg);
  		return false;
  	}
	return confirm('위의 내용대로 수정하시겠습니까 ?   ');
}
//-->
</script>

<form enctype='multipart/form-data' action="<?echo $URL[edit]?>" method="POST" name="f" onSubmit="return checkForm(document.f);">
<input type=hidden name="db" value="<?echo $db?>">
<input type=hidden name="m" value="edit">
<input type=hidden name="idx" value="<?echo $idx?>">
<input type=hidden name="rn" value="<?echo $rn?>">
<input type=hidden name="return_url" value="<?echo $back_url?>">

    <table border="0" width=600 align=center cellspacing="2" cellpadding="2">
      <tr> 
        <td width="120" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>이름</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="name" value="<?echo $name?>" size=40 maxlength=30></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>E-mail</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="email" value="<?echo $email?>" size=40 maxlength=50></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>홈페이지</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="url" value="<?echo $url?>"size=40 maxlength=100></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>제목</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="subject" value="<?echo $subject?>" value="<?echo $subject?>"size=40 maxlength=50></td>
      </tr>
      <tr> 
        <th bgcolor=#BBDDFF align="center"><font size="2" color=black>내용 <font color="red">*</font></th>
        <td bgcolor=#f0f0f0> 
          <textarea name="note" rows="15" cols="62" wrap=soft><?echo $note?></textarea>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>파일첨부</strong></font></td>
        <td bgcolor=#f0f0f0><input type=file name="userfile" size=30>
        <?echo $current_file?></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>문서형태</strong></font></td>
        <td bgcolor=#f0f0f0><font size=2><input type=radio name="type" value="1" <?echo $type1?> >TEXT &nbsp;&nbsp;
        <input type=radio name="type" value="2" <?echo $type2?> >HTML</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>비밀번호</strong><font color="red">*</font></font></td>
        <td bgcolor=#f0f0f0><input type=password name="passwd" size=10 maxlength=10>
        <font size=2>글 작성시 입력했던 비밀번호를 입력하세요.</font></td>
      </tr>
      <tr>
        <td align=center colspan=2>
        <input type="submit" value="          수    정          ">&nbsp; 
        <input type="reset" value="취  소" name="reset">
        </td>
      </tr>
    </table>
</form>

<?php

	require($footer);
	exit;
?>
