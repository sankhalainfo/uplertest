<?php
@session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
$strBaseURL = 'https://kitecommerce.in/upler_test';
function fnConnectDB()
{
	$strDbUser = 'kitecomme_uplertest';
	$strDbPass = '@0I98HM7Kztq';
	$strDbName = 'kitecomme_upler';
	$strDbHost = 'localhost';
	
	$objConn = new mysqli($strDbHost, $strDbUser, $strDbPass, $strDbName);
	if ($objConn->connect_errno) {
		throw new RuntimeException('Error Connecting Database: ' . $objConn->connect_error);
	}
	return $objConn;
}
function fnDuplicateIDNumber($strIdNumber)
{
	$objConn = fnConnectDB();
	$boolDuplicate = false;
	$sqlQuery = " SELECT count(id) as total FROM test1 WHERE id_number = '$strIdNumber'";
	$result = $objConn->query($sqlQuery);
	$arrData = $result->fetch_assoc();
	if(isset($arrData['total']) && $arrData['total'] > 0)
	{
		$boolDuplicate = true;
	}
	return $boolDuplicate;
}
function fnValidateTest2Csv()
{
	$arrErrors = array();
	$arrPost = $_POST;
	
	$boolError = 0;
	$_SESSION['test2csv_data'] = $arrPost;
	if(trim($arrPost['num_records']) == '')
	{
		$boolError = 1;
		$arrErrors[] = 'Please Enter Number of Records to be generated';
	}
	else if(!preg_match('/^([0-9])+$/i',trim($arrPost['num_records'])))
	{
		$boolError = 1;
		$arrErrors[] = 'Please Enter only Numbers';
	}
	$_SESSION['test2csv_errors'] = $arrErrors;
	return array('status' => $boolError, 'errors' => $arrErrors);	
}
function fnValidateTest1()
{
	$arrErrors = array();
	$arrPost = $_POST;
	
	$boolError = 0;
	$_SESSION['test1_data'] = $arrPost;
	if(trim($arrPost['name']) == '')
	{
		$boolError = 1;
		$arrErrors[] = 'Please Enter Name';
	}
	if(trim($arrPost['surname']) == '')
	{
		$boolError = 1;
		$arrErrors[] = 'Please Enter Surname';
	}
	if(trim($arrPost['id_number']) == '')
	{
		$boolError = 1;
		$arrErrors[] = 'Please Enter ID Number';
	}
	//Check if ID Number is 13 Char Long.
	//Check if ID number is Numeric. 
	if(!preg_match('/^([0-9]{13})$/i',trim($arrPost['id_number'])))
	{
		$boolError = 1;
		$arrErrors[] = 'ID Number must be 13 Character Long & Only Numbers Allowed';
	}
	//Check if ID number is unique.
	if(fnDuplicateIDNumber(trim($arrPost['id_number'])))
	{
		$boolError = 1;
		$arrErrors[] = 'Duplicate ID Number not allowed. Please Enter unique ID Number';
	}
	
	if(trim($arrPost['date_birth']) == '')
	{
		$boolError = 1;
		$arrErrors[] = 'Please Enter Date of Birth';
	}
	$_SESSION['test1_errors'] = $arrErrors;
	return array('status' => $boolError, 'errors' => $arrErrors);	
}
function fnRedirectUrl($strUrl)
{
	if(!headers_sent())
	{
		header('Location:'.$strUrl);
	}
	else
	{
		?>
		<script type="text/javascript">
			location.href = '<?php echo $strUrl; ?>';
		</script>
		<?php
	}
}
function fnValidateTest2ImportCsv()
{
	$arrErrors = array();
	$arrFiles = $_FILES['output_csv'];	
	
	$boolError = 0;
	
	if(isset($arrFiles['error']) && $arrFiles['error'] > 0)
	{
		$boolError = 1;
		$arrErrors[] = 'Please Upload CSV File';
	}
	else if(isset($arrFiles['error']) && $arrFiles['error'] == 0 && $arrFiles['type'] != 'text/csv')
	{
		$boolError = 1;
		$arrErrors[] = 'It accepts only CSV file.';
	}
	$_SESSION['test2importcsv_errors'] = $arrErrors;
	return array('status' => $boolError, 'errors' => $arrErrors);
}
function fnSaveTest1Database()
{
	global $strBaseURL;
	
	$_SESSION['test1_data'] = $_SESSION['test1_errors'] = array();
	
	$arrPost = $_POST;
	$objConn = fnConnectDB();
	$sqlQuery = " INSERT INTO test1 ";
	$intD = 0;
	foreach($arrPost as $key => $value)
	{
		$strValue = addslashes($value);
		if($intD > 0)
		{			
			$sqlQuery .= ", $key = '$strValue'";				
		}
		else
		{
			$sqlQuery .= " SET $key = '$strValue'";
		}
		
		$intD++;
	}
	
	$result = $objConn->query($sqlQuery);
	if(!$result)
	{
		$_SESSION['test1_data'] = $arrPost;
		$arrErrors[] = 'Could not save into Database. Please try again later';
		$_SESSION['test1_errors'] = $arrErrors;
		fnRedirectUrl($strBaseURL.'/test1.php?error=1');
		exit;
	}
	else{
		fnRedirectUrl($strBaseURL.'/test1.php?success=1');
		exit;
	}
}
function fnCreateCsvCsvFile()
{
	global $strBaseURL;
	
	$intNumRecords = $_POST['num_records'];
	
	$arrNames = array('Amit','Rupesh','Atul','Pravin','Harsha','Tanisha','Palak','Pavan','Paras','Jignesh','Ashish','Pratham','Param','Khushi','Shruti','Pankaj','Dharmendra','Rajesh','Bharat','Nilesh');
	$arrSurNames = array('Sankhala','Jain','Chajed','Gothi','Khivsara','Bhatevara','Bora','Parakh','Lodha','Patel','Patil','Shinde','Borse','Goyal','Tatiya','Bhansali','Navlakha','Bardiya','Mutha','Shah');
	
	
	$flCsvFile = 'output.csv';

	// open csv file for writing
	$objCsv = fopen($flCsvFile, 'w');

	if ($objCsv === false) {
		die('Error opening the file ' . $flCsvFile);
	}
	$arrHeading = array('Id','Name','Surname','Initials','Age','DateofBirth');
	
	fputcsv($objCsv,$arrHeading);
	$arrDuplicateCsv = array();
	for($intI=0;$intI<$intNumRecords;$intI++)
	{
		$intRandomName = rand(0,19);
		$intRandomSurname = rand(0,19);
		$intRandomAge = rand(0,150);
		$strName = $arrNames[$intRandomName];
		$arrInitialName = array();
		$arrInitialName = explode(' ',$strName);
		$strInitial = '';
		foreach($arrInitialName as $key => $value)
		{
			$strInitial .= substr($value,0,1);
		}
		$strStartDate = strtotime('1900-01-01');
		$strEndDate = strtotime('2100-12-31');
		$intRandomTime = rand($strStartDate, $strEndDate);
		$strBirthDate = date('d/m/Y',$intRandomTime);
		$arrWriteCsv = array();
		$arrWriteCsv[0] = $intI + 1;
		$arrWriteCsv[1] = $strName;
		$arrWriteCsv[2] = $arrSurNames[$intRandomSurname];
		$arrWriteCsv[3] = $strInitial;
		$arrWriteCsv[4] = $intRandomAge;
		$arrWriteCsv[5] = $strBirthDate;		
		fputcsv($objCsv,$arrWriteCsv);
	}
	
	fclose($objCsv);
	fnRedirectUrl($strBaseURL.'/test2_csv.php?success=1');
	exit;	
}
function fnUploadCsv()
{
	global $strBaseURL;
	$arrFiles = $_FILES['output_csv'];	
	$strCurrentFolder = __DIR__;
	$strCurrentFolder = str_replace('includes','',$strCurrentFolder);
	if(!move_uploaded_file($arrFiles['tmp_name'],$strCurrentFolder.'import_output.csv'))
	{
		$arrErrors[] = 'File is not uploaded. Try again later.';		
		fnRedirectUrl($strBaseURL.'/test2_importcsv.php?error=1');
		exit;
	}
}
function fnProcessCsv()
{
	global $strBaseURL;
	
	$strCurrentFolder = __DIR__;
	$strCurrentFolder = str_replace('includes','',$strCurrentFolder);
	$strUploadedFile = $strCurrentFolder.'import_output.csv';
	if(file_exists($strUploadedFile))
	{
		//Create Table.
		$objConn = fnConnectDB();
		$sqlQuery = " CREATE TABLE IF NOT EXISTS csv_import (
			  `id` int(11) NOT NULL,
			  `name` varchar(512) NOT NULL,
			  `surname` varchar(512) NOT NULL,
			  `initial` varchar(1) NOT NULL,
			  `age` int(11) NOT NULL,
			  `birth_date` varchar(512) NOT NULL
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$objConn->query($sqlQuery);
			
		$sqlQuery = "ALTER TABLE `csv_import` ADD PRIMARY KEY (`id`); ";		
		$objConn->query($sqlQuery);
		
		$sqlQuery = "ALTER TABLE `csv_import` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
		$objConn->query($sqlQuery);
		
		$sqlQuery = "TRUNCATE TABLE `csv_import`;";
		$objConn->query($sqlQuery);
		
		//Import Records in the table.
		$intP = 0;
		if (($handle = fopen($strUploadedFile, "r")) !== FALSE) 
		{
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
			{
				if($intP > 0)
				{
					$strName = addslashes($data[1]);
					$strSurName = addslashes($data[2]);
					$strInitial = addslashes($data[3]);
					$intAge = $data[4];
					$strBirthDate = addslashes($data[5]);
					$sqlQuery = "";
					$sqlQuery = " INSERT INTO csv_import SET name='$strName', surname='$strSurName', initial='$strInitial', age=$intAge,birth_date='$strBirthDate'";
					$objConn->query($sqlQuery);
				}
				$intP++;
			}
		}
		fclose($objCsv);
		fnRedirectUrl($strBaseURL.'/test2_importcsv.php?success=1');
		exit;
	}
	else
	{
		$arrErrors[] = 'Unable to import CSV. Try again later.';
		$_SESSION['test2importcsv_errors'] = $arrErrors;
		fnRedirectUrl($strBaseURL.'/test2_importcsv.php?error=1');
		exit;
	}
}
?>