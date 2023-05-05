<?php
include_once "includes/common.php";
?>
<html>
	<head>
		<title>Upler - Test2 - Import CSV File</title>	
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">		
		<link  rel="stylesheet" type="text/css"  media="all" href="css/common.css" />		
	</head>
	<body>
		<div class="wrapper">
			<div class="heading">
				<h1>Test2 - Import CSV File</h1>
			</div>
			<?php
			if(isset($_GET['error']))
			{
				if(isset($_SESSION['test2importcsv_errors']))
				{
					$arrErrors = $_SESSION['test2importcsv_errors'];
					if(is_array($arrErrors) && count($arrErrors))
					{
						?>
						<div class="message">
							<ul class="error">
								<?php 
								foreach($arrErrors as $key => $strError)
								{
									?>
									<li>
										<?php echo $strError; ?>
									</li>
									<?php
								}
								?>
							</ul>
						</div>
						<?php
					}
				}
			}
			else if(isset($_GET['success']))
			{
				?>
				<div class="message">
					<div class="success">
						CSV File Imported sucessfully.
					</div>
				</div>
				<?php
			}
			?>
			<form name="frmTest2Csv" method="POST" action="test2_postimportcsv.php" enctype="multipart/form-data">
				<div class="field">
					<label for="output_csv">Select the CSV File: </label>
					<div class="input-text">
						<input type="file" name="output_csv" id="output_csv" />
					</div>
				</div>				
				<div class="action">
					<button type="submit" class="post"><span>Import CSV</span></button>					
				</div>
			</form>
		</div>
	</body>
</html>