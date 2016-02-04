<?php

$settings_array = array(
					array(
							"title" => '�������� ����������� ���������� � ������?',
							"descr" => '�������� �������� ���� �� ����������',
							"setting"=> YesNo("allow_cache"),
							),
					array(
							"title" => '�������� ���',
							"descr" => '��� - ��������-�������� ���',
							"setting"=> YesNo("alt_url"),
							),
					array(
							"title" => '���. �� ��������',
							"descr" => '���������� ������/�������������/������ �� ��������',
							"setting"=> $tpl->input("save_con[per_page]", $total_conf['per_page'], "text" ,"style=\"width:30px\""),
							),
					array(
							"title" => '������ �� ������',
							"descr" => '���������� ����� �� �����, ����� ������������ ������',
							"setting"=> $tpl->input("save_con[time]", $total_conf['time'], "text" ,"style=\"width:30px\""),
							),
					array(
							"title" => '�������� ������ �������������',
							"descr" => '��������� ������������� ������ ������ �������������',
							"setting"=> YesNo("allow_view_points"),
							),
					array(
							"title" => '���������� ���������� ������ ��� �����',
							"descr" => '������� ���������� ������ ��� �����',
							"setting"=> YesNo("allow_rates"),
							),
					array(
							"title" => '���������� ������� ���������� ��� �����',
							"descr" => '������� ������� ��� ����� ������� ����������� ���: (������� ����/����� ������)*100',
							"setting"=> YesNo("allow_procent"),
							),
					array(
							"title" => '���� �� ��������� ���� �����',
							"descr" => '��������� ������ ����',
							"setting"=> $tpl->input("save_con[point_3]", $total_conf['point_3'], "text" ,"style=\"width:30px\""),
							),
					array(
							"title" => '���� �� ��������� ������� �����',
							"descr" => '��� ������ ��� ���� ������� ������� 2-1 �� ����� ����, � ���� ������ �� 3-2, �� ���� �������� ��� ���. �����',
							"setting"=> $tpl->input("save_con[point_2]", $total_conf['point_2'], "text" ,"style=\"width:30px\""),
							),
					array(
							"title" => '���� �� ��������� ����� �����',
							"descr" => '��������� ����� �����, ��� ������, ��� ���� ������� ������� 2-0 � ������ ������ �����, � ���� ������ 4-0, �� �� �����, �� �� �������� ��� ���. �����, �� �� ��� ���������� ���������� �����',
							"setting"=> $tpl->input("save_con[point_1]", $total_conf['point_1'], "text" ,"style=\"width:30px\""),
							),
					array(
							"title" => '���� �� �� ��������� ����� �����',
							"descr" => '�� ��������� ����� �����, ��� ������, ��� ���� ������� ������� 2-0 � ������ ������ �����, � ���� ������ 0-3, �� �� �����, �� �� �������� ��� ���. �����, �� �� ��� �� ��������� ���������� ���������� �����',
							"setting"=> $tpl->input("save_con[point_0]", $total_conf['point_0'], "text" ,"style=\"width:30px\""),
							),
                    array(
							"title" => '������������ ���������� ����� ��� ������ �����',
							"descr" => '������������� ������������ ���������� �����',
							"setting"=> $tpl->input("save_con[game_points]", $total_conf['game_points'], "text" ,"style=\"width:30px\""),
							),
                    array(
							"title" => '��������� ������������� ������������� ���� ������',
							"descr" => '��� ����������� ������������� �������� ���� �� ���� ��� �������� ����',
							"setting"=> YesNo("allow_edit"),
							),
                    array(
							"title" => '�������� ����� �� �����',
							"descr" => '��� ����������� ������������� ������������� ����� ������� �������',
							"setting"=> YesNo("show_archive"),
							),
					array(
							"title" => '�������� ���� "����� ������������� ����"',
							"descr" => '��� �����, ������� ������� ������ ����� ������� �� ��� �������',
							"setting"=> YesNo("allow_PredictedMatche"),
							),
					array(
							"title" => '�������� ���� "����� �������������� ����"',
							"descr" => '��� �����, ������� ������� ������ ����� ������� �� ��� �������',
							"setting"=> YesNo("allow_NotPredictedMatche"),
							),
					array(
							"title" => '������������ ����� ����� � ������ "����� ������������� ����" � "����� �������������� ����"',
							"descr" => '����� ������ ������� ����������� � ��� {short_name}, 0 => ��� ������ ��������',
							"setting"=> $tpl->input("save_con[short_name]", $total_conf['short_name'], "text" ,"style=\"width:30px\""),
							),
					array(
							"title" => '���������� ������ � ������ "����� ������������� ����" � "����� �������������� ����"',
							"descr" => ' 0 => 10 ������',
							"setting"=> $tpl->input("save_con[predicted_limit]", $total_conf['predicted_limit'], "text" ,"style=\"width:30px\""),
							),
					array(
							"title" => '�������� ���� "����������"',
							"descr" => '������� ������������� � ������� ���� ������ ������',
							"setting"=> YesNo("allow_RatesUsers"),
							),
					array(
							"title" => '���������� ������������� � ����� "����������"',
							"descr" => ' 0 => 10 �������������',
							"setting"=> $tpl->input("save_con[user_limit]", $total_conf['user_limit'], "text" ,"style=\"width:30px\""),
							),
					);
                    
?>