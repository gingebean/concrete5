<?php 
$res = false;
if ($_REQUEST['uEmail'] && $_REQUEST['uHash']) {
	$res = UserInfo::validateUserEmailAddress($_REQUEST['uEmail'], $_REQUEST['uHash']);
}

if ($res) {

	header('Location: ' . BASE_URL . DIR_REL . '/register?register_success=1');
	exit;

}

?>