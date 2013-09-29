# Use Case Scenario for PlanetShop

**Use Case name:** Purchase custom planet

**Scenario:**  Customise planet and purchase it using Quick-Checkout

**Description:** A customer visits the main page of the PlanetShop and wishes to purchase a custom planet. The customer selects "Custom planet" and is then presented a list of possible planet types. After selection of the custom planet type, the customer can then modify certain options such as desired size, mass, surface and temperature. After customizing the planet, the customer places the planet in the shopping cart and proceeds to checkout. Since the customer is visiting the PlanetShop for the first time, the "Quick-Checkout" option is chosen for checkout. After entering the address and other information, the order is then placed.

**Actors:** Customer

**Trigger / Precondition:** Customer can access PlanetShop, customer has standards-compliant browser

**Results:** Customer was able to customise the planet, customer placed the order

## Sequence of events

Nr | Who | What
--- | --- | ---
1 | Customer | Visits main page of PlanetShop
2 | Customer | Selects "Custom planet" on the main page and is presented a list of possible planet types
3 | Customer | Selects "Terrestrial planet" and is then presented possible options (such as "size", "mass" or "surface")
4 | Customer | Selects options using sliders / drop-down menus
5 | Customer | Place desired planet in shopping cart
6 | Customer | Browses the category "Planets on sale"
7 | Customer | Proceeds to checkout and is presented the options "Already registered", "Register now" and "Quick-Checkout". Customer selects "Quick-Checkout"
8 | Customer | Enters personal information (name, address, ...) and clicks on "Order"
9 | System | Order is placed in the system
10 | System | Send notification e-mail to customer and shop administrators

## Variants, Exceptions
Nr | Who | What
--- | --- | ---
6.1 | Customer | Customer adds planet on sale ("Planet XXX-XXX-XXX") to shopping cart
6.2 | Customer | Customer proceeds to checkout and finds the added planet on order list
7.1 | Customer | Customer selects "Already registered"
7.2 | Customer | Customer enters username and password for PlanetShop and can proceed directly to "Order now" page
8 | Customer | Customer removes planet from order / shopping cart
