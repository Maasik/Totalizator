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

$per_page = 50;
$start = (intval($_REQUEST['start']))?intval($_REQUEST['start']):0;

if ($rates = $total->GetRate('', $start, $per_page, array("date_rate"=>"DESC")))
{
	$tpl->OpenTable();
	$tpl->OpenSubtable("������");
	$tpl->OTable(array("������������", "������", "����", "����"));
	$i = $start;
	foreach ($rates as $rate)
	{
		if ($rate['calculate'])
		{
			$point = GetPoint($rate['mpoints_1'] ,$rate['mpoints_2'], $rate['rpoints_1'], $rate['rpoints_2']);
		}
		else 
			$point = "n/a";
            
        $archive = $rate['archive']?'style="color:gray;" align="center"':'align="center"';
			
		$tpl->row(array($rate['username'], $archive => $rate['tname'], $rate['komanda1'] . " " . $rate['rpoints_1'] . " - " . $rate['rpoints_2'] . " " . $rate['komanda2'], $point));
		
		$i++;
	}
	$tpl->echo = FALSE;
	if ($nav = $tpl->navigation($start, $per_page, $i, $total->GetCount('', "rates"), $PHP_SELF."?mod=totalizator&action=rates"))
		echo $tpl->row($nav, true, true);
	$tpl->echo = TRUE;
	$tpl->CTable();
	$tpl->CloseSubtable();
	$tpl->CloseTable();
}
else 
	$tpl->msg("������", "������ �� ��������", $PHP_SELF."?mod=totalizator");

?>
