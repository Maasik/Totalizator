<?php

if(!defined('DATALIFEENGINE'))
{
  die("Hacking attempt!");
}

$title = "�������� ����";
$hidden_array = array("subaction" => "add");
$button = "��������";
if (!($tournaments_array = $total->GetIdNameTournament()))
	$tpl->msg("�����", "�� ������� �� ������ �������, ����� ������� ���� ����� ������� ������� ������.", $PHP_SELF."?mod=totalizator&action=tournaments");
$points_array['no'] = '';
if (empty($total_conf['game_points']))
{
    $total_conf['game_points'] =  15;
}
for ($i=0; $i<=$total_conf['game_points']; $i++)
{
	$points_array[$i] = $i;
}
$PHP_SELF .= "?mod=totalizator&action=matches";

$date_matche = empty($_REQUEST['date_matche'])?'':$_REQUEST['date_matche'];
$confirm = empty($_REQUEST['confirm'])?'':$_REQUEST['confirm'];
$tournament_id = empty($_REQUEST['tournament_id'])?'':(int)$_REQUEST['tournament_id'];
$komanda1 = empty($_REQUEST['komanda1'])?'':$_REQUEST['komanda1'];
$komanda2 = empty($_REQUEST['komanda2'])?'':$_REQUEST['komanda2'];
$points_1 = empty($_REQUEST['points_1'])?'':$_REQUEST['points_1'];
$points_2 = empty($_REQUEST['points_2'])?'':$_REQUEST['points_2'];

