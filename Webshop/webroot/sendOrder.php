


		<div id="content">
			<div id="maincontent">
			<div id="contentarea">
			
<?php

$first = $_POST['firstname'];
$last = $_POST['lastname'];
$street = $_POST['street'];
$areacode= $_POST['areacode'];
$city= $_POST['city'];
$state= $_POST['state'];
$country= $_POST['country'];
$planet= $_POST['planet'];
$galaxy= $_POST['galaxy'];
$phone= $_POST['phone'];
$email= $_POST['email'];

echo "$first $last - $street $city $state $country $planet $galaxy $phone $email";
?>

		<div>
			  <a href="<?php
                                $suffix = array();
                                $suffix = array_merge($suffix,$_POST);
                                echo get_href("printOrder", $suffix,true); ?>"
                                >Print</a>
		</div>


			
			</div>
			
			<?php include('sidebar.php'); ?>
			</div>
		</div>