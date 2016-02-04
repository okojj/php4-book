<?php
/*
	명함관리 (명함등록폼)
	2001.06 by Jungjoon Oh
*/

require("nc-lib.php");

	$mem_id=$REMOTE_USER;

	print_header("명함등록");
	print_location_bar("명함등록");

?>


<script language="JavaScript">
<!--
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
	return confirm('위의 내용대로 등록하시겠습니까 ?   ');
}
//-->
</script>

<form action="nc_write.php" method="POST" name="f" onSubmit="return checkForm(document.f);">
<input type=hidden name="m" value="write">

    <table border="0" width=500 align=center cellspacing="2" cellpadding="2">
      <tr> 
        <td colspan=2><font size=2 color=red><ul>
	 <li>등록하기전에 검색을 해서 이미 등록되어있는지 확인후 등록하세요.</li>
	 <li>* 표시는 필수 입력사항 입니다.</li>
	 </ul></font>
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>등록자 ID</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2><? echo $mem_id ?></font>
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>공유</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2>
        <input type=radio name="nc_pub" value="1" checked>전체 공유 &nbsp;
        <input type=radio name="nc_pub" value="2">공유안함(등록자만 검색) &nbsp;
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>이름</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_name"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>분류</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0>
          <select name="nc_group">
          <option value="1">기업</option>
          <option value="2">언론사</option>
          <option value="3">정계</option>
          <option value="4">학교</option>
          <option value="5">개인</option>
          <option value="6">기타</option>
          </select>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>회사명</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_company" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>전화</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_tel" size=20 maxlength=20>
        <font size=2>예) 02-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>팩스</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_fax" size=20 maxlength=20>
        <font size=2>예) 02-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>이동통신</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_hp" size=20 maxlength=20>
        <font size=2>예) 011-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>주소</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_address" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>홈페이지</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_url" value="http://" size=40 maxlength=100></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>E-mail</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_email" size=40 maxlength=50></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>부서</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_depart" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>직함</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_title" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>본인과의관계</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_relation" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <th bgcolor=#BBDDFF align="center"><font size="2" color=black>기타내용</th>
        <td bgcolor=#f0f0f0> 
          <textarea name="nc_note" rows="7" cols="40" wrap=soft></textarea>
        </td>
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

	print_footer();
	exit;
?>
