# PlanetShop Developer Guide

This document contains guidelines and references to working with the PlanetShop source code.

## Basic concepts

A site is always called through `index.php`. The `index.php` file then performs security checks and routing to the correct file using the `mapping.txt` file also found in the `webroot/` folder. A site is then build using the following process:

1. Include configuration and functions (`config.php` and `modules/functions.php`)
2. Set all global variables and correctly set the environment for the site (see below for details)
3. Include the header (`header.php`)
4. Perform routing based on `mapping.txt`
5. Include the sidebar and footer

Please note that the first two steps are always performed without printing a single line. This allows us to set the correct environment, including all `$_SESSION` variables and the like.

### Environment setup: require_ Functions
At the top of the file `index.php`, you will find function calls to functions like `require_db()` or `require_lang()`. These functions provide means to establish a consistent and properly defined variable environment for the application. This means that after calling `require_db()` for example, all variables and environment settings are guaranteed to be set correctly (such as `$shopdb`). See the global variables table below for more information.

## Function Reference

The files of PlanetShop define many useful PHP functions. Most of them are only used to provide core functionality, however there are some more complicated functions available to be used by the developer. This section lists most of the core functions. In addition to this information, all functions are thoroughly documented in PHP.


Function name | Description
--- | ---
`is_logged_in` | Function to determine if a user is logged in. Returns `TRUE` if the user is logged in.
`is_admin_user` | Function to determine if a user is an "admin user". Returns `TRUE` if the user is indeed an "admin user".
`get_href` | Function used to generate a hyperlink within the site. See below for an example
`get_safe_content_include` | Routing function used in `index.php` 
TODO | TODO

## Global variables

The following global variables are available after calling the appropriate `require_` function:


Variable name | `require_` function | Description
--- | --- | ---
`$language` | require_lang | Represents the language set for the application.
`$shopdb` | require_db | ez_sql database object to handle database queries.
`$shopuser` | require_user | User object that is set when the user is logged in.
`$_SESSION["cart"]` | require_shoppingcart | Shopping cart object

## Howto: Add a new page

Let us say we want to add a new page "My site". To add a new site, you must perform the following steps:

1. Define a "site ID" for your site. This must be a short, to-the-point variable name like `mysite`. We prefer to use one or two words, no spaces or special characters.
2. Copy `minimal.php` to `mysite.php` or something similar. Place the file in the `webroot/` folder. The filename does not need to match the "site ID", but often it does.
3. The mapping between the "site ID" and the filename to be included is defined in the `mapping.txt` file. Add your site in the following comma-separated form: `<site ID>,<filename>`
4. If you want to link to your new site, add a link like so:

```php
<?php echo '<a href="' . get_href('mysite') . '">My Site</a>'; ?>
```

### Optional: Add GET variables to your link
Above you saw how you can link to a site within PlanetShop.
You can easily add GET variables to your link using the `get_href` function. The following example will add the GET variable `action` with the value `delete` and an ID to your link:

```php
<?php echo '<a href="' . get_href('mysite', array('action' => 'delete', 'id' => 12)) . '">My Site</a>'; ?>
```

The result will be something like this:
```html
<a href="index.php?site=mysite&action=delete&id=12">My Site</a>
```

## Howto: Query the database
PlanetShop  uses the well-known ezSQL library to handle database queries. The supporting files can be found in `webroot/modules/db/`. ezSQL uses the "mysqli" library to connect to the database and allows the developer to quickly query a database and retrieve the results as a PHP object.

You can find the full ER model of the database in `doc/task10/eer_model.mwb` (MySQL Workbench format).

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

## Howto: Print a form

PlanetShop features an unique way to define and display forms on the site. To create a new form and include it in the site, you'll need to do perform the following two steps:

* Create "form file", that contains the form definition in `webroot/modules/forms/`.
* Call the function `print_form_fields` to print the form fields. 

Note that you will need to print the `<form>` tag yourself, as this differs from form to form. Using the above function, one can generate reusable forms.

## Other references

[Justin Vincents ezSQL library](http://justinvincent.com/ezsql)
[FPDF library](http://www.fpdf.org)
