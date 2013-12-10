/**
 * PlanetShop JavaScript
 */

function displayOrderConfirmation() {

	if (window.confirm("You are about to enter a binding contract. Proceed?")) {
		document.getElementById("orderForm").submit();
	} else {
		// Do nothing
	}
}

function visitPage($link){
    window.location=  $link;
  }



function isAllNumbers($value){
	var numbers = "/^[0-9]+$/";
	if($value.match(numbers)){
		return true;
	}else{
		alert($value + "is not all numbers");
		return false;
	}
	
}

function isAllLetters($value){
	var $letters = "/[^A-Za-z]+$/";
	if($value.match("/[A-Za-z]+$/")){
		return true;
	}else{
		alert($value + " is not all letters");
		return false;
	}
	
}

function isAlphanumeric($value){
	var alphanumeric = "/^[0-9a-zA-Z]+$/";
	if($value.match(alphanumeric)){
		return true;
	}else{
		alert($value + "is not alphanumeric");
		return false;
	}
	
}

function isPhoneNumber($value){
	//TODO: Change Regex for real Phone Numbers
	var digits = "/^[0-9]+$/";
	if($value.match(digits)){
		return true;
	}else{
		alert($value + "is not all digits");
		return false;
	}
}

function isEmail($value){
	var mailformat = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
	return mailformat.test($value);
}

function isLength($value, $min, $max){
	alert("has Lenght " + $value);
	return ($value.length > $min && $value.length < $max);
}

function isName($value){
	alert("isName " + $value);
	return(isAllLetters($value) && isLength($value,1,100));
}


function verifyOrderForm() {
	
	var $first = document.getElementById("firstname").value;
	alert("TEST " + $first);
	if (!isName($first)) {
		alert("The firstname must be 1-100 letters");
		document.getElementById("fistname").select();
		return false;
	}
	
	var $last = document.getElementById("lastname").value;
	if (!isName($last)) {
		alert("The lastname must be 1-100 letters");
		document.getElementById("lastname").select();
		return false;
	}
	
	var $add = document.getElementById("address").value;
	if (!isName($add)) {
		alert("The address must be 1-100 letters");
		document.getElementById("address").select();
		return false;
	}
	
	var $nr = document.getElementById("number").value;
	if (!isAllNumbers($nr) && !isLength($nr,1,5)) {
		alert("The house number must be a number from 1 - 99999");
		document.getElementById("number").select();
		return false;
	}
	var $ac = document.getElementById("areacode").value;
	if (!isAllNumbers($ac) && !isLength($ac,1,7)) {
		alert("The house number must be a number from 1 - 9999999");
		document.getElementById("areacode").select();
		return false;
	}
	var $city = document.getElementById("city").value;
	if (!isName($city)) {
		alert("The city name must be 1-100 letters");
		document.getElementById("city").select();
		return false;
	}
	var $st = document.getElementById("state").value;
	if (!isName($st)) {
		alert("The state name must be 1-100 letters");
		document.etElementById("state").select();
		return false;
	}
	var $ct = document.getElementById("country").value;
	if (!isName($ct)) {
		alert("The country name must be 1-100 letters");
		document.etElementById("country").select();
		return false;
	}
	var $pt = document.getElementById("planet").value;
	if (!isName($pt)){
		alert("The planet name must be 1-100 letters");
		document.etElementById("state").select();
		return false;
	}
	var $gx = document.getElementById("planet").value;
	if (!isName($gx)){
		alert("The country name must be 1-100 letters");
		document.etElementById("galaxy").select();
		return false;
	}
	
	var $phone = document.getElementById("phone").value;
	if (!isPhoneNumber($phone) && !isLength($phone, 4, 14)) {
		alert("Please enter a valid phone number");
		document.getElementById("phone").select();
		return false;
	}
	
	var $mail = document.getElementById("mail").value;
	if (!isEmail($mail) && !isLength($mail, 5, 254)) {
		alert("Please enter a valid E-Mail address");
		document.getElementById("mail").select();
		return false;
	}

	displayOrderConfirmation();
}