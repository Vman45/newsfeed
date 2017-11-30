# newsfeed
Scrapes news feeds from different websites like BBC, Slashdot and HackerNews and merges them in a common format into a database.  This can then be easily used to display them all as one big news feed from the database.

Installation
===============

* Place project in local web directory

* navigate via your terminal to this project folder

* Use composer to update dependencies using command "composer update" 
if you don't have composer installed run 'curl -sS https://getcomposer.org/installer | php' first

* run 'bin/console server:run' to start local host

* navigate to http://127.0.0.1:8000 to run program

* change the parameters.yml file to include your database name and password

* bin/console doctrine:schema:update --force 
will create the database schema for you
=======
