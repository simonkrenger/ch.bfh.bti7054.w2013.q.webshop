# PlanetShop Developer Guide

This document contains guidelines and references to working with the PlanetShop source code.

## Basic concepts

A site is always called through `index.php`. The `index.php` file then performs security checks and routing to the correct file using the `mapping.txt` file also found in the `webroot/` folder. A site is then build using the following process:

1. Include configuration and functions (`config.php` and `modules/functions.php`)
2. Set all global variables and correctly set the environment for the site (see below for details)
3. Include the header (`header.php`)
4. Perform routing based on `mapping.txt` and include the correct content file
5. Include the sidebar (`sidebar.php`) and footer (`footer.php`)

Please note that the first two steps are always performed without printing anything . This allows us to set the correct environment, including all `$_SESSION` variables and the like.

### Environment setup: require_ Functions
At the top of the file `index.php`, you will find function calls to functions like `require_db()` or `require_lang()`. These functions provide means to establish a consistent and properly defined variable environment for the application. This means that after calling `require_db()` for example, all variables and environment settings are guaranteed to be set correctly (such as `$shopdb`). See the global variables table below for more information.

## Function Reference (functions.php)

The files of PlanetShop define many useful PHP functions. Most of them are only used to provide core functionality, however there are some more complicated functions available to be used by the developer. This section lists most of the core functions. In addition to this information, all functions are thoroughly documented in PHP.


