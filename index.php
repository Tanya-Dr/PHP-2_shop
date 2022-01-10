<?php
session_start();
spl_autoload_register(function ($className){
    include_once "c/$className.php";
});

$action = 'action_';
$action .=(isset($_GET['act'])) ? $_GET['act'] : 'index';

switch ($_GET['c'])
{
	case 'User':
		$controller = new C_User();
		break;
	default:
		$controller = new C_Catalog();
}

$controller->Request($action);