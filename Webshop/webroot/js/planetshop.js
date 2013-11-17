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

function verifyOrderForm() {

	var numbers = /^[0-9]+$/;  
	var letters = /^[a-zA-Z]+$/;  
	var alphanumeric = /^[0-9a-zA-Z]+$/;  
	var digits = /^[0-9]+$/;
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  

	var first = document.getElementById("firstname").value;
	if (first = null || !first.match(letters) || first.length > 100 || first.length < 1) {
		alert("The ufirst must be 1-100 characters");
		document.getElementById("fistname").select();
		return false;
	}
	var last = document.getElementById("lastname").value;
	if (last = null || !last.match(letters)|| last.length > 100 || last.length < 1) {
		alert("The user name must be 1-100 characters");
		document.getElementById("lastname").select();
		return false;
	}
	var add = document.getElementById("address").value;
	if (add = null || !add.match(letters)|| add.length > 100 || add.length < 1) {
		alert("The address must be 1-100 characters");
		document.getElementById("address").select();
		return false;
	}
	var nr = document.getElementById("number").value;
	if (nr = null || !nr.match(numbers)|| nr < 1 || nr > 99999) {
		alert("The house number must be a number from 1-99999");
		document.getElementById("number").select();
		return false;
	}
	var ac = document.getElementById("areacode").value;
	if (ac = null || !ac.match(numbers)|| ac < 1 || ac > 9999999999) {
		alert("The area code must be a number from 1-9999999999");
		document.getElementById("areacode").select();
		return false;
	}
	var city = document.getElementById("city").value;
	if (city = null || !city.match(letters) || city.lenght < 1 || city.lenght > 100) {
		alert("The city name must be 1-100 characters");
		document.getElementById("city").select();
		return false;
	}
	var state = document.getElementById("state").value;
	if (state = null || !state.match(letters) || state.lenght < 1 || state.lenght > 100) {
		alert("The state name must be 1-100 characters");
		document.getElementById("state").select();
		return false;
	}
	var ct = document.getElementById("country").value;
	if (ct = null || !ct.match(letters) || ct.lenght < 1 || ct.lenght > 100) {
		alert("The country name must be 1-100 characters");
		document.getElementById("country").select();
		return false;
	}
	var pt = document.getElementById("planet").value;
	if (pt = null || !pt.match(letters)|| pt.lenght < 1 || pt.lenght > 100) {
		alert("The planet name must be 1-100 characters");
		document.getElementById("planet").select();
		return false;
	}
	var gx = document.getElementById("galaxy").value;
	if (gx = null || !gx.match(alphanumeric)|| gx.lenght < 1 || gx.lenght > 100) {
		alert("The galxy name must be 1-100 characters");
		document.getElementById("galaxy").select();
		return false;
	}
	
	var phone = document.getElementById("phone").value;
	if (phone = null || !phone.match(digits)|| phone.lenght < 4 || phone.lenght > 14) {
		alert("Please enter a valid phone number");
		document.getElementById("phone").select();
		return false;
	}
	
	var mail = document.getElementById("email").value;
	if (mail = null || !mail.match(mailformat)|| mail.lenght < 5 || mail.lenght > 100) {
		alert("Please enter a valid e-mail address");
		document.getElementById("phone").select();
		return false;
	}

	displayOrderConfirmation();
}