<?php
include_once "includes/common.php";
$strName = $strSurname = $strIdNumber = $dtBirth = '';
if(isset($_GET['error']))
{
	if(isset($_SESSION['test1_data']))
	{
		$arrInputs = $_SESSION['test1_data'];
		$strName = trim($arrInputs['name']); 
		$strSurname = trim($arrInputs['surname']); 
		$strIdNumber = trim($arrInputs['id_number']); 
		$dtBirth = trim($arrInputs['date_birth']);
	}
}
?>
<html>
	<head>
		<title>Upler - Test1</title>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">		
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
		<link  rel="stylesheet" type="text/css"  media="all" href="css/common.css" />
		<script>
			  $( function() {
				$( "#date_birth" ).datepicker({
				  dateFormat: "dd/mm/yy"
				});
			  } );
	  </script>
	</head>
	<body>
		<div class="wrapper">
			<div class="heading">
				<h1>Test1 - HTML Form</h1>
			</div>
			<?php
			if(isset($_GET['error']))
			{
				if(isset($_SESSION['test1_errors']))
				{
					$arrErrors = $_SESSION['test1_errors'];
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
						Records saved in database Successfully.
					</div>
				</div>
				<?php
			}
			?>
			<form name="frmTest1" method="POST" action="test_post.php">
				<div class="field">
					<label for="name">Name: </label>
					<div class="input-text">
						<input type="text" name="name" id="name" value="<?php echo $strName; ?>" />
					</div>
				</div>
				<div class="field">
					<label for="surname">Surname: </label>
					<div class="input-text">
						<input type="text" name="surname" id="surname" value="<?php echo $strSurname; ?>" />
					</div>
				</div>
				<div class="field">
					<label for="id_number">ID Number: </label>
					<div class="input-text">
						<input type="text" name="id_number" id="id_number" value="<?php echo $strIdNumber; ?>" />
					</div>
				</div>
				<div class="field">
					<label for="date_birth">Date of Birth: </label>
					<div class="input-text">
						<input readonly placeholder="DD/MM/YYYY" type="text" name="date_birth" value="<?php echo $dtBirth; ?>" id="date_birth" />
					</div>
				</div>
				<div class="action">
					<button type="submit" class="post"><span>Post</span></button>
					<button type="reset" class="cancel"><span>Cancel</span></button>
				</div>
			</form>
		</div>
	</body>
</html>