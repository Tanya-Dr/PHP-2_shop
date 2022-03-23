<?php
session_start();
require_once 'autoload.php';
date_default_timezone_set('Europe/Moscow');

$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

switch ($_GET['c'])
{
	case 'User':
		$controller = new C_User();
		break;
	case 'Product':
		$controller = new C_Product();
		break;
	case 'Order':
		$controller = new C_Order();
		break;
	case 'Cart':
		$controller = new C_Cart();
		break;
	case 'Admin':
		$controller = new C_Admin();
		break;
	default:
		$controller = new C_Catalog();
}

$controller->Request($action);