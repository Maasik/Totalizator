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

define('AREA', 'ADMIN');

include(ROOT_DIR . "/language/".$config['langs']."/totalizator.lng");
include(ENGINE_DIR . "/data/totalizator_conf.php");
include(ENGINE_DIR."/totalizator/functions.php");
include(ENGINE_DIR."/totalizator/version.php");

if (get_magic_quotes_gpc())
{
	$_GET=array_map_recursive('stripslashes',$_GET);
	$_POST=array_map_recursive('stripslashes',$_POST);
	$_COOKIE=array_map_recursive('stripslashes',$_COOKIE);
	$_REQUEST=array_map_recursive('stripslashes',$_REQUEST);
}

include(ENGINE_DIR."/totalizator/template.admin.class.php");
include(ENGINE_DIR."/totalizator/totalizator.class.php");

$total = new Totalizator(time () + ($config['date_adjust'] * 60), $db);

$subaction = empty($_REQUEST['subaction'])?'':$_REQUEST['subaction'];
$action = empty($_REQUEST['action'])?'':$_REQUEST['action'];
$id = empty($_REQUEST['id'])?0:(int)$_REQUEST['id'];;

$action_array = array(	"tournaments" => "�������",
						"matches" => "�����",
						"rates" => "������");

$tpl->menu(array("�������" => array("action"=>'tournaments', "image"=>'tournaments.jpg'),
                 "�����" => array("action"=>'matches', "image"=>'matches.jpg'),
                 "������" => array("action"=>'rates', "image"=>'rates.jpg'), 
                 "���������" => array("action"=>"setting", "image" => "settings.jpg")), 
           $PHP_SELF."?mod=totalizator", 
           "engine/totalizator/images"
           );
           
if (!empty($_POST['clear_db']))
{
    $total->ClearDB();
    $tpl->msg("������� ��", '���� ������ ������� �������', $PHP_SELF . "?mod=totalizator");
}
else if (!empty($_POST['clear_points']))
{
    $total->clearPoints();
    $tpl->msg("���������", '���� ������������� ��������', $PHP_SELF . "?mod=totalizator");
}
else if (!empty($_POST['new_season']))
{
    $total->NewSeason();
    $tpl->msg("����� �����", '��� ������� ���������� � �����', $PHP_SELF . "?mod=totalizator");
}
else if (!empty($_POST['reCalculate']))
{
    $total->reCalculate();
    $tpl->msg("��������", '���� ������������� ���� ����������� �� ������� �������� � ��������� ������', $PHP_SELF . "?mod=totalizator");
}
                 
$tpl->header($action_array[$action], true, true);
$tpl->head = FALSE;
$tpl->footer = FALSE;

switch ($action)
{
	case "tournaments":
		include(ENGINE_DIR."/totalizator/admin/tournaments.php");
		break;
		
	case "matches":
		include(ENGINE_DIR."/totalizator/admin/matches.php");
		break;
		
	case "rates":
		include(ENGINE_DIR."/totalizator/admin/rates.php");
		break;
		
	case "setting":
		include(ENGINE_DIR."/totalizator/admin/setting.php");
		break;
		
	default:
		$tpl->OpenTable();
		$tpl->OpenSubtable("����������");
		$tournaments = $total->db->super_query("SELECT COUNT(*) AS count FROM ". PREFIX . "_tournaments");
		$matches = $total->db->super_query("SELECT COUNT(*) AS count FROM " . PREFIX . "_matches");
		$rates = $total->db->super_query("SELECT COUNT(*) AS count FROM " . PREFIX . "_rates");
		$matches_nocalculate = $total->db->super_query("SELECT COUNT(*) AS count FROM " . PREFIX . "_matches WHERE calculate='0'");
		$tpl->stats(array("�������� �� �����" => $tournaments['count'], 
                          "����� ������ �� �����" => $matches['count'], 
                          "�� ��� �� �������" => "<font color=\"red\">".$matches_nocalculate['count']."</font>", 
                          "����� ������" => $rates['count'], $tpl->line => $tpl->line, 
                          "������ ������������� ������" => VERSION, 
                          "��������� ��������� ������" => "<a href=\"http://www.kaliostro.net/\" ><b><font color=\"green\" >www.kaliostro.net</font><b></a>"));
		$tpl->CloseSubtable();
		$tpl->CloseTable();
        
        $tpl->OpenTable();
		//$tpl->OpenSubtable("����������");
        $tpl->OpenForm();
        $tpl->input('clear_db', '�������� ��', 'submit');
        echo '&nbsp;&nbsp;';
        $tpl->input('clear_points', '�������� ���� �������������', 'submit');
        echo '&nbsp;&nbsp;';
        $tpl->input('reCalculate', '����������� ����', 'submit');
        echo '&nbsp;&nbsp;';
        $tpl->input('new_season', '����� �����', 'submit');
        
        $tpl->CloseForm();
        //$tpl->CloseSubtable();
		$tpl->CloseTable();
}
/*
echo "<pre>";
print_r($db->query_list);
*/
$tpl->footer(true);


?>
