<?php
/*
=====================================================
 Totalizator v1.0.0
-----------------------------------------------------
 http://kaliostro.net/
-----------------------------------------------------
 Copyright (c) 2007 kaliostro ICQ: 415-74-19
=====================================================
 ������ ��� ������� ���������� �������
=====================================================
*/

if(!defined('DATALIFEENGINE'))
{
  die("Hacking attempt!");
}

$title = "�������� ������";
$hidden_array = array("subaction" => "add");
$button = "��������";
$PHP_SELF .= "?mod=totalizator&action=tournaments";

switch ($subaction)
{
	case "add":
		$alt_name = totranslit(stripslashes($_POST['alt_name']));
		if ($alt_name == "")
			$alt_name = totranslit(stripslashes($_POST['name']));
		if (!$_POST['name'])
			$error[] = "�� �������� ���";
		if (!$error && $total->CreatTournament($_POST['name'], $alt_name, $_POST['description']))
			$tpl->msg("���������� �������", "���������� ������� ������ �������", $PHP_SELF, false);
		else 
			$tor = $_POST;
			
		break;
		
	case "edit":
		$id = intval($id);
		if (!$id)
			$error[] = "�� ������ ������";
		else 
		{
			$hidden_array['subaction'] = "doedit";
			$hidden_array['id'] = $id;
			$button = "���������";
			$title = "�������������� ��������";
			$tor = $total->GetTournament(array('tournament_id'=>$id), 0, 1);
		}
		break;
		
	case "doedit":
		$id = intval($id);
		if (!$id)
			$error[] = "�� ������ ������";
		else 
		{
			$alt_name = totranslit($_POST['alt_name']);
			if ($alt_name == "")
				$alt_name = totranslit($_POST['name']);
			if (!$_POST['name'])
				$error[] = "�� �������� ���";
			if (!$error && $total->UpdateTournament(array("name"=>$_POST['name'], "alt_name"=>$alt_name, "description"=>$_POST['description']), array("tournament_id"=>$id)))
				$tpl->msg("�������������� �������", "��������� �������", $PHP_SELF, false);
			else 
			{
				$tor = $_POST;
				$hidden_array['subaction'] = "doedit";
				$hidden_array['id'] = $id;
				$button = "���������";
				$title = "�������������� ��������";
			}
		}
		break;
		
	case "del":
		if (!$id)
			$error[] = "�� ������ ������";
		else 
		{
			if (empty($_REQUEST['confirm']))
			{
				$tpl->msg_yes_no("Delete", "�������� ������� ������� � �������� ���� ������ � ������ ����� �������. ����������?", array("subaction"=>"del", "confirm" => 1), $PHP_SELF);
			}
			elseif ($total->DeleteTournament(array("tournament_id"=>$id)))
				$tpl->msg("Delete", "�������� ������� ������ �������", $PHP_SELF, false);
			else 
				$error[] = "������ �� ��� ����� ��� ������ �� ����������";
		}
		break;
        
    default:
        $hidden_array['subaction'] = "add";
        break;
}

if (count($error))
{
	$tpl->OpenTable();
	$tpl->OpenSubtable("�������� ������");
	echo "<font color=\"red\" >�������� ��������� ������</font>";
	echo "<ol>";
	foreach ($error as $err)
	{
		echo "<li>$err</li>\n";
	}
	echo "</ol>";
	$tpl->CloseSubtable();
	$tpl->CloseTable();
}

$tpl->OpenTable();
$tpl->OpenSubtable($title);
$tpl->OpenForm('', $hidden_array);
echo "<b>��� �������</b> : ";$tpl->input("name", $tor['name']);echo "&nbsp;&nbsp; <b>�������������� ���</b> : "; $tpl->input("alt_name", $tor['alt_name']);
echo "<br /><br /><b>��������</b> : <br />";
echo "<textarea style=\"width:550px;height:120px;\" name=\"description\" >".$tor['description']."</textarea>";
$tpl->CloseSubtable($button);
$tpl->CloseForm();
$tpl->CloseTable();

if ($tournaments = $total->GetTournament('',0,0,'tournament_id'))
{
	$tpl->OpenTable();
	$tpl->OpenSubtable("�������");
	$tpl->OTable(array("������", "�������������� ���", "��������"));
	foreach ($tournaments as $tournament)
	{
		$id = $tournament['tournament_id'];
		$tpl->row(array($tournament['name'], $tournament['alt_name'], "[<a href=\"$PHP_SELF&subaction=edit&id=$id\">�������������</a>][<a href=\"$PHP_SELF&subaction=del&id=$id\" >�������</a>]"));
	}
	$tpl->CTable();
	$tpl->CloseSubtable();
	$tpl->CloseTable();
}
?>
