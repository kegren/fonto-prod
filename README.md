#Fonto PHP Framework

A small example application built with Fonto.

Installation
------------

1. Clone this repo to your local machine or server. Make sure your directory
structure is correct.

2. Download and run composer to install all the needed dependencies. You can find
composer at: http://getcomposer.org/

3. If your environment supports APC caching, change the CACHE constant
to true in app/bootstrap.php. Its highly recommended to use caching with
doctrine.

4. Make sure the app/src/Demo/Storage directory is writable. This is the place
where Fonto stores both session files and doctrine proxies.

5. When you first enter the homepage you will recive instructions for installation
of database tables. You only need to install them if you are planning to use
the demo application.

6. You can now start using Fonto as a CMS if you like. Enjoy.

Note
----

You might need to use RewriteBase in the .htaccess file.