

 <?php 
 
 //TODO: Make all functionality + one echo line for the output and include this file to the header or so.
 $url = 'http://exoapi.com/api/planets/';
 $query = "/search?fields=[name]&discoveryyear=2012&sort=[name:asc]&start=0";
 $response = file_get_contents($url.$query);

 echo "<pre> " . $response . "</pre>";
 
 $obj = json_decode($response, true);
 
 echo "<pre>";
 var_dump($obj);
 echo "</pre>";
 
 $response = $obj["response"];
 $results = $response["results"];
 $count = $response["count"];

 echo "<br/>Count: " . $count;

 foreach($results as $planet) {
 	echo "<br/>Name is " . $planet["name"] . " and ID is " . $planet["_id"];
 }
 
 ?>