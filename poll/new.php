<?php
/*
	�������� (�űԵ��)
	2001.06 by Jungjoon Oh
*/

require("db-lib.php");
require("poll-lib.php");

	if (!is_admin($PHP_AUTH_USER,$PHP_AUTH_PW))
	{
		header("Location: $URL[login]?url=$URL[new]");
		exit;
	}
	if ($m == 'register')
	{
	   /* Query ���� */
	   $query="insert into poll_data "
	   ."(question,sdate,status,answer_no,"
	   ."answer1,answer2,answer3,answer4,answer5,"
	   ."answer6,answer7,answer8,answer9,answer10) values "
	   ."('$question',now(),'1',$answer_no,"
	   ."'$answer1','$answer2','$answer3','$answer4','$answer5',"
	   ."'$answer6','$answer7','$answer8','$answer9','$answer10')";

	   $dbh=dbconnect();
	   $sth=dbquery($dbh,$query);
	   if (!$sth)
	   {
		$msg="������ �߻��Ͽ����ϴ�.<br><br>\n" . mysql_error();
		print_message($msg);
	   }
	   else
	   {
		print_alert("����� �Ϸ�Ǿ����ϴ�.   ","url|$URL[list]");
	   }
	}
	else
	{
		new_form();
	}
	exit;

function new_form()
{
	global $URL;
	print_header();
?>

<script language="JavaScript">
<!--
function checkForm(form)
{
	var msg="";
	if(form.question.value==""){
		msg+="- ���� ������ �Է��ϼ���.\n\n";
	}

	for (i=1; i<=form.answer_no.value; i++)
	{
		answer=eval('form.answer'+i+'.value');
		if(answer=="")
		{
			msg+='- ����'+i+'�� �Է��ϼ���.\n\n';
		}
	}
  	if (msg)
  	{
  		alert("* �Ʒ� ������ Ȯ���Ͻñ� �ٶ��ϴ�.         \n\n\n" + msg);
  		return false;
  	}
	return confirm('���� ������ ����Ͻðڽ��ϱ� ?   ');
}
function setDisable(form)
{
	for (i=1; i<=10; i++)
	{
		obj=eval('form.answer'+i);
		if (i > form.answer_no.value)
		{
			obj.disabled=true;
		}
		else
		{
			obj.disabled=false;
		}
	}
}
-->
</script>

<form action="<?echo $URL['new'] ?>" method="POST" name="f" onSubmit="return checkForm(document.f);">
<input type=hidden name='m' value='register'>
<table border=1 bordercolor=white bordercolorlight=silver cellpadding=3 cellspacing=0 width=400>
  <tr><td colspan=2>
	<font size=2>
	<ul>
	<li>���� ������ �Է��Ͻð� ���� ���� �����ϼ���.(�ִ� 10��)</li>
	<li>������ ������ ���� �� ��ŭ �Է��Ͻø� �˴ϴ�.</li>
	</ul>
	</font>
      </td>
  </tr>
  <tr> 
    <td width="100" align="center" bgcolor=#f6f6f6><font size="2" color=black><strong>���� ����</strong></font> <font color="red">*</font></td>
    <td><input type=text name="question" size=40 maxlength=100></td>
  </tr>
  <tr> 
    <td bgcolor=#f6f6f6 align="center"><font size="2" color=black><strong>���׼�</strong></font></td>
    <td><select name='answer_no' onChange="setDisable(document.f)">
      <option value=2>2</option>
      <option value=3>3</option>
      <option value=4>4</option>
      <option value=5>5</option>
      <option value=6>6</option>
      <option value=7>7</option>
      <option value=8>8</option>
      <option value=9>9</option>
      <option value=10>10</option>
      </select>
    </td>
  </tr>
  <tr> 
    <td bgcolor=#f6f6f6 align="center"><font size="2" color=black><strong>����</strong></font></td>
    <td align=right><font size=2>
    1. <input type=text name="answer1" size=36 maxlength=50><br>
    2. <input type=text name="answer2" size=36 maxlength=50><br>
    3. <input type=text name="answer3" size=36 maxlength=50><br>
    4. <input type=text name="answer4" size=36 maxlength=50><br>
    5. <input type=text name="answer5" size=36 maxlength=50><br>
    6. <input type=text name="answer6" size=36 maxlength=50><br>
    7. <input type=text name="answer7" size=36 maxlength=50><br>
    8. <input type=text name="answer8" size=36 maxlength=50><br>
    9. <input type=text name="answer9" size=36 maxlength=50><br>
    10. <input type=text name="answer10" size=36 maxlength=50>
    </font>
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
<script language=JavaScript>
	setDisable(document.f);
</script>

<?php
}
	print_footer();
	exit;
?>
