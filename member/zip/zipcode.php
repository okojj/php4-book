<?php
/*
	ȸ������ (�����ȣ�˻�)
	2001.06 by Jungjoon Oh
*/
$zipfile="zipcode.db";


	if ($query)
	{
		search($query,$zipfile);
	}
	else
	{
		search_form();
	}


function search($query,$zipfile)
{
	echo "
<html>
<head>
<SCRIPT language=\"JavaScript\">
function Copy(zip1,zip2,address)
{
	// copy
	opener.document.$GLOBALS[form].$GLOBALS[zip1].value = zip1;
	opener.document.$GLOBALS[form].$GLOBALS[zip2].value = zip2;
	opener.document.$GLOBALS[form].$GLOBALS[address].value = address;

	// focus
	opener.document.$GLOBALS[form].$GLOBALS[address].focus();

	// close this window
	this.close();

}
</SCRIPT>
<TITLE>�����ȣ�˻�</TITLE>
</head>
<body bgcolor=white text=#000000>
<font size=2>
<center>
<table cellspacing=2 cellpadding=1 width=100%>
<tr align=center BGCOLOR=#6090de><td><font size=2 color=WHITE><b>�����ȣ</b></font></td><td><font size=2 color=WHITE><b>�� ��</b></font></td><td><font size=2 color=WHITE><b>Ȯ��</b></font></td></tr>
";

	$query=ereg_replace("-","",$query);
		
	/* DB ���� ���� */
	$fp=fopen($zipfile,"r");
	
	while ( $line=fgets($fp,1024) )
	{
		if ( preg_match("/$query/",$line) )
		{
			$line=chop($line);
			list($zipcode,$address)=split("\|",$line);
			$zip1=substr($zipcode,0,3);
			$zip2=substr($zipcode,3,3);
			echo "<tr BGCOLOR=#C3E5FF><form><td align=center><font size=2 face=verdana>$zip1-$zip2</font></td>\n";
			echo "<td><font size=2>$address</font></td><td align=center><input type=\"button\" value=\"����\" onClick=\"Copy('$zip1','$zip2','$address')\"></td></form></tr>\n";
		}
	}
	fclose($fp);

	echo "
</table>
</font>

<hr size=1><center>
<font size=2 color=red><b>�˻��� �Ϸ�Ǿ����ϴ�.</b></font></center>
<hr size=1>
<FORM action=zipcode.php method=post name=zipcode>
<input type=hidden name=mode value=search>

<input type=hidden name=form value=$form>
<input type=hidden name=zip1 value=$zip1>
<input type=hidden name=zip2 value=$zip2>
<input type=hidden name=address value=$address>

<font size=2 color=#404040>* �����ȣ�� ��/��/�� �̸��� �Է��ϼ���.<br>
�˻���: <input type=text name=query size=15>
<input type=submit value=\"�˻�\">
</FORM>
</body>
</html>

";

}


##########################################################################
function search_form()
{

	echo "
<html>
<head>
<SCRIPT language=\"JavaScript\">
</SCRIPT>
<TITLE>�����ȣ�˻�</TITLE>
</head>
<body bgcolor=white text=#000000 onLoad=document.zipcode.query.focus()>
<center>
<TABLE Width=400 CelLSpacing=0 CellPadding=6 Border=1 BorderColor=Black>
<TR>
   <TD BGCOLOR=#6090de align=center><Font Size=2 Color=white>
<b>�����ȣ/�ּ� �˻�</b>
   </TD>
</TR>

<TR>
   <TD align=center> <Font Size=2>
   <BR><CENTER>
<FONT SIZE=2>ã���� �ϴ� �ּ��� ��/��/�� �̸� �Ǵ� �����ȣ�� �Է��ϼ���.<br>(��:�б�����/�ܾ���/�����/143-200/421200)</FONT>
<hr size=1>
<FORM action=\"zipcode.php\" method=post name=zipcode>
<input type=hidden name=mode value=search>

<input type=hidden name=form value=$GLOBALS[form]>
<input type=hidden name=zip1 value=$GLOBALS[zip1]>
<input type=hidden name=zip2 value=$GLOBALS[zip2]>
<input type=hidden name=address value=$GLOBALS[address]>

<font size=2 color=#404040>
�˻���: <input type=text name=query size=15>
<input type=submit value=\"�˻�\">
</FORM>
      </TD>
   </TR>
   </TABLE>
</center>
</body>
</html>
";

}
