Alienore is a web application to store your bookmarks. It is designed to be multi-user, fast and user-friendly. 

Requirements
===========
Alienore needs **PHP 5.0** minimum and **MySQL**.

Installing
=======

1. Clone the depo to your web directory
2. Import the alienore.sql in mockup/ into Mysql
3. Edit config/app.php
```
//MySQL connection
    CONST BDD_USER = 'yourDatabaseUsername';
    ...
    CONST BDD_HOST = 'yourDatabaseIP';
    CONST BDD_PASSWORD = 'yourDatabaseUsernamePassword';
```
4. Go to *http://urlToAlienore* in your favorite browser and check the installation's final step : create the admin account
5. After the admin account creation, you can log to Alienore