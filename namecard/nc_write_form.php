<?php
/*
	���԰��� (���Ե����)
	2001.06 by Jungjoon Oh
*/

require("nc-lib.php");

	$mem_id=$REMOTE_USER;

	print_header("���Ե��");
	print_location_bar("���Ե��");

?>


<script language="JavaScript">
<!--
function checkForm(form)
{
	var msg="";
	if(form.nc_name.value==""){
		msg+="- �̸��� �Է��ϼ���.\n";
	}
	if(form.nc_company.value==""){
		msg+="- ȸ����� �Է��ϼ���.\n";
	}
	if(form.nc_tel.value==""){
		msg+="- ��ȭ��ȣ�� �Է��ϼ���.\n";
  	}
  	if (msg)
  	{
  		alert("* �Ʒ� ������ Ȯ���Ͻñ� �ٶ��ϴ�.         \n\n" + msg);
  		return false;
  	}
	return confirm('���� ������ ����Ͻðڽ��ϱ� ?   ');
}
//-->
</script>

<form action="nc_write.php" method="POST" name="f" onSubmit="return checkForm(document.f);">
<input type=hidden name="m" value="write">

    <table border="0" width=500 align=center cellspacing="2" cellpadding="2">
      <tr> 
        <td colspan=2><font size=2 color=red><ul>
	 <li>����ϱ����� �˻��� �ؼ� �̹� ��ϵǾ��ִ��� Ȯ���� ����ϼ���.</li>
	 <li>* ǥ�ô� �ʼ� �Է»��� �Դϴ�.</li>
	 </ul></font>
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>����� ID</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2><? echo $mem_id ?></font>
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>����</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2>
        <input type=radio name="nc_pub" value="1" checked>��ü ���� &nbsp;
        <input type=radio name="nc_pub" value="2">��������(����ڸ� �˻�) &nbsp;
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>�̸�</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_name"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�з�</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0>
          <select name="nc_group">
          <option value="1">���</option>
          <option value="2">��л�</option>
          <option value="3">����</option>
          <option value="4">�б�</option>
          <option value="5">����</option>
          <option value="6">��Ÿ</option>
          </select>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>ȸ���</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_company" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>��ȭ</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_tel" size=20 maxlength=20>
        <font size=2>��) 02-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�ѽ�</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_fax" size=20 maxlength=20>
        <font size=2>��) 02-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�̵����</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_hp" size=20 maxlength=20>
        <font size=2>��) 011-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�ּ�</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_address" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>Ȩ������</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_url" value="http://" size=40 maxlength=100></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>E-mail</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_email" size=40 maxlength=50></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�μ�</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_depart" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>����</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_title" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>���ΰ��ǰ���</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_relation" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <th bgcolor=#BBDDFF align="center"><font size="2" color=black>��Ÿ����</th>
        <td bgcolor=#f0f0f0> 
          <textarea name="nc_note" rows="7" cols="40" wrap=soft></textarea>
        </td>
      </tr>
      <tr>
        <td align=center colspan=2>
        <input type="submit" value="          ��    ��          ">&nbsp; 
        <input type="reset" value="��  ��" name="reset">
        </td>
      </tr>
    </table>
</form>

<?php

	print_footer();
	exit;
?>
