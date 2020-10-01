GTU-Student-Attendance-System
=============================

An online student attendance management system for recording the student attendance over the web and generating various reports from it. Intended and designed considering the operation of GTU (Gujarat Technological University) it can be used by other Institutions as well if it fits their needs (feel free to suggest changes). We always aim to make this more and more flexible so that it can be used by any Institution. Developed by two students of SAL Institute of Techonology &amp; Engineering Research as part of their final year academic project (2013-2014) which falls under GTU.

Installation Intstructions
--------------------------
1. Install Apache 2.2 or above, PHP 5.4 or above and MySQL 5.5 or above. (Or you can also use wamp server or xampp server). Skip this if you already have it setup.
2. Download the source code.
3. Extract the source code to a web accessible folder.
4. Create a database in MySQL (for e.g. say it "ams"). This is necessary because setup.sql file does not create a database for you.
5. Select that database and import setup.sql file from database_installation_import_files/ directory. This will create the required tables and procedures and default user accounts.
6. Go to core/config/ directory and follow instructions written in config.sample.php.
7. Go to core/config/db/ directory and follow instructions written in credentials.db.sample.php.
8. Delete or move the database_installation_import_files/ directory out of the web accessible folder.
9. Login using **username: admin** and **password: @dmin.12**

Original Authors
----------------

* Chirayu Chiripal aka [D-storm][1]
* Kunal Ahuja

Demo Server 1
-------------

* http://salam.url.ph
  * Username: admin
  * Password: @dmin.12

Demo Server 2 (OpenShift PaaS Server) [Update feature does not work]
-------------

* http://salam-dstorm.rhcloud.com
  * Username: admin
  * Password: @dmin.12

[1]: https://github.com/D-storm
thank you for supporting us
