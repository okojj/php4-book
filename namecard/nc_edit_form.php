<?php
/*
	���԰��� (���Լ�����)
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
		
	// ����Ÿ ��������
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

	// �������� ������
	if (!$nc_index)
	{
		print_alert("�����Ͱ� �������� �ʽ��ϴ�.",'stop');
		exit;
	}
	// ����� ����� �ƴҶ� 
	if ($mem_id != $nc_id)
	{
		print_alert("������ ����� ����� �����Ҽ��ֽ��ϴ�.   ",'back');
		exit;
	}
	
	$name="nc_pub" . $nc_pub;
	$$name="checked";

	$name="nc_group" . $nc_group;
	$$name="selected";


	print_header("���Լ���");
	print_location_bar("���Լ���");

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
	return confirm('���� ������ �����Ͻðڽ��ϱ� ?   ');
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
	        <li>��Ȯ�� �Է��ϼ��似��.</li>
	        <li>* ǥ�ô� �ʼ� �Է»��� �Դϴ�.</li>
	        </ul></font>
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>�Ϸù�ȣ</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2><b><?echo $nc_index?></b></td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>�����</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2><b><?echo $nc_id?></b></td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>����</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><font size=2>
        <input type=radio name="nc_pub" value="1" <?echo $nc_pub1?>>��ü ���� &nbsp;
        <input type=radio name="nc_pub" value="2" <?echo $nc_pub2?>>��������(����ڸ� �˻�) &nbsp;
        </td>
      </tr>
      <tr> 
        <td width="150" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>�̸�</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_name" value="<?echo $nc_name?>"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�з�</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0>
          <select name="nc_group">
          <option value="1" <?echo $nc_group1?>>���</option>
          <option value="2" <?echo $nc_group2?>>��л�</option>
          <option value="3" <?echo $nc_group3?>>����</option>
          <option value="4" <?echo $nc_group4?>>�б�</option>
          <option value="5" <?echo $nc_group5?>>����</option>
          <option value="6" <?echo $nc_group6?>>��Ÿ</option>
          </select>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>ȸ���</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_company" value="<?echo $nc_company?>" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>��ȭ</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_tel" value="<?echo $nc_tel?>" size=20 maxlength=20>
        <font size=2>��) 02-3424-4504</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�ѽ�</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_fax" value="<?echo $nc_fax?>" size=20 maxlength=20>
        <font size=2>��) 02-3424-4505</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�̵����</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_hp" value="<?echo $nc_hp?>" size=20 maxlength=20>
        <font size=2>��) 011-345-6789</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�ּ�</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_address" value="<?echo $nc_address?>" size=40></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>Ȩ������</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_url" value="<?echo $nc_url?>" size=40 maxlength=100></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>E-mail</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="nc_email" value="<?echo $nc_email?>" size=40 maxlength=50></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>�μ�</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_depart" value="<?echo $nc_depart?>" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>����</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_title" value="<?echo $nc_title?>" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>���ΰ��ǰ���</strong></font></td>
        <td bgcolor=#f0f0f0><input type="text" name="nc_relation" value="<?echo $nc_relation?>" size="40" maxlength="80"></td>
      </tr>
      <tr> 
        <th bgcolor=#BBDDFF align="center"><font size="2" color=black>��Ÿ����</th>
        <td bgcolor=#f0f0f0> 
          <textarea name="nc_note" rows="7" cols="40" wrap=soft><?echo $nc_note?></textarea>
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
