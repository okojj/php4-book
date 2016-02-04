<?php
/*
	명함관리 (명함수정폼)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("nc-lib.php");

	$mem_id=$REMOTE_USER;

	$from_string="group=$group&id=$id&pn=$pn";

	if (!$idx)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
	if ($from == 'search')
	{
		$from_string.="&k=$k&where=$where";
	}

	$back_url="$URL[read]?idx=$idx&from=$from&" . $from_string;
		
	// 데이타 가져오기
	$dbh=dbconnect();
	$query="select * from namecard where nc_index=$idx";
	$sth=dbquery($dbh,$query);
	if (!$sth)
	{
		print_alert(mysql_error(),'back');
	}
	
	$data=dbselect($sth);
	for ($i=0; $i<=16; $i++)
	{
		$data[$i]=ereg_replace("\"","'",$data[$i]);
	}
	
	list($nc_index,$nc_group,$nc_id,$nc_date,$nc_name,$nc_company,
	$nc_depart,$nc_title,$nc_tel,$nc_fax,$nc_hp,$nc_email,$nc_url,
	$nc_address,$nc_relation,$nc_note,$nc_pub)=$data;

	// 존재하지 않을때
	if (!$nc_index)
	{
		print_alert("데이터가 존재하지 않습니다.",'stop');
		exit;
	}
	// 등록한 사람이 아닐때 
	if ($mem_id != $nc_id)
	{
		print_alert("명함을 등록한 사람만 수정할수있습니다.   ",'back');
		exit;
	}
	
	$name="nc_pub" . $nc_pub;
	$$name="checked";

	$name="nc_group" . $nc_group;
	$$name="selected";


	print_header("명함수정");
	print_location_bar("명함수정");

?>


<script language="JavaScript">
<!--

function calLength(str)
{
	var strlength=0;
	for (i = 0; i < str.length; i++) {
	    if (str.charCodeAt(i) > 255) strlength += 2;
		else strlength++;
	}
	return strlength;
}

function checkForm(form)
{
	var msg="";
	if(form.nc_name.value==""){
		msg+="- 이름을 입력하세요.\n";
	}
	if(form.nc_company.value==""){
		msg+="- 회사명을 입력하세요.\n";
	}
	if(form.nc_tel.value==""){
		msg+="- 전화번호를 입력하세요.\n";
  	}
  	if (msg)
  	{
  		alert("* 아래 사항을 확인하시기 바랍니다.         \n\n" + msg);
  		return false;
  	}
	return confirm('위의 내용대로 변경하시겠습니까 ?   ');
}
//-->
</script>

<form action="nc_edit.php" method="POST" name="f" onSubmit="return checkForm(document.f);">
<input type=hidden name="idx" value="<?echo $idx?>">
<input type=hidden name="url" value="<?echo $back_url?>">


    <table border="0" width=500 align=center cellspacing="2" cellpadding="2">
      <tr> 
        <td colspan=2><font size=2 color=red>
	        <ul>
	        <li>정확히 입력하세요세요.</li>
	        <li>* 표시는 필수 입력사항 입니다.</li>
	        </ul></font>
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>일련번호</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2><b><?echo $nc_index?></b></td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>등록자</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2><b><?echo $nc_id?></b></td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>공유</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2>
        <input type=radio name="nc_pub" value="1" <?echo $nc_pub1?>>전체 공유 &nbsp;
        <input type=radio name="nc_pub" value="2" <?echo $nc_pub2?>>공유안함(등록자만 검색) &nbsp;
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>이름</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_name" value="<?echo $nc_name?>"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>분류</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0>
          <select name="nc_group">
          <option value="1" <?echo $nc_group1?>>기업</option>
          <option value="2" <?echo $nc_group2?>>언론사</option>
          <option value="3" <?echo $nc_group3?>>정계</option>
          <option value="4" <?echo $nc_group4?>>학교</option>
          <option value="5" <?echo $nc_group5?>>개인</option>
          <option value="6" <?echo $nc_group6?>>기타</option>
          </select>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>회사명</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_company" value="<?echo $nc_company?>" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>전화</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_tel" value="<?echo $nc_tel?>" size=20 maxlength=20>
        <font size=2>예) 02-3424-4504</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>팩스</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_fax" value="<?echo $nc_fax?>" size=20 maxlength=20>
        <font size=2>예) 02-3424-4505</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>이동통신</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_hp" value="<?echo $nc_hp?>" size=20 maxlength=20>
        <font size=2>예) 011-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>주소</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_address" value="<?echo $nc_address?>" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>홈페이지</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_url" value="<?echo $nc_url?>" size=40 maxlength=100></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>E-mail</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_email" value="<?echo $nc_email?>" size=40 maxlength=50></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>부서</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_depart" value="<?echo $nc_depart?>" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>직함</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_title" value="<?echo $nc_title?>" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>본인과의관계</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_relation" value="<?echo $nc_relation?>" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <th bgcolor=#BBDDFF align="center"><font size="2" color=black>기타내용</th>
        <td bgcolor=#f0f0f0> 
          <textarea name="nc_note" rows="7" cols="40" wrap=soft><?echo $nc_note?></textarea>
        </td>
      </tr>
      <tr>
        <td align=center colspan=2>
        <input type="submit" value="          변    경          ">&nbsp; 
        <input type="reset" value="취  소" name="reset">
        </td>
      </tr>
    </table>
</form>

<?php

	print_footer();
	exit;
?>
