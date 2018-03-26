# Installing CodeIgniter Skeleton

The stable branch will always be the **master** branch. So you may want to download it because any other branches will simply be there for development purposes.

## Download

Head to [Github](https://github.com/bkader/skeleton/), [Gitlab](https://gitlab.com/bkader/skeleton/) or [Bitbucket](https://bitbucket.org/bkader/skeleton/) (choose the one you want), then download the **master** branch, or any available release.

## Installation

Once downloaded, unzip the package where you want to install the **Skeleton**.
Note that there are multipe folders and the structure does not have to be respected as long as you set paths to required folders.

* **src**: This folder is better kept private. It contains all core files: application, system and skeleton folders. It also contains a dump of the SQL file that we will talk about later.
* **docs**: This folder contains -obviously- the documentation. They are all markdown files, so you may want to manage to preview these files, but you can still preview them on the Github, Gitlab or Bitbucket.
* **license**: This folder contains all licenses files to almost all used external libraries.
* **public**: This is the web root folder. The public folder contains all publicly accessible files (Don't worry, themes files are protected from direct access, except for assets).
* **tests**: This folder was created for tests purposes. To be honest, I never tried **phpunit** or any other testing tools, I created this folder to respect standard projects strcutre.

Put folders wherever you want as long as -as I said- you set correct paths to them.

## Database

If you check inside the **src/mysql_dump** folder, you will see a file called **skeleton.sql**, as you can tell, this is the dump for this tool database. All you have to do is to create a database and import this file. That's all.

## Configuration

As you may probably know, Codeigniter allow separte configuration files by environement, this is why you will find three folders: **development**, **testing** and **production**. Inside each folder, you may put configuration files and they will be loaded depending on the environement you set on the **public/index.php** file at line **58**.

For your first installation, the environement will be set to **development** by default, so you may want to edit files inside this folder: **application/config/development/**.

Make sure to first, add your base URL. Let's suppose you installed on your local machine, inside a folder called **skeleton**. Go to **application/config/development/config.php** file at line **8** and add:
```php
$config['base_url'] = 'http://localhost/skeleton/public/';
```
Note that the **public/** is required unless you changed folders structure.

Once that done, you may proceed to database configuration. Go to the environement (**development** here) configuration folder and open the **database.php** file and set needed settings:
```php
'hostname'     => 'DB_HOST',	// You database server.
'username'     => 'DB_USER',	// Database username.
'password'     => 'DB_PASS',	// User password.
'database'     => 'DB_NAME',	// Database name.
```

## First Time Use

Once the configuration done, you may head to your installation URL and create a new account. It will be set to **regular** by default so you may want to head to your database and change it to **administrator**. You may use PhpMyAdmin or Navicat or any tool you have.
Go on your database, entities table and locate your account. Change the **subtype** from **regular** to **administrator** then save. Voilà! You have access to the dashboard.

The step of creating the first user and make it an admin will be fixed soon. Whether by implementing an installer for the application OR creating a dummy first admin user.
