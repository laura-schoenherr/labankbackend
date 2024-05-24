#include <MFRC522.h>
#include <MFRC522Extended.h>
#include <deprecated.h>
#include <require_cpp11.h>

#include <MFRC522.h>
#include <MFRC522Extended.h>
#include <deprecated.h>
#include <require_cpp11.h>

#include <SPI.h>
#include <MFRC522.h>
#include <WiFiS3.h>

#define SS_PIN 10
#define RST_PIN 9
MFRC522 mfrc522(SS_PIN, RST_PIN);

byte nuidPICC[4];

const char ssid[] = "WIFI_NAME";  // change your network SSID (name)
const char pass[] = "WIFI_PASWWORD";   // change your network password (use for WPA, or use as key for WEP)

WiFiClient client;
int status = WL_IDLE_STATUS;

int HTTP_PORT = 80;
String HTTP_METHOD = "POST";
char HOST_NAME[] = "192.168.43.139";  // change to your PC's IP address
String PATH_NAME = "/insert_card.php";


void setup() {
  Serial.begin(9600);

  // check for the WiFi module:
  if (WiFi.status() == WL_NO_MODULE) {
    Serial.println("Communication with WiFi module failed!");
    // don't continue
    while (true)
      ;
  }

  String fv = WiFi.firmwareVersion();
  if (fv < WIFI_FIRMWARE_LATEST_VERSION) {
    Serial.println("Please upgrade the firmware");
  }

  // attempt to connect to WiFi network:
  while (status != WL_CONNECTED) {
    Serial.print("Attempting to connect to SSID: ");
    Serial.println(ssid);
    // Connect to WPA/WPA2 network. Change this line if using open or WEP network:
    status = WiFi.begin(ssid, pass);

    // wait 10 seconds for connection:
    delay(10000);
  }

  // print your board's IP address:
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  SPI.begin();
  mfrc522.PCD_Init();
}

void loop() {
if (!mfrc522.PICC_IsNewCardPresent())
    return;

  if (!mfrc522.PICC_ReadCardSerial())
    return;

  
  String uid = getCardId();
  uid.replace(" ", "");
  String queryString = "?card='" + String(uid) + "'";
  Serial.println("RFID:" + uid);
  Serial.println(queryString);
  // do something with uid!
  for (byte i = 0; i < 4; i++) {
    nuidPICC[i] =  mfrc522.uid.uidByte[i];
  }


  // connect to web server on port 80:
  if (client.connect(HOST_NAME, HTTP_PORT)) {
    // if connected:
    Serial.println("Connected to server");
    // make a HTTP request:
    // send HTTP header
    client.println(HTTP_METHOD + " " + PATH_NAME + queryString + " HTTP/1.1");
    Serial.println(HTTP_METHOD + " " + PATH_NAME + queryString + " HTTP/1.1");
    client.println("Host: " + String(HOST_NAME));
    client.println("Connection: close");
    client.println();  // end HTTP header

    while (client.connected()) {
      if (client.available()) {
        // read an incoming byte from the server and print it to serial monitor:
        char c = client.read();
        Serial.print(c);
      }
    }

    // the server's disconnected, stop the client:
    //client.stop();
    //Serial.println();
    //Serial.println("disconnected");
  } else {  // if not connected:
    Serial.println("connection failed");
  }

  mfrc522.PICC_HaltA();
  // delay(1000);
}

  String getCardId() {
    String uid = "";
    for (byte i = 0; i < mfrc522.uid.size; i++)
    {
      uid.concat(String(mfrc522.uid.uidByte[i], HEX));
      if (i < mfrc522.uid.size - 1)
        uid.concat(" ");
    }
    uid.toUpperCase();
    return uid;
  }
