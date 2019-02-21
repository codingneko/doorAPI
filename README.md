[![forthebadge](https://forthebadge.com/images/badges/powered-by-electricity.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/uses-html.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/built-with-love.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/you-didnt-ask-for-this.svg)](https://forthebadge.com)

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

## Sensor deployment
1. Open the sketch in IOTSensorFirmware/ESP8266 with the Arduino IDE
2. If you havent already, add the ESP8266 to the boards manager by clicking on "File" -> "Preferences" and on the settings tab, add "http://arduino.esp8266.com/versions/2.3.0/package_esp8266com_index.json" to the begining of the "Additional Boards Manager URLs text field" followed by a comma if there are any other links already in there.
3. Go to "Tools" -> "Board" and select NODE MCU 1.0 (ESP-12E Module)
4. Select the COM port corresponding to your ESP8266 under "Tools" -> "Port"
5. Edit the "ssid" and "password" constants (line 4 and 5) with your WiFi credentials.
6. Flash the firmware to the board.
7. Solder a Magnetic Hall sensor to the D2 pin on your ESP8266 (and ground and 3.3V obviously)
8. If you pull a magnet close to the hall sensor you should see the built-in LED blink "success" in morse.
9. Stick the magnet to your door and the sensor to your door frame.


## Very basic state of development
The API is currently in a very basic state of development, here are some TODOs:
- implement a proper authentication method
- improve security
- fix possible SQL injection problems (maybe?)
- implement user system (idk about this one chief)
