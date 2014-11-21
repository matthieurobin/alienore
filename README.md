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

License
======
Alienore is distributed under GNU GENERAL PUBLIC LICENSE Version 3

Copyright (C) 2014 Matthieu Robin  
Copyright (C) 2014 Florian Berthet  
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.