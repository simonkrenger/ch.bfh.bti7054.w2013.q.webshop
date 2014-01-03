# PlanetShop Developer Guide

This document contains guidelines and references to working with the PlanetShop source code.

## Basic concepts

A site 

### require_ Functions
At the top of the file `index.php`, you will find function calls to functions like `require_db()` or `require_lang()`. These functions provide means to establish a consistent and properly defined variable environment for the application. This means that after calling `require_db()` for example, all variables and environment settings are guaranteed to be set correctly (such as `$shopdb`).




## Function Reference

The files of PlanetShop define many useful PHP functions. Most of them are only used to provide core functionality, however there are some more complicated functions available. This section lists most of the core functions. In addition to this information, all functions are thoroughly documented in PHP.

## Global variables

The following global variables are available after calling the appropriate `require_` function:


Variable name | `require_` function | Description
--- | --- | ---
`$language` | require_lang | Represents the language set for the application.
`$shopdb` | require_db | ez_sql database object to handle database queries.
`$shopuser` | require_user | User object that is set when the user is logged in.
TODO | TODO | TODO


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


## Howto: Print a form

## Other references


