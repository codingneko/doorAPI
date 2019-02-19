#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "yourwifikey";
const char* password = "yourwifipassword";
#define HALL_SENSOR 4
#define BUILTIN_LED 2

bool door = true;

void setup() {
  WiFi.begin(ssid, password);
  pinMode(HALL_SENSOR, INPUT);
  pinMode(BUILTIN_LED, OUTPUT);
  Serial.begin(9600);
  delay(1000);
  Serial.println();
  Serial.print("Connecting to " + (String)ssid + " with password " + (String)password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("connected");
  digitalWrite(BUILTIN_LED, HIGH);
}

void loop() {
  if(WiFi.status() == WL_CONNECTED){
    
    if(digitalRead(HALL_SENSOR) != door){
      if(sendDoorInfo(digitalRead(HALL_SENSOR))){
        ledMorse("... ..- -.-. . ... ...");
        Serial.println("Success");
      }else{
        ledMorse(". .-. --- .-.");
        Serial.println("Failed");
      };
    }

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
  for(int i = 0; i < text.length(); i++){
    char current = text.charAt(i);

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

    delay(morseEntity);
  }

  digitalWrite(BUILTIN_LED, HIGH);
}

bool getStatus() {
  return !digitalRead(HALL_SENSOR);
}
