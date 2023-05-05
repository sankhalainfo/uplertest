<?php
include_once "includes/common.php";

$arrTestResult = fnValidateTest2ImportCsv();

if($arrTestResult['status'])
{
	fnRedirectUrl($strBaseURL.'/test2_importcsv.php?error=1');
	exit;
}
else
{
	//Import CSV file with specified number of rows.
	fnUploadCsv();
	fnProcessCsv();
}
?>