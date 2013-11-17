		<div id="content">
			<div id="maincontent">
			<div id="contentarea">
			
<?php

$first = $_POST['firstname'];
$last = $_POST['lastname'];
$address = $_POST['address'];
$number = $_POST['number'];
$areacode= $_POST['areacode'];
$city= $_POST['city'];
$state= $_POST['state'];
$country= $_POST['country'];
$planet= $_POST['planet'];
$galaxy= $_POST['galaxy'];
$phone= $_POST['phone'];
$email= $_POST['email'];

echo "$first $last - $address $number $city $state $country $planet $galaxy $phone $email";
?>



			
			</div>
			
			<?php include('sidebar.php'); ?>
			</div>
		</div>