![logo_light.png](https://bitbucket.org/repo/oR8ak9/images/2184913115-logo_light.png)

Alienore is a web application to store your bookmarks. It is designed to be multi-user, fast and user-friendly. 

Requirements
===========
1. Alienore needs **PHP 5.0** minimum and **MySQL**.
2. You also need **JSON** for PHP5, if you don't have it : 
    ``sudo apt-get install php5-json``
3. You have to add in your php.ini  : 
```
extension = mcrypt.so;
allow_url_include = on;

```

Installing
=======
1. Clone the depo to your web directory
2. Import the alienore.sql in config/sql/ into Mysql
3. Edit config/app.php ```
 //MySQL connection
    CONST BDD_USER = 'yourDatabaseUsername';
    ...
    CONST BDD_HOST = 'yourDatabaseIP';
    CONST BDD_PASSWORD = 'yourDatabaseUsernamePassword';
```
4. Go to *http://urlToAlienore* in your favorite browser and check the installation's final step : create the admin account
5. After the admin account creation, you can log to Alienore