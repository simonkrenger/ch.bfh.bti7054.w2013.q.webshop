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

## Howto: Query the database


## Howto: TODO

## Other references


