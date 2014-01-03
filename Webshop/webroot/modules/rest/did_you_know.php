

<?php

// This class outputs the did you know line on the home-Page find more information about the API on http://exoapi.com

$count = 760; // the size of all the Planets listet in this API at the moment
$randNb = mt_rand ( 0, $count ); // Pick a Random Number, to find a Random Plant from the API


$url = 'http://exoapi.com/api/planets/';
$query = "/all?fields=[name,properties.mass,properties.radius,discoveryyear,description]&sort=[name:asc]&limit=1&start=$randNb";
$response = file_get_contents ( $url . $query );
$obj = json_decode ( $response, true );
$response = $obj ["response"];
$results = $response ["results"][0]; // Zero is for the fisr Entry in the Results Array. As only one Planet is Rewuested at a Time, this is always zero.

$name = $results["name"];
$year = $results["discoveryyear"];
$radius = $results["properties"] ["radius"];
$mass = $results ["properties"] ["mass"];
$description = $results["description"];

echo "<div id=\"dYK_head\"> Did you know that, </div>";
echo "<div id=\"dYK\">";
if (! $name) {
	echo "we don't know either!";
} else {
	echo "\" $name \" ";
	if (! $year) {
		echo "is the name of a Planet!";
	} else {
		echo "was discovered in $year! ";
	}
	
	if (! $radius) {
		echo "The Planets radius is unknown and ";
	} else {
		echo "The Planets radius is $radius and ";
	}
	
	if (! $mass) {
		echo "its mass i unknown.";
	} else {
		echo "it has a mass of $mass.";
	}
	
	if (! $description) {
		echo "";
	} else {
		echo "$description";
	}
}
echo "</div>";
?>

