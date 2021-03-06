/**
 * PlanetShop JavaScript
 */

function displayOrderConfirmation(formname) {

	if (window.confirm("You are about to enter a binding contract. Proceed?")) {
		document.getElementById(formname).submit();
	} else {
		// Do nothing
	}
}

function visitPage(link){
    window.location=link;
  }

function isAllNumbers(value){
	var pattern = new RegExp("^[0-9]+$");
	return pattern.test(value);
}

function isAllLetters(value){
	console.log(value);
	var pattern = new RegExp("^[A-Za-z]+$");
	console.log(pattern);
	return pattern.test(value);
}

function isAlphanumeric(value){
	var pattern = RegExp("^[0-9a-zA-Z]+");
	return pattern.test(value);
	
}

function isPhoneNumber(value){
	//TODO: Change Regex for real Phone Numbers
	var pattern = RegExp("^[0-9]+");
	return pattern.test(value);
}

function isEmail(value){
	var pattern = RegExp("^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+");
	return pattern.test(value);
}

function isLength(value, min, max){
	return (value.length >= min && value.length <= max);
}

function isStreet_Nr(value){
	var pattern = RegExp("^.+");
	return pattern.test(value);
}

function isName(value){
	return(isAllLetters(value) && isLength(value, 1, 100));
}


function verifyRegistrationForm() {
	
	var inputs, index;

	form = document.getElementById("registrationForm");
	inputs = form.getElementsByTagName("input");
	for (index = 0; index < inputs.length; ++index) {
	    if (inputs[index].type == "text" ) {
	    	 if (!isAlphanumeric(inputs[index].value) && !isLength(inputs[index].value, 1, 100)) {
	    		alert("The field '" + inputs[index].name + "' must be alphanumeric, is currently '" + inputs[index].value + "'");
	    	 	inputs[index].select();
	    	 	return false;
	    	 }
	    }
	}
	document.getElementById("registrationForm").submit();
}

function verifyOrderForm() {
	
	var first = document.getElementById("firstname").value;
	if (!isName(first)) {
		alert("The firstname must be 1-100 letters");
		document.getElementById("firstname").select();
		return false;
	}
	
	var last = document.getElementById("lastname").value;
	if (!isName(last)) {
		alert("The lastname must be 1-100 letters");
		document.getElementById("lastname").select();
		return false;
	}
	
	var add = document.getElementById("street").value;
	if (!isStreet_Nr(add)) {
		alert("The address must be 1-100 letters and the nr is separated by space");
		document.getElementById("street").select();
		return false;
	}
	
	var city = document.getElementById("city").value;
	if (!isName(city)) {
		alert("The city name must be 1-100 letters");
		document.getElementById("city").select();
		return false;
	}
	var st = document.getElementById("state").value;
	if (!isName(st)) {
		alert("The state name must be 1-100 letters");
		document.etElementById("state").select();
		return false;
	}
	var ct = document.getElementById("country").value;
	if (!isName(ct)) {
		alert("The country name must be 1-100 letters");
		document.etElementById("country").select();
		return false;
	}
	var pt = document.getElementById("planet").value;
	if (!isName(pt)){
		alert("The planet name must be 1-100 letters");
		document.etElementById("state").select();
		return false;
	}
	var gx = document.getElementById("planet").value;
	if (!isName(gx)){
		alert("The country name must be 1-100 letters");
		document.etElementById("galaxy").select();
		return false;
	}
	
	var phone = document.getElementById("phone").value;
	if (!isPhoneNumber(phone) && !isLength(phone, 4, 14)) {
		alert("Please enter a valid phone number");
		document.getElementById("phone").select();
		return false;
	}
	
	var mail = document.getElementById("email").value;
	if (!isEmail(mail) && !isLength(mail, 5, 254)) {
		alert("Please enter a valid E-Mail address");
		document.getElementById("mail").select();
		return false;
	}

	displayOrderConfirmation('orderForm');
}

function removeURLParameter(url, parameter) {
	// Copied from http://stackoverflow.com/questions/1634748/how-can-i-delete-a-query-string-parameter-in-javascript
    //prefer to use l.search if you have a location/link object
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        url= urlparts[0]+'?'+pars.join('&');
        return url;
    } else {
        return url;
    }
}

/**
 * Function to update the "add to cart" link on a product detail page. The link
 * is updated with the current value of the provided input element. The
 * function adds a string in the form of "&<input.name>=<input.value" to the
 * "add to cart" link.
 * 
 * @param input
 */
function updateCartHref(input) {
	aElem = document.getElementById("addtocartlink");
	
	aElem.href = removeURLParameter(aElem.href, input.name);
	aElem.href += "&" + input.name + "=" + encodeURI(input.value);
}

function updateSlider(slider) {
	slider.nextElementSibling.innerHTML = slider.value;
	updateCartHref(slider);
}

function orderhistory_update(source, total) {
	var pagesize = 10;
	currentOffset = document.getElementById("currentPosition");
	
	var xmlhttp;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("ajax_div").innerHTML=xmlhttp.responseText;
		}
	};
	cur = parseInt(currentOffset.value);
	if(source.id == "nextbutton") {
		// Upper bound
		currentOffset.value = (cur + 10 > total) ? cur : (cur + 10);
	} else if(source.id == "prevbutton") {
		// Lower bound
		currentOffset.value = (cur - pagesize < 0) ? 0 : (cur - pagesize);
	}
	url = "/modules/order/order-history.php?offset=" + currentOffset.value;
	
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}