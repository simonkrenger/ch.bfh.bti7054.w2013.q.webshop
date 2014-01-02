

 <?php 
 
//  $url = 'http://exoapi.com/api/skyhook/';
//  $query = "planets/all?fields=[discoveryyear]&sort=[name:asc]&limit=3&start=0";
//  $response = file_get_contents($url.$query);

 
//  $obj = json_decode($response);
//  $response_array = json_decode($response,true);
 
//  echo var_dump($obj) . "<br>"."<br>";
//  echo var_dump($response_array);
 
//  $planet = $obj->response->results[0];
//  $planet_id = $planet->
//  echo var_dump($planet_iD);
//  ?>
 
 
 { 
  "response": 
  {
    "results": [ {field:value, field2:value2 … } ], 
    "count": 100 
  }
}


object(stdClass)#1 (1) { 

["response"]=> object(stdClass)#2 (2) {
 ["results"]=> array(3) { 
 	[0]=> object(stdClass)#3 (1) {
 	 ["_id"]=> object(stdClass)#4 (1) {
 	  ["$oid"]=> string(24) "508d8e3978d39b1134000002" } }
    [1]=> object(stdClass)#5 (1) { 
     ["_id"]=> object(stdClass)#6 (1) { 
      ["$oid"]=> string(24) "508d8e3978d39b1134000003" } } [2]=> object(stdClass)#7 (1) { ["_id"]=> object(stdClass)#8 (1) { ["$oid"]=> string(24) "508d8e3978d39b1134000001" } } } ["count"]=> int(3) 
 
 }

} 


 object(stdClass)#1 (1)
  { 
  ["response"]=> object(stdClass)#2 (2) 
  {
   ["results"]=> array(3) 
  {
   [0]=> object(stdClass)#3 (1) 
  {
   ["_id"]=> object(stdClass)#4 (1) 
  {
   ["$oid"]=> string(24) "508d8e3978d39b1134000002" 
   }
   } [1]=> object(stdClass)#5 (1) 
   { ["_id"]=> object(stdClass)#6 (1) 
   { ["$oid"]=> string(24) "508d8e3978d39b1134000003" }
    } [2]=> object(stdClass)#7 (1) 
    { ["_id"]=> object(stdClass)#8 (1) 
    { ["$oid"]=> string(24) "508d8e3978d39b1134000001" } 
    }
     } ["count"]=> int(3) }
      } 