<?php
/*
  ���� (���� ��)
  2001.06 by Jungjoon Oh
*/
require("gb-lib.php");

	print_header();
?>

<center>
<form method=POST action="gb_write.php">
<input type=hidden name=m value="write">

<table border=0 width=500 cellspacing=3 cellpadding=0>
<tr><td align=center colspan=2><font size=6>���� ����</font>
    </td>
</tr>
<tr><td colspan=2><font size=2><br>
    <font color=RED>*</font> ǥ�ô� �ʼ� �Է� �����Դϴ�.</font>
    </td>
</tr>
<tr><td bgcolor=#B3D9FF width=100 align=right><font size=2>
    <font color=RED>*</font> <b>�̸�</b> &nbsp;</font></td>
    <td><input type=text name="gb_name" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>E-Mail</b> &nbsp;</font></td>
    <td><input type=text name="gb_email" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>��°�</b> &nbsp;</font></td>
    <td><input type=text name="gb_location" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <b>Ȩ������</b> &nbsp;</font></td>
    <td><input type=text name="gb_url" size=30 maxlength=66></td>
</tr>
<tr><td bgcolor=#B3D9FF align=right><font size=2>
    <font color=RED>*</font> <b>�Ѹ��� �ϼ���</b>&nbsp;</font></td>
    <td><font size=2 color=red>&nbsp;HTML Tag�� ����� �� �����ϴ�.</font><br>
	<textarea name="gb_note" COLS=50 ROWS=10 wrap=hard></textarea></td>
</tr>
<tr><td colspan=2 align=center>
    <input type=submit value="            �Ϸ�            ">
    <input type=reset value=" �ٽ� "></td>
</tr>
</table>
<br><br>
</form>
</center>


<?php
	print_footer();
?>
