<?PHP

require dirname(__FILE__) . "/engine/totalizator/InstallUpdate.php";

require_once ENGINE_DIR.'/totalizator/version.php';
require(ENGINE_DIR . "/totalizator/functions.php");
require(ENGINE_DIR . "/totalizator/template.admin.class.php");

$version = VERSION;
define('MODULE_NAME', 'Totalizator (�����������)');
$licence = /*licadm*/'.'/*/licadm*/;
define('CONFIG_VARNAME', 'total_conf');
define('CONFIG_FILE', 'totalizator_conf.php');
define('REQUIRED_DLE', 5.3);
define('REQUIRED_PHP', 5.0);
define('REQUIRED_MYSQL', 4.1);
define('YEAR', 2008);
$image_patch = "engine/totalizator/images/install";
$important_files = array();

$text_main = <<<HTML
<b>�������� �����������:</b>
- ���������� �������� 
- ���������� ������ 
- ������ ������������� �� ����� 
- ���������� ������������ ���������� ����� � ����������� �� ������ ����� � ������ ������������ 
- ����������� ������������ AJAX ��� �������� �/� ���������� 
- ����������� ������������� ��� 
- ����������� ������������� ����������� 
- ������� �� ��������, ��������, ������������ 
- 3 ����� "����� �������������� ����", "����� ������������� ����", "����� ��������". 
- ����� ��������
HTML;
$text_main = nl2br($text_main);

