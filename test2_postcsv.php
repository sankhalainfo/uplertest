<?php
include_once "includes/common.php";

$arrTestResult = fnValidateTest2Csv();

if($arrTestResult['status'])
{
	fnRedirectUrl($strBaseURL.'/test2_csv.php?error=1');
	exit;
}
else
{
	//Create CSV file with specified number of rows.
	fnCreateCsvCsvFile();
}
?>