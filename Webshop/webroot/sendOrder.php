


		<div id="content">
			<div id="maincontent">
			<div id="contentarea">
			
<?php
$_SESSION['user_info']=$_POST;
$_SESSION['buy_now_prod_id']=$_GET['product_id'];


$prod_info = getProductInformation($_SESSION['buy_now_prod_id']);

echo "<div><h3> Delivery Address </h3>";

foreach($_SESSION['user_info'] as $key=>$value){
	echo $key . " : " . $value . "<br>";
}


echo "Product_ID: " . $_SESSION['buy_now_prod_id'] . "<br>";
echo "<tr>";
echo "<td class=\"cartField\">" . $prod_info->name . "</td>";
echo "<td class=\"cartField\">" . $prod_info->description . "</td>";
echo "<td class=\"cartField\">" . $prod_info->price . "</td>";
echo "</tr>";

echo "</div>";
?>

		<div>
			  <a href="<?php
                                echo get_href("printorder"); ?>"
                                >Print</a>
		</div>


			
			</div>
			
			<?php include('sidebar.php'); ?>
			</div>
		</div>