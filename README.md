# Project Euler Solver

This is a basic PHP + MySQL website that functions as a solver for a select set
of [Project Euler](https://projecteuler.net) problems, with variable input to
problem parameters.

A sample implementation is available to view at http://solver.manhinli.net.

For more information about its design and structure, please refer to the
accompanying document that should have been delivered along with this
submission.

## Installation Instructions

This project was built using the [Bitnami LAMP stack](https://bitnami.com/stack/lamp)
with PHP 5.6.20, MySQL 5.6.29 and Apache 2.4.18 running on a Debian Linux
virtual machine.

The below installation instructions were written with this baseline in mind.


### 1. Set up database
A new database must be created to hold data required for this website.

A sample SQL file is provided at the root of this repository (`data.sql`) which
holds three sample problems (#3, #5, #57).

To load this into MySQL:

1. Create a new database:<br>
    `mysql -u [MYSQL_USER] -p -e "CREATE DATABASE [DATABASE_NAME]";`
2. Load the SQL file into the database:<br>
    `mysql -u [MYSQL_USER] -p [DATABASE_NAME] < /path/to/data.sql`

You will be required to enter a valid MySQL user and password for the above
commands.


### 2. Copy code
Simply copy the entire project to the intended folder where the website shall be
hosted from.

If using a fresh Bitnami stack, you can simply clear out
`[BITNAMI_INSTALL_DIRECTORY]/apache2/htdocs` and place code in there. More
information is available on [Bitnami's website](https://wiki.bitnami.com/Infrastructure_Stacks/BitNami_AMP_Stacks#How_can_I_create_a_custom_PHP_application_to_deploy_it_in_a_sub-URI.3f).
If you do this, there is no need to perform Step 4.


### 3. Configure database connections
Open `classes/DbConnection.php` and configure the following block to match your
database configuration:

```php
class DbConnection {
    // Configuration for connections to the DB
    private static $host = "localhost";
    private static $dbname = "uq498819";    // Name of database created in Step 1
    
    private static $username = "user";
    private static $password = "password";
    
...
```

### 4. Configure web server
If Apache is not configured to expose a website at the folder hosting the
website, you will need to add/edit a configuration file to do so.

Because different installations have different configuration steps, please refer
to instructions for your system.

In general, the process for this is:

1. Creating/modifying a configuration file:
    * These are generally located at `/etc/apache2/sites-available`.
    * A basic configuration would contain something similar to the following:
    ```
    <VirtualHost *:80>
        DocumentRoot  [WEBSITE_DIRECTORY]
        ServerName  www.example.com
        
        ...
        
    </VirtualHost>
    ```
      where `[WEBSITE_DIRECTORY]` is the path to the directory with the website
      code.
      
2. Enabling a configuration file (if not already enabled):
    * It is recommended to use a symbolic link or the `a2ensite` command to link
      configuration files under `sites-available` to `sites-enabled`.

3. Restarting Apache:
    * Depending on your system, this might be done by running something similar
      to `service apache2 reload` or `/etc/init.d/apache2 restart` as a super
      user.


### 5. Testing it
Depending on how your system is configured, the server will be running at its
remote IP, configured domain or at "localhost".

Simply visit the configured website at its respective address and the Solver
should be available to use.

If there are no problems to select, make sure that there are problem entries in
the database.
