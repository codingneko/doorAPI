#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "yourwifikey";
const char* password = "yourwifipassword";
#define HALL_SENSOR 4
#define BUILTIN_LED 2

bool door = true;

void setup() {
  //connect to wifi
  WiFi.begin(ssid, password);
  
  //set the hall sensor and builtin LED pins
  pinMode(HALL_SENSOR, INPUT);
  pinMode(BUILTIN_LED, OUTPUT);
  
  //dump information on the serial monitor while connecting to wifi
  Serial.begin(9600);
  delay(1000);
  Serial.println();
  Serial.print("Connecting to " + (String)ssid + " with password " + (String)password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("connected");
  
  //turn off the built-in LED
  digitalWrite(BUILTIN_LED, HIGH);
}

void loop() {
  //wait for wifi connection
  if(WiFi.status() == WL_CONNECTED){
    //if the door's status has changed send the registry to the server
    if(digitalRead(HALL_SENSOR) != door){
      //if sent successfully say "success" and if it failed, say "failed" both in morse and on serial monitor
      if(sendDoorInfo(digitalRead(HALL_SENSOR))){
        ledMorse("... ..- -.-. -.-. . ... ...");
        Serial.println("Success");
      }else{
        ledMorse(". .-. --- .-.");
        Serial.println("Failed");
      };
    }
    //wait 2 and a half seconds to check the door status again
    delay(2500);
  }
}

bool sendDoorInfo(bool doorStatus){
  bool result = false; //result variable initialised to false.
  HTTPClient http; //declare HTTP object

  String statusString = "true";

  if(doorStatus){
    statusString = "false";
  }

  //build URL with doorStatus data.    
  String url = "http://codingneko.com/sensors/door/beta/api.php";
  url += "?action=add";
  url += "&doorId=1";
  url += "&status=" + statusString;
  
  http.begin(url); //begin request
  int response = http.GET(); //send request

  //check if the request was successful.
  if(response == 200){
    result = true;
  }else{
    Serial.println(response);
  }

  //finish connection.
  http.end();

  door = doorStatus;
  return result;
}

void ledMorse(String text){
  int morseEntity = 100;
  //for each character
  for(int i = 0; i < text.length(); i++){
    char current = text.charAt(i);
    //check wether it's a space, a word space, a dit or a dah and blink acordingly
    switch(current) {
      case '-':
        digitalWrite(BUILTIN_LED, LOW);
        delay(morseEntity*3);
        digitalWrite(BUILTIN_LED, HIGH);
        break;
      case '.':
        digitalWrite(BUILTIN_LED, LOW);
        delay(morseEntity);
        digitalWrite(BUILTIN_LED, HIGH);
        break;
      case ' ':
        delay(morseEntity*3);
        break;
      case '/':
        delay(morseEntity*7);
        break;
    }
    //wait a morse entity to being the next character
    delay(morseEntity);
  }
  //turn off the LED (probably not necessary but just in case)
  digitalWrite(BUILTIN_LED, HIGH);
}

bool getStatus() {
  return !digitalRead(HALL_SENSOR);
}
