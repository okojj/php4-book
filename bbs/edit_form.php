<?php
/*
	�Խ��� (�ۼ��� ��)
	2001.06 by Jungjoon Oh
*/
require("db-lib.php");
require("bbs-lib.php");

	if (!$db)
	{
		print_alert("DB�� �����ϼž� �մϴ�.",'back');
		exit;
	}
	/* �۹�ȣ ���� ���� */
	if (!$idx || !$rn)
	{
		header("Location: $URL[list]\n\n");
		exit;
	}
	/* Table �̸� ���� */
	$table_name="bbs_" . $db;
	/* return url ���� */
	$from_string="pn=$pn";
	if ($from == 'search')
	{
		$from_string.="&k=$k&w=$w";
	}
	$back_url="$URL[read]?db=$db&idx=$idx&rn=$rn&from=$from&" 
	         . $from_string;
	
	/* ����Ÿ �������� */
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

	/* �������� ������ */
	if (!$idx)
	{
		print_alert("�����Ͱ� �������� �ʽ��ϴ�.",'stop');
	}
	elseif (!$passwd)
	{
		print_alert("��й�ȣ�� �Էµ��� ���� ���� �����Ҽ� �����ϴ�.   ",'back');
	}
	
	$varname="type" . $type;
	$$varname="checked";
	
	if ($filename)
	{
		$current_file="<br><font size=2>����÷������:<font color=BLUE>$filename</font></font>";
	}
	else
	{
		$current_file="<br><font size=2 color=RED>÷�������� �����ϴ�.</font>";
	}

	require($header);
?>

<script language="JavaScript">
<!--
function checkForm(form)
{
	var msg="";
	if(form.name.value==""){
		msg+="- �̸��� �Է��ϼ���.\n";
	}
	if(form.subject.value==""){
		msg+="- ������ �Է��ϼ���.\n";
	}
	if(form.note.value==""){
		msg+="- ������ �Է��ϼ���.\n";
  	}
	if(form.passwd.value==""){
		msg+="- ��й�ȣ�� �Է��ϼ���.\n";
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

<form enctype='multipart/form-data' action="<?echo $URL[edit]?>" method="POST" name="f" onSubmit="return checkForm(document.f);">
<input type=hidden name="db" value="<?echo $db?>">
<input type=hidden name="m" value="edit">
<input type=hidden name="idx" value="<?echo $idx?>">
<input type=hidden name="rn" value="<?echo $rn?>">
<input type=hidden name="return_url" value="<?echo $back_url?>">

    <table border="0" width=600 align=center cellspacing="2" cellpadding="2">
      <tr> 
        <td width="120" align="center" bgcolor=#BBDDFF><font size="2" color=black><strong>�̸�</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="name" value="<?echo $name?>" size=40 maxlength=30></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>E-mail</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="email" value="<?echo $email?>" size=40 maxlength=50></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>Ȩ������</strong></font></td>
        <td bgcolor=#f0f0f0><input type=text name="url" value="<?echo $url?>"size=40 maxlength=100></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>����</strong></font> <font color="red">*</font></td>
        <td bgcolor=#f0f0f0><input type=text name="subject" value="<?echo $subject?>" value="<?echo $subject?>"size=40 maxlength=50></td>
      </tr>
      <tr> 
        <th bgcolor=#BBDDFF align="center"><font size="2" color=black>���� <font color="red">*</font></th>
        <td bgcolor=#f0f0f0> 
          <textarea name="note" rows="15" cols="62" wrap=soft><?echo $note?></textarea>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>����÷��</strong></font></td>
        <td bgcolor=#f0f0f0><input type=file name="userfile" size=30>
        <?echo $current_file?></td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>��������</strong></font></td>
        <td bgcolor=#f0f0f0><font size=2><input type=radio name="type" value="1" <?echo $type1?> >TEXT &nbsp;&nbsp;
        <input type=radio name="type" value="2" <?echo $type2?> >HTML</font>
        </td>
      </tr>
      <tr> 
        <td bgcolor=#BBDDFF align="center"><font size="2" color=black><strong>��й�ȣ</strong><font color="red">*</font></font></td>
        <td bgcolor=#f0f0f0><input type=password name="passwd" size=10 maxlength=10>
        <font size=2>�� �ۼ��� �Է��ߴ� ��й�ȣ�� �Է��ϼ���.</font></td>
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

	require($footer);
	exit;
?>