Function name | Description
--- | ---
`is_logged_in` | Function to determine if a user is logged in. Returns `TRUE` if the user is logged in.
`is_admin_user` | Function to determine if a user is an "admin user". Returns `TRUE` if the user is indeed an "admin user".
`get_href` | Function used to generate a hyperlink within the site. See "Howto: Add a new page" below for an example.
`get_safe_content_include` | Routing function used in `index.php` 
`print_form_fields` | Function used to generate forms, based on a "form file". See "Howto: Print a form" below for an example.
`print_address` | Function to print an address stored in the database based on the given ID.
`print_order` | Function to print an entire order (including shipping address and all positions). Use this to generate an order summary
`db_insert_galaxy` | Function used to insert a galaxy into the database. Note that this is not a galaxy product but part of an address. Returns the ID of the newly inserted galaxy (or the existing ID, if the galaxy is already in the database).
`db_insert_planet` | Function used to insert a planet into the database. Note that this is not a planet product but part of an address. Returns the ID of the newly inserted planet (or the existing ID, if the planet is already in the database).
`db_insert_address` | Function used to insert a new address into the database. Returns the ID of the newly inserted address if all went well. Requires the ID of a planet and an ID of a galaxy (see functions `db_insert_planet` and `db_insert_galaxy` respectively.
`db_insert_order` | Function to enter a new order into the database. Used in the checkout process.
`db_insert_order_detail` | Function to enter a new position to an existing order (typically created with `db_insert_order`).
`db_insert_order_detail_attribute` | Function to enter a new attribute to an existing order position on an existing order (see functions above).


## Global variables

The following global variables are available after calling the appropriate `require_` function:


Variable name | `require_` function | Description
--- | --- | ---
`$language` | require_lang | Represents the language set for the application.
`$shopdb` | require_db | ez_sql database object to handle database queries.
`$shopuser` | require_user | User object that is set when the user is logged in (see class `ShopUser`)
`$_SESSION["cart"]` | require_shoppingcart | Shopping cart object (see class `ShoppingCart`)


## Classes

Class | Attributes | methods | Description
--- | --- | --- | ---
ShoppingCart | `items` | `addProduct`, `removeProduct`, `clear`, `is_empty`, `getAllItems`, `displayFull`, `displaySmall`, `getQuantities` | This class represents the shopping cart of the user. Stores all items internally as `ShopProduct` objects. Features methods to add products to the shopping cart, remove products from the shopping cart, methods to clear the shopping cart, methods to get all items and helper functions to get product information.
ShopProduct | `product_id`, `attributes` | `ShopProduct`, `getNullAttributes`, `addCustomAttribute`, `getAttributeNameForId`, `getProductInfo` | Class to represent a product from the webshop. Used only in context of the shoppingcart (see class above) and checkout process. 
ShopUser | Dynamic (see description) | `ShopUser` | Class to represent a shop user. The user has an address (`ShopUserAddress`) and dynamically generated attributes. See the implementation of the class to see which attributes are available (usually `first_name`, `last_name`, `email` and the like...)
ShopUserAddress | Dynamic (see description) | `ShopUserAddress` | Class to represent a shop users address. The attributes of the class are dynamically generated. See the implementation of the class to see which attribtues are available


All classes can be found in `webroot/modules/classes/`.

## Database model

In this section, we would like to provide some insight into the database design of the PlanetShop. To see the actual design, please refer to the full ER model of the database in `doc/task10/eer_model.mwb` (MySQL Workbench format) or in `doc/task10/planetshop_db.pdf` (PDF).

Table name | Description
--- | ---
user | Table that holds all the users. Holds the `username`, both the `first_name` and the `last_name`, `email` and the current address (referenced by ID `address_id`).
user_role | Table to hold the user roles. The two typical user roles are 1 (administrator) and 2 (normal user). A administrator role is needed to access the admin are of the site.
address | Table to hold addresses (`street`, `zipcode`, `city`, `country`) and the additional attributes `planet` and `galaxy` (see the respective tables).
planet | Simple table to hold planets (Note: These are planets of the customers, not products!)
galaxy | Simple table to hold known customer galaxies (Note: These are galaxies of the customers, not products!)
product | Main product table, holds all products in the webshop. See below for an example. Holds attributes such as `name`, `category`, `description`, `price`, `inventory_quantity`.
product_category | Table to hold all product categories available in the PlanetShop
product_attribute | Table that holds all attributes in the PlanetShop. Note that one attribute might be assigned to many products (there are many shared attributes, such as "Mass" or "Diameter"). See the example below for more details on these relationships.
product_attribute_value | N:N relationship table for the `product` and `product_attribute` tables. See the example below for more details on this relationship.
order | Table to hold orders. This table holds mainly metadata on an order, such as `order_date`.
order_detail | Positions for an order. An order (`order` table) can have many order positions.
order_detail_attributes | Custom attributes for an order position (`order_detail` table).

### Products and attributes

The most important relationships in the database are the products and their attributes. Please make the following observations:

* Every product has an entry in the `product` table.
* Possible attributes are listed in the `product_attribute` table. This table includes all attributes for all products. Note that some products share an attribute (for example diameter).
* The two tables (`product` and `product_attribute`) are linked via the `product_attribute_value` table. This table defines which product has which attributes. This definition can be made with or without a value associated to the attribute. If no value is specified (`NULL`), then the attribute is "customizable" by the user.

Consider the following example (note that some table fields are not listed here for simplicity):
* In the table `product_attribute`, the attribute "Mass" is defined, it has a default value of 6:

attribute_id | name | default_value
--- | --- | ---
22 | Mass | 6

* In the table `product`, the products "Planet 1" and "Planet 2" are defined:

product_id | name | category_id | price
--- | --- | --- | ---
1 | Planet 1 | 2 | 100.00
2 | Planet 2 | 2 | 200.00

* Via the table `product_attribute_value`, the attributes are linked to the products:

product_id | product_attribute_id | value
--- | --- | ---
1 | 22 | 8
2 | 22 | NULL

Notice how the product "Planet 2" has the attribute "Mass" defined, but it has a value of "NULL"? This means that the attribute "Mass" is customizable for the product "Planet 2". The webshop will diplay a dropdown or a slider bar here (using the function `print_input_for_value_range`, defaulting to "6"). For the product "Planet 1", the value of "8" will be non-customizable.

Using this database design, one can easily define products that have fixed attributes, are fully customizable or have a mix of both.

## Howtos

### Howto: Add a new page

Let us say we want to add a new page "My site". To add a new site, you must perform the following steps:

1. Define a "site ID" for your site. This must be a short, to-the-point variable name like `mysite`. We prefer to use one or two words, no spaces or special characters.
2. Copy `minimal.php` to `mysite.php` or something similar. Place the file in the `webroot/` folder. The filename does not need to match the "site ID", but often it does.
3. The mapping between the "site ID" and the filename to be included is defined in the `mapping.txt` file. Add your site in the following comma-separated form: `<site ID>,<filename>`
4. If you want to link to your new site, add a link like so:

```php
<?php echo '<a href="' . get_href('mysite') . '">My Site</a>'; ?>
```

#### Optional: Add GET variables to your link
Above you saw how you can link to a site within PlanetShop.
You can easily add GET variables to your link using the `get_href` function. The following example will add the GET variable `action` with the value `delete` and an ID to your link:

```php
<?php echo '<a href="' . get_href('mysite', array('action' => 'delete', 'id' => 12)) . '">My Site</a>'; ?>
```

The result will be something like this:
```html
<a href="index.php?site=mysite&action=delete&id=12">My Site</a>
```

### Howto: Query the database
PlanetShop  uses the well-known ezSQL library to handle database queries. The supporting files can be found in `webroot/modules/db/`. ezSQL uses the "mysqli" library to connect to the database and allows the developer to quickly query a database and retrieve the results as a PHP object.

You can find the full ER model of the database in `doc/task10/eer_model.mwb` (MySQL Workbench format) or in `doc/task10/planetshop_db.pdf` (PDF).

For example, if you want to query the database and list all users with their first and last name, this can be accomplished as follows:

```php
<?php
	// Include global variable shopdb
	global $shopdb;

	// Query the database
	$users = $shopdb->get_results("SELECT first_name, last_name FROM user ORDER BY user_id DESC");

	// Loop over the result
	foreach($users as $user) {
		echo "First name: $user->first_name <br/>";
		echo "Last name: $user->last_name <br/>";
	}
?>
```

More examples can be found in the code itself or on the ezSQL site (see references below).

### Howto: Print a form

PlanetShop features an unique way to define and display forms on the site. To create a new form and include it in the site, you will need to do perform the following two steps:

* Create "form file", that contains the form definition in `webroot/modules/forms/`.
* Call the function `print_form_fields` to print the form fields. 

Note that you will need to print the `<form>` tag yourself, as this differs from form to form. Using the above function, one can generate reusable forms.

## Other references

* [Justin Vincents ezSQL library](http://justinvincent.com/ezsql)
* [FPDF library](http://www.fpdf.org)
