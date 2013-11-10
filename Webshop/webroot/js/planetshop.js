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