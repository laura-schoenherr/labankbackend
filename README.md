# Setup 

Es wird ein Arduino Uno R4 Wifi als Microcontroller genutzt. Dieser ist mit einem RFID-Sensor (RFID-RC522) verbunden. Unten ist das Setup der Jumperkabel angezeigt: 

table

D9 - RST

D10 - SDA

D11 - MOSI

D12 - MISO

D13 - SCK

3.3V - 3.3V

GND - GND 

Der Microcontroller wurde ausgewählt, da er über ein Wifi-Modul verfügt und so Daten über das Internet an eine Datenbank senden kann. 

Für das weitere Setup wird ein WLAN-Name und das dazu passende PAsswort gebraucht. Dieses Wird in das kombi.ino File eingefügt. 
IN ZEile 21 und 22

```
const char ssid[] = "WIFI_NAME";  // change your network SSID (name)
const char pass[] = "WIFI_PASWWORD";   // change your network password (use for WPA, or use as key for WEP)
```

Das Eintragen wird in der Software "Arduino" vorgenommen. Link: 

NAchdem dies erfolgt ist. Mus die IP-Adresse des Computer eingetragen werden. 
Auf Windows: 
Windowstaste + R 
ncpa.cpl
danach das Modul auswählen, welches das WLAN bereitstellt 


Fürs Backend brauchne wir außerdme XAMPP um die Datenbank lokal laufen zu lassen. Es ist eine MAriaDB Datenbank. 
Dort werden eine Reihenfolge von Schritten ausgeführt, um die Datenbank mit der entsprechenden Tabelle aufzusetzen.

Runterladen [hier](https://www.apachefriends.org/index.html)

.\mysqladmin -u root password your-root-password

.\mysql.exe -u root -p

CREATE USER 'Arduino'@'localhost' IDENTIFIED BY 'ArduinoGetStarted.com';

GRANT ALL PRIVILEGES ON *.* TO 'Arduino'@'localhost' WITH GRANT OPTION;

FLUSH PRIVILEGES;

## Setup in der Klasse - Schritt für Schritt

1. Öffne XAMPP.
2. Drücke den ```Start``` Button bei Apache und MySQL.
3. Beide Felder sollten danach grün werden. 

4. Öffne das Terminal in Windows. 
5. Navigiere zum Pfad
```powershell
cd \xampp\mysql\bin
```
6. Starte die Anwendung mit 
```powershell
./mysql.exe -u root -p
```
7. Gib nun dein root-Passwort ein. 
8. 






Windowstaste + R 
ncpa.cpl
danach das Modul auswählen, welches das WLAN bereitstellt





