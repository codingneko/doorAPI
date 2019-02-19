# doorAPI
Door API is a GET API designed to log door history (open or close), it was originally meant to only work with one door, but I've decided to make it multi-door and to release the code.

## Door API Documentation
http://codingneko.com/sensors/door/beta

## Own server deployment instructions
#### Things you will need
- a working MySQL server
- a web server with PHP 7.0+ installed
- (Optional) PHPMyAdmin
#### What you'll need to do
1. Create a database and give it a name
2. create a globals.php
3. add a "username" global with your SQL username
4. add a "password" global with your SQL password
5. add a "database" global with your SQL database name
6. add a "server" global with your SQL server IP / Domain Name
7. run the SQL.sql file as SQL on your database (I haven't had time to test it actually)
8. create a new door by going to http://yourserver.whatever/api.php?action=addDoor&password=yourSQLpassword&name=aNameForYourDoor
9. if you're getting a JSON formatted response with an object containing a result property set to true, you're in business.

## Very basic state of development
The API is currently in a very basic state of development, here are some TODOs:
- implement a proper authentication method
- improve security
- fix possible SQL injection problems (maybe?)
- implement user system (idk about this one chief)
