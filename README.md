# PlanetShop

"PlanetShop" is a project at the Bern University of Applied Sciences that aims to create a webshop based on PHP/MySQL.

## Installation

* Place the content of "Webshop/webroot" on a web server of choice (must be PHP-enabled)
* To configure the database follow these steps:
    * Issue a `CREATE USER planetshop_user IDENTIFIED BY mypassword` statement to create your database user
    * Make sure no database named "planetshop\_db" exists in your MySQL database
    * Execute the database setup script `planetshop_db.sql` provided in "doc/task10/"
* Copy "config-sample.php" to "config.php" and enter your database settings
* Enjoy!

## Contributors

Franziska Corradi, Simon Krenger
