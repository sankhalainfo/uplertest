<?php
include_once "includes/common.php";

$arrTestResult = fnValidateTest1();

if($arrTestResult['status'])
{
	fnRedirectUrl($strBaseURL.'/test1.php?error=1');
	exit;
}
else
{
	//Save In the Database.
	fnSaveTest1Database(); 
}
?>