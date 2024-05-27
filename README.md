# Setup in der Klasse - Schritt für Schritt

## Frontend

Öffne ein Terminal-Fenster 
gib ein
```
cd labankbackend
```
dann
```
git pull 
```
Gehe nun in deinen Dateien zu C:Benutzer/ekim/labankbackend und drücke doppelt auf die index.html Datei.
Sie öffnet sich im Browser

## Datenbank

1. Öffne XAMPP.
2. Drücke den ```Start``` Button bei Apache und MySQL.
3. Beide Felder sollten danach grün werden. 

4. Öffne das Terminal in Windows. 
gib zweimal ein
```
cd ..
```
5. Danach
```powershell
cd \xampp\mysql\bin
```
6. Starte die Anwendung mit 
```powershell
./mysql.exe -u root -p
```
7. Gib nun dein root-Passwort ein. 
8. 
```
your-root-password
```
9. 
```
USE db_arduino
```
10. 
```
SELECT * from tbl_card;
```
Es erscheinen alle Einträge in der Datenbank. 

***

## Sensor Setup

Stecke den Sensor an deinen Laptop an und öffne Arduino. 
Kopiere kombi.ino in das Arduino-file (wahrscheinlihc ist aber einfach noch das vom letzen Mal da) - dann nichts kopieren 
sondern weitermachen
WLAN NAme und PAsswort der Schule eintragen

DANN Computer IP 
dazu: 
Windowstaste + R 
ncpa.cpl
danach das Modul auswählen, welches das WLAN bereitstellt (schulwlan)
dort auf details klicken 
IP Adresse ist der fünfter Eintrag von oben
merken und im Arduino Code eintragen (nähe Zeile 21 und 22 vom LWAN PAsswort steht das)

dann oben code compilierne und updaten (haken und pfeil taste) 
ARduino blinkt 
wenn upload fertig dann
unter Tools Seria Monitor auswählen und Testkarte vor Sensor halten 

Kommt successfull connected und die IP ? 
top 

Schau einmal in die Datenbank ob der Code der Karte da ist 


jetzt bist du ready to go 






Windowstaste + R 
ncpa.cpl
danach das Modul auswählen, welches das WLAN bereitstellt





