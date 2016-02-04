<?php
/*
  방명록 (방명록 폼)
  2001.06 by Jungjoon Oh
*/
require("gb-lib.php");

	print_header();
?>

<center>
<form method=POST action="gb_write.php">
<input type=hidden name=m value="write">

<table border=0 width=500 cellspacing=3 cellpadding=0>
<tr><td align=center colspan=2><font size=6>방명록 쓰기</font>
    </td>
</tr>
<tr><td colspan=2><font size=2><br>
    <font color=RED>*</font> 표시는 필수 입력 사항입니다.</font>
    </td>
</tr>
<tr><td bgcolor=#B3D9FF width=100 align=right><font size=2>
    <font color=RED>*</font> <b>이름</b> &nbsp;</font></td>
    <td><input type=text name="gb_name" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>E-Mail</b> &nbsp;</font></td>
    <td><input type=text name="gb_email" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>사는곳</b> &nbsp;</font></td>
    <td><input type=text name="gb_location" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>홈페이지</b> &nbsp;</font></td>
    <td><input type=text name="gb_url" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <font color=RED>*</font> <b>한마디 하세요</b>&nbsp;</font></td>
    <td><font size=2 color=red>&nbsp;HTML Tag는 사용할 수 없습니다.</font><br>
	<textarea name="gb_note" COLS=50 ROWS=10 wrap=hard></textarea></td>
</tr>
<tr><td colspan=2 align=center>
    <input type=submit value="            완료            ">
    <input type=reset value=" 다시 "></td>
</tr>
</table>
<br><br>
</form>
</center>


<?php
	print_footer();
?>
