

#ifndef __CC3200R1M1RGC__
#endif
#include <WiFi.h>
char ssid[] = "cc3200";
char password[] = "hello123";
IPAddress server(192,168,43,198); 
WiFiClient client;
String string1,string2,string3,string4,string5,string6,string7,string8,string9,stringThree;
void setup() {
  Serial.begin(115200);
  Serial.print("Attempting to connect to Network named: ");
  Serial.println(ssid); 
  WiFi.begin(ssid, password);
  while ( WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(300); 
  }  
  Serial.println("\nYou're connected to the network");
  Serial.println("Waiting for an ip address");
  while (WiFi.localIP() == INADDR_NONE) {
    Serial.print(".");
    delay(300);
  }

  Serial.println("\nIP Address obtained");
  printWifiStatus();

  string1 = String("GET /GHpowermon/action.php/?cur=");
  string2 = String("78");
  string3 = String("&vol=");
  string4 = String("88");
  string5 = String("&fre=");
  string6 = String("98");
  string7 = String("&pha=");
  string8 = String("58");
  string9 = String(" HTTP/1.1");
  stringThree = String();
  stringThree=string1+string2+string3+string4+string5+string6+string7+string8+string9;
 
  Serial.println("\nStarting connection to server...");
  // if you get a connection, report back via serial:
  if (client.connect(server, 80)) {
    Serial.println("connected to server");
    // Make a HTTP request:
   Serial.println(stringThree);
    client.println(stringThree);
    client.println("Host:192.168.43.198");
    client.println("Connection: close");
    client.println();
  }
  
 
}

void loop() {
  // if there are incoming bytes available
  // from the server, read them and print them:
  while (client.available())
  {
    char c = client.read();
    Serial.write(c);
  }

  // if the server's disconnected, stop the client:
  if (!client.connected()){
    Serial.println(stringThree);
    Serial.println("disconnecting from server.");
    client.stop();

    // do nothing forevermore:
    while (true);
  }
}


void printWifiStatus() {
  // print the SSID of the network you're attached to:
  Serial.print("SSID: ");
  Serial.println(WiFi.SSID());

  // print your WiFi shield's IP address:
  IPAddress ip = WiFi.localIP();
  Serial.print("IP Address: ");
  Serial.println(ip);

  // print the received signal strength:
  long rssi = WiFi.RSSI();
  Serial.print("signal strength (RSSI):");
  Serial.print(rssi);
  Serial.println(" dBm");
}