switch ($subaction)
{
	case "add":
		if ($komanda1 == "" || $komanda2 == "")
			$error[] = "���� �������� ������";
		if ($date_matche == "" || ($date = strtotime($date_matche)) === -1)
			$error[] = "�� ������� ���� ��� ������� �� ���������";
			
		if (!$error)
		{
			if ($total->CreatMatche($date, $tournament_id, $komanda1, $komanda2))
				$tpl->msg("���������� �����", "���������� ����� ������ �������", $PHP_SELF, false);
			else 
				$error[] = "���� �� ��� ��������";
		}
		
		if ($error)
			$matche = $_POST;
			
		break;
		
	case "edit":
		$id = intval($id);
		if (!$id)
			$error[] = "�� ������ ����";
		else 
		{
			$hidden_array['subaction'] = "doedit";
			$hidden_array['id'] = $id;
			$button = "���������";
			$title = "�������������� �����";
			$matche = $total->GetMatches(array('matche_id'=>$id), 0, 1);
			$tpl->echo = FALSE;
			$points = "&nbsp;&nbsp;".$tpl->selection($points_array, "points_1", intval($matche['points_1']))." - ".$tpl->selection($points_array, "points_2", intval($matche['points_2']));
			$tpl->echo = TRUE;
			$matche['date_matche'] = date("Y-m-d H:i", $matche['date_matche']);
		}
		break;
		
	case "doedit":
		$id = intval($id);
		if (!$id)
			$error[] = "�� ������ ����";
		else 
		{
			if ($komanda1 == "" || $komanda2 == "")
				$error[] = "���� �������� ������";
			if ($date_matche == "" || ($date = strtotime($date_matche)) === -1)
				$error[] = "�� ������� ���� ��� ������� �� ���������";
				
			if (!$error)
			{
				$set = array("date_matche" => $date, "tournament_id" => $tournament_id, "komanda1" => $komanda1, "komanda2" => $komanda2, "points_1" => $points_1, "points_2" => $points_2);
				if ($points_1 == "no" || $points_2 == "no")
					unset($set['points_1'], $set['points_2']);
					
				if ($total->UpdateMatche($set, array("matche_id" => $id)))
					$tpl->msg("�������������� �����", "�������������� ����� ������ �������", $PHP_SELF, false);
				else 
					$error[] = "���� �� ��� ��������";
			}
			
			if ($error)
			{
				$hidden_array['subaction'] = "doedit";
				$hidden_array['id'] = $id;
				$button = "���������";
				$title = "�������������� �����";
				$matche = $_POST;
			}
		}
		break;
		
	case "del":
		$id = intval($id);
		if (!$id)
			$error[] = "�� ������ ����";
		else 
		{
			if (!$confirm)
				$tpl->msg_yes_no("Delete", "�������� ����� �������� � �������� ���� ������ �� ���� ����. ����������?", array("subaction"=>"del", "confirm" => 1), $PHP_SELF);
			else 
			{
				if ($total->DeleteMatche(array("matche_id"=>$id)))
					$tpl->msg("��������", "�������� ����� ������ ������", $PHP_SELF, false);
				else 
					$error[] = "���� �� ��� ������ ��� �� �� ����������";
			}
		}
		break;
		
	case "calculate":
		$id = intval($id);
		if (!$id)
			$error[] = "�� ������ ����";
		elseif ($matche = $total->GetMatches(array("matche_id"=>$id), 0, 1)) 
		{
			if ($matche['points_1'] == "" || $matche['points_2'] == "")
			{
				$error[] = "�� ����� ���� � ���� �����";
				$hidden_array['subaction'] = "doedit";
				$hidden_array['id'] = $id;
				$button = "���������";
				$title = "�������������� �����";
			}
			else 
			{
				clear_cache();
				$good = 0;
				if ($rates = $total->GetRate(array("matche_id" => $id)))
				{
					foreach ($rates as $rate)
					{	
						$point = intval(GetPoint($matche['points_1'], $matche['points_2'], $rate['rpoints_1'], $rate['rpoints_2']));
					
						if ($point)
						{
							$total->db->query("UPDATE " . PREFIX . "_users SET points=points+$point WHERE user_id='$rate[user_id]'");
							$good++;
						}
					}
					$total->UpdateMatche(array("rates_right"=>$good, "calculate" => 1), array("matche_id" => $id));
					$tpl->msg("������� �����", "������� ������ ��������. �� $matche[rates] ������, ��������� ����������� ����� ����� $good", $PHP_SELF, false);
				}
				else
				{
					$total->UpdateMatche(array("calculate" => 1), array("matche_id" => $id));
					$tpl->msg("������� �����", "������ �� ���� ���� �� ����", $PHP_SELF, false);
				}
			}
		}
		else 
			$error[] = "������ ����� �� ����������";
			
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

$per_page = 50;
$start = (intval($_REQUEST['start']))?intval($_REQUEST['start']):0;

$tpl->OpenTable();
$tpl->OpenSubtable($title);
$tpl->OpenForm('', $hidden_array);
$tpl->echo = FALSE;
echo "<b>������</b> : ".$tpl->selection($tournaments_array, "tournament_id", (int)$matche['tournament_id']) . "&nbsp;&nbsp; <b>����� ���������� �����</b> : ". $tpl->input("date_matche", $matche['date_matche'], "text", "id=\"date_matche\"").$tpl->calendar("date_matche");
echo "<br /><br /><b>������� �������� ����</b> : ".$tpl->input("komanda1", $matche['komanda1']).$points."&nbsp;&nbsp;<b>������� �������� � ������</b> : ".$tpl->input("komanda2", $matche['komanda2']);
$tpl->echo = TRUE;
$tpl->CloseSubtable($button);
$tpl->CloseForm();
$tpl->CloseTable();

if ($matches = $total->GetMatches('',$start, $per_page,array('archive' => 'ASC', 'date_matche' => 'DESC')))
{
	$tpl->OpenTable();
	$tpl->OpenSubtable("�����");
	$tpl->OTable(array("����", "������", "������� �������� ����", "����", "������� �������� � ������", "������", "%", "��������"));
	$i = $start;
	foreach ($matches as $matche)
	{
		$id = $matche['matche_id'];
		
		if ($matche['rates'] == "")
			$matche['rates'] = 0;
            
        $archive = $matche['archive']?'style="color:gray;" align="center"':'align="center"';
			
		$td_array = array(date("d-m-Y H:i", $matche['date_matche']), $archive => $matche['name'], $matche['komanda1'], $matche['points_1']." - " .$matche['points_2'], $matche['komanda2'], $matche['rates'], (($matche['rates'])?round(($matche['rates_right']/$matche['rates'])*100):0)."%");
		if (!$matche['calculate'] && time() > $matche['date_matche'] && $matche['points_1'] != "" && $matche['points_2'] != "")
		{
			$td_array[] = "[<a href=\"$PHP_SELF&subaction=calculate&id=$id\" >���������� ����</a>][<a href=\"$PHP_SELF&subaction=edit&id=$id\">�������������</a>][<a href=\"$PHP_SELF&subaction=del&id=$id\" >�������</a>]";
		}
		else 
			$td_array[] = "[<a href=\"$PHP_SELF&subaction=edit&id=$id\">�������������</a>][<a href=\"$PHP_SELF&subaction=del&id=$id\" >�������</a>]";
		$tpl->row($td_array);
		
		$i++;
	}
	$tpl->echo = FALSE;
	if ($nav = $tpl->navigation($start, $per_page, $i, $total->GetCount('', "matches"), $PHP_SELF."?mod=totalizator&action=matches"))
		echo $tpl->row($nav, true, true);
	$tpl->echo = TRUE;
	$tpl->CTable();
	$tpl->CloseSubtable();
	$tpl->CloseTable();
}
?>