if ($_POST['type'] == "update")
{
	$obj = new install_update(MODULE_NAME, $version, array(), $licence, $db, $image_patch);
	$obj->year = YEAR;
	require(ENGINE_DIR . "/data/" . CONFIG_FILE);
	$module_config = ${CONFIG_VARNAME};
	
	switch ($module_config['version_id'])
	{
		case VERSION:
			$obj->Finish("<div style=\"text-align:center;font-size:150%;\">�� ����������� ���������� ������ �������. ���������� �� ���������</div>");
			break;
			
		case '1.0.5':
		case '1.0.0':
	       $to_version = VERSION;
           $obj->steps_array = array(
                                    "ChangeLog",
                                    "�������� ��������",
                                    "������ � ����� ������",
                                    "���������� ����������"
                                    );
                                    $ChangeLog = <<<TEXT
<b>���������� �� ������ $to_version</b>

[+] - ����� �������� 
[+] - ����������������� �� 
[+] - ���� ������������� �� �������� 
[+] - �������������� ������ 
[+] - ��������� � ���������� 
[+] - ���� � ����� � �������
[fix] - ���������� ������ 

TEXT;
                                    $ChangeLog = nl2br($ChangeLog);
                                    $important_files = array(
                        './install.php',
                        './engine/data/' . CONFIG_FILE,
                                    );
                                    
                                    $table_schema[] = "ALTER TABLE `" . PREFIX . "_tournaments` add column `archive` TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL";
                                    $table_schema[] = "UPDATE `" . PREFIX . "_rates` SET date_rate=" . time();
                                    
                                    $module_config = array_merge($module_config, array('game_points' => "15",
                                                                                       'allow_edit' => "0",
                                                                                       'show_archive' => "0"
                                                                                        ));
                                    
                                    
                                    $finish_text = <<<HTML
<div style="text-align:center;">���������� ������ �� ������ $to_version ������ �������.</div>
HTML;
                                    switch (intval($_POST['step']))
                                    {
                                        case 0:
                                            $obj->Main($ChangeLog, '������ ����������');
                                            break;

                                        case 1:
                                            $obj->CheckHost($important_files, REQUIRED_DLE, REQUIRED_PHP, REQUIRED_MYSQL);
                                            break;
                                            
                                        case 2:
                                            $obj->Database($table_schema);
                                            break;
                                                
                                        case 3:
                                            $obj->ChangeVersion(CONFIG_FILE, CONFIG_VARNAME, $module_config, array(), $to_version);
                                            $obj->Finish($finish_text, $to_version);
                                            break;
                                    }
		    break;
			
		default:
			$text = <<<TEXT
<b>�� ��������� ������ ������. �������������� ������.</b>
TEXT;
			$obj->OtherPage($text);
			break;
	}
}
else 
{
	$title = array(
					"�������� ������",
                    "������������ ����������",
                    "�������� ��������",
                    "�������� ����� ��������",
                    "������ � ����� ������",
                    "���������� ���������"
				);
				
	$obj = new install_update(MODULE_NAME, $version, $title, $licence, $db, $image_patch);
	$obj->year = YEAR;

	switch ($_POST['step'])
	{
	    case 1:
	        $module_name = MODULE_NAME;
	        $head_licence = <<<HTML
���������� ����������� ���������� � ������� ���������������� ���������� �� ������������� ������ "$module_name".
HTML;

	        $text_licence = <<<HTML
���������� ����� �����:</b><ul><li>�������� ������ � ��������� ������������ �������� � ������������ � ������� ������ �����.</li><br /><li>����������� � �������������� ���������� �� ��������� ���� ������������ �������� � �������� ������, ���� � ��� ����� ������� �������� �� ������������� ������������ ������������ �������� �� ����� �����������.</li><br /><li>���������� ����������� ������� �� ������ ���� ����� ������������� ����������� ���� �� ����, � ����� ������� �������� ������� � ����������� �����.</li><br /></ul><br /><b>���������� �� ����� �����:</b><br /><ul><li>���������� ����� �� ������������� ���������� ������� �����, ����� �������, ������������� ���� � ����� ����������.</li><br /><li>�������� ��������� ����������� �����, ������� ��������� ��� ��������� ����������� ��������, ������������ �� ����� ����������� ����</li><br /><li>������������ ����� ����� ����� ������ <b>$module_name</b> �� ����� ��������</li><br /><li>�������������, ��������� ��� ����������� �� ����� ����� ��������� ����� ������</li><br /><li>�������������� ��� ������������� ��������������� �������������� ����� ������ <b>$module_name</b></li><br /></ul>
HTML;
	        
			$obj->Licence($head_licence, $text_licence);
			
			
		case 2:
		    $important_files = array(
						'./install.php',
                        './engine/data/'
						);
						
			$obj->CheckHost($important_files, REQUIRED_DLE, REQUIRED_PHP, REQUIRED_MYSQL);
			
        case 3:
            $total_conf = array(
                            'allow_cache' => "0",
                            'alt_url' => "1",
                            'per_page' => "50",
                            'time' => "10",
                            'allow_view_points' => "0",
                            'allow_rates' => "1",
                            'allow_procent' => "0",
                            'point_3' => "3",
                            'point_2' => "2",
                            'point_1' => "1",
                            'point_0' => "0",
                            'game_points' => "15",
                            'allow_edit' => "0",
                            'show_archive' => "0",
                            'allow_PredictedMatche' => "0",
                            'allow_NotPredictedMatche' => "0",
                            'predicted_limit' => "40",
                            'short_name' => "10",
                            'allow_RatesUsers' => "0",
                            'user_limit' => "10",
                            );
        
            $tpl->echo = FALSE;
            
            include_once ENGINE_DIR . "/totalizator/admin/settings_array.php";
        	
			$obj->Settings($settings_array, $total_conf, CONFIG_VARNAME, CONFIG_FILE);
			
        case 4:
		    $table_schema[PREFIX . "_tournaments"] = "CREATE TABLE `" . PREFIX . "_tournaments` (
                                                   `tournament_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                  `name` VARCHAR(255) DEFAULT NULL,
                                                  `alt_name` VARCHAR(255) DEFAULT NULL,
                                                  `description` TEXT,
                                                  `archive` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
                                                  PRIMARY KEY (`tournament_id`)
             ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";
		    
		    $table_schema[PREFIX . "_matches"] = "CREATE TABLE `" . PREFIX . "_matches` (
                   `matche_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `tournament_id` INT(10) UNSIGNED DEFAULT NULL,
                  `date_matche` INT(10) UNSIGNED DEFAULT NULL,
                  `komanda1` VARCHAR(200) DEFAULT '',
                  `komanda2` VARCHAR(200) DEFAULT '',
                  `points_1` SMALLINT(5) UNSIGNED DEFAULT NULL,
                  `points_2` SMALLINT(5) UNSIGNED DEFAULT NULL,
                  `rates` SMALLINT(5) UNSIGNED DEFAULT '0',
                  `rates_right` SMALLINT(5) UNSIGNED DEFAULT '0',
                  `calculate` TINYINT(1) DEFAULT '0',
                  PRIMARY KEY (`matche_id`),
                  KEY `tournament_id` (`tournament_id`)
             ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";
             
		    $table_schema[PREFIX . "_rates"] = "CREATE TABLE `" . PREFIX . "_rates` (
                   `matche_id` INT(10) UNSIGNED NOT NULL,
                  `user_id` INT(10) UNSIGNED NOT NULL,
                  `points_1` SMALLINT(5) UNSIGNED DEFAULT NULL,
                  `points_2` SMALLINT(5) UNSIGNED DEFAULT NULL,
                  `date_rate` INT(10) UNSIGNED DEFAULT NULL,
                  PRIMARY KEY (`matche_id`,`user_id`)
             ) ENGINE=MyISAM /*!40101 DEFAULT CHARACTER SET " . COLLATE . " COLLATE " . COLLATE . "_general_ci */";
		    
            $table_schema[PREFIX . "_users"] = "ALTER TABLE `" . PREFIX . "_users` ADD `points` int(5) unsigned NOT NULL default 0";
            
        	if ($config['version_id'] >= 8.2)
        	{
        	    $table_schema[] = "INSERT IGNORE `" . PREFIX . "_admin_sections` (allow_groups, name, icon, title, descr) VALUES ('all', 'totalizator', 'totalizator.jpg', 'Totalizator', '�������, �����, ������')";
        	}
        	
			$obj->Database($table_schema);
			
		case 5:
		    $text_finish = <<<TEXT
	<div style="font-size:120%;text-align:center">���������� ��� �� ������� ������. �������� ��� ������ � ��� �������� ��� ������ ������������!!! ��� ��������� ������� �� ������ ����� � ������������ ��� ������ �� �� ������ ��������� <a href="http://forum.kaliostro.net/" >http://forum.kaliostro.net/</a> . </div>
TEXT;
			$obj->Finish($text_finish);
			break;
			
		default:
			if (file_exists(ENGINE_DIR.'/data/'.CONFIG_FILE) && empty($_POST['type']))
			{
				require(ENGINE_DIR . "/data/" . CONFIG_FILE);
				$config = ${CONFIG_VARNAME};
				$obj->steps_array = array();
				$obj->steps_array[] = "�������� ������";
				
				switch ($config['version_id'])
				{
					case "1.0.5":
					case "1.0.0":
						$obj->steps_array[] = '2.0.0';

					default:
						$obj->steps_array[] = "���������� ����������";
				}
				$obj->SetType("update", "������ ����������");
				$obj->Main($text_main, "������ ����������");
			}
			else 
			{
				$obj->SetType("install");
				$obj->Main($text_main, "������ ���������");
			}
			
			break;
	}
}

?>
