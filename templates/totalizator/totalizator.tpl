<font style="font-size:14px; font-weight:bold">{title}</font><br/>
{desc}
<br />
<br />
[matches]
<table width="100%" cellpadding="0" cellpadding="0" >
	<tr>
    	<td><b>���� ����������</b></td>
        [tournament]<td><b>������</b></td>[/tournament]
        <td><b>������� �������� ����</b></td>
        <td><b>����</b></td>
        <td><b>������� �������� � ������</b></td>
        [rate]<td><b>������</b></td>[/rate]
        [procent]<td><b>������� ������������</b></td>[/procent]
    </tr>
    [mat_row]
    <tr>
    	<td>{date}</td>
        [tournament]<td>{tournament}</td>[/tournament]
        <td>{komanda1}</td>
        <td>{points}</td>
        <td>{komanda2}</td>
        [rate]<td>{rates}</td>[/rate]
        [procent]<td>{procent}</td>[/procent]
    </tr>
    [/mat_row]
</table>
[save]<input type="submit" value="���������" />[/save]

[edit]<input type="submit" value="�������������" name="edit" />[/edit]

[/matches]
[rates]
[user_page]
<div>
<a href='{matche_link}' />�� ������</a>&nbsp;|&nbsp;<a href="{tor_link}">�� ��������</a>
</div>
[/user_page]
<table width="100%" cellpadding="0" cellspacing="0" >
<tr>
	[user]<td><b>������������</b></td>[/user]
    [rate]<td><b>����[user_page]/������[/user_page]</b></td>[/rate]
    <td><b>����</b></td>
</tr>
[rates_row]
<tr>
	[user]<td>{i} {user}</td>[/user]
    [rate]<td>{point}</td>[/rate]
    <td>{points}</td>
</tr>
[/rates_row]
</table>
[/rates]