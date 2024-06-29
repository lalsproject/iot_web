#include <Arduino.h>

#include <LiquidCrystal_I2C.h>

LiquidCrystal_I2C lcd(0x27, 16, 2);#include <DHT.h>

#include <ArduinoJson.h>

#include <EEPROM.h>

#ifdef ESP32#include <WiFi.h>

#include <HTTPClient.h>

#include <AsyncTCP.h>

#elif defined(ESP8266)#include <ESP8266WiFi.h>

#include <ESP8266HTTPClient.h>

#include <ESPAsyncTCP.h>

#endif#include <ESPAsyncWebServer.h>

int port_dht11 = 23;
DHT dht11(port_dht11, DHT11);
int port_buzzer = 15;
int relay_1 = 27;
int relay_2 = 14;
extern
const char * default_nama_ssid = "wifi-iot";
extern
const char * default_password = "password-iot";
extern
const char * default_server = "http://labrobotika.go-web.my.id/server.php?apikey=";
extern
const char * default_apikey = "0e95eb05b3ae5b7ebf0b4e91b43e64bb";
String nama_ssid;
String password;
String server_url;
String apikey;
AsyncWebServer server(80);
int reset_default = 0;

void lcd_i2c(String text = "", int kolom = 0, int baris = 0) {
  byte bar[8] = {
    B11111,
    B11111,
    B11111,
    B11111,
    B11111,
    B11111,
    B11111,
  };
  if (text == "") {
    lcd.begin(); //jika error pakai lcd.init();
    lcd.backlight();
    lcd.createChar(0, bar);
    lcd.setCursor(0, 0);
    lcd.print("Loading..");
    for (int i = 0; i < 16; i++) {
      lcd.setCursor(i, 1);
      lcd.write(byte(0));
      delay(100);
    }
    delay(50);
    lcd.clear();
  } else {
    lcd.setCursor(kolom, baris);
    lcd.print(text + "                ");
  }
}

float baca_suhu_dht11() {
  float temperature = dht11.readTemperature();
  if (isnan(temperature)) {
    return 0.0;
  }
  return temperature;
}

float baca_kelembaban_dht11() {
  float humidity = dht11.readHumidity();
  if (isnan(humidity)) {
    return 0.0;
  }
  return humidity;
}
void buzzer_on() {
  digitalWrite(port_buzzer, HIGH);
}
void buzzer_off() {
  digitalWrite(port_buzzer, LOW);
}
void buzzer_bip() {
  digitalWrite(port_buzzer, HIGH);
  delay(500);
  digitalWrite(port_buzzer, LOW);
}
void buzzer_bipbip() {
  digitalWrite(port_buzzer, HIGH);
  delay(500);
  digitalWrite(port_buzzer, LOW);
  delay(500);
  digitalWrite(port_buzzer, HIGH);
  delay(500);
  digitalWrite(port_buzzer, LOW);
  delay(500);
}
void relay_1_on() {
  //Aktif low, dibalik jadi High jika terbalik
  digitalWrite(relay_1, LOW);
}
void relay_1_off() {
  digitalWrite(relay_1, HIGH);
}
void relay_2_on() {
  //Aktif low, dibalik jadi High jika terbalik
  digitalWrite(relay_2, LOW);
}
void relay_2_off() {
  digitalWrite(relay_2, HIGH);
}
void debug(String message) {
  Serial.println(message);
  //tampilkan jika menggunakan lcd
  lcd.clear();
  lcd_i2c(message);
}
void writeStringToEEPROM(int address,
  const String & str) {
  int len = str.length();
  EEPROM.write(address, len);
  for (int i = 0; i < len; i++) {
    EEPROM.write(address + 1 + i, str[i]);
  }
}
String readStringFromEEPROM(int address) {
  int len = EEPROM.read(address);
  char data[len + 1];
  for (int i = 0; i < len; i++) {
    data[i] = EEPROM.read(address + 1 + i);
  }
  data[len] = '\0';
  return String(data);
}
void saveCredentialsToEEPROM() {
  EEPROM.begin(512);
  writeStringToEEPROM(0, nama_ssid);
  writeStringToEEPROM(64, password);
  writeStringToEEPROM(128, server_url);
  writeStringToEEPROM(192, apikey);
  EEPROM.commit();
  debug("Konfigurasi yang disimpan ke EEPROM:");
  debug("nama_ssid: " + nama_ssid);
  debug("Password: " + password);
  debug("Server URL: " + server_url);
  debug("API Key: " + apikey);
}
void loadCredentialsFromEEPROM() {

  EEPROM.begin(512);
  nama_ssid = readStringFromEEPROM(0);
  password = readStringFromEEPROM(64);
  server_url = readStringFromEEPROM(128);
  apikey = readStringFromEEPROM(192);
  if (nama_ssid.length() == 0) {
    nama_ssid = default_nama_ssid;
    debug("SSID Default.");
  } else {
    debug("SSID EEPROM.");
  }
  if (password.length() == 0) password = default_password;
  if (server_url.length() == 0) server_url = default_server;
  if (apikey.length() == 0) apikey = default_apikey;

  Serial.println("SSID LENGTH : " + (String) nama_ssid.length());
  if (nama_ssid.length() > 250 || reset_default == 1) {
    debug("NOVALID:" + nama_ssid);
    delay(3000);
    debug("RESET DEFAULT...");
    nama_ssid = default_nama_ssid;
    password = default_password;
    server_url = default_server;
    apikey = default_apikey;
    saveCredentialsToEEPROM();
    delay(1000);
    debug("ESP RESTART...");
    delay(1000);
    ESP.restart();
  } else {
    debug("SSID :" + nama_ssid);
    delay(1000);
    debug("PASS :" + password);
    delay(1000);
    debug("URL :" + server_url);
    delay(1000);
    debug("API :" + apikey);
    delay(1000);
  }
}
void setupWiFi() {
  WiFi.begin(nama_ssid.c_str(), password.c_str());
  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts < 20) {

    delay(2000);
    debug("Connect Wi-Fi (" + (String) attempts + ")");
    attempts++;
  }
  if (WiFi.status() == WL_CONNECTED) {
    debug("Terhubung ke Wi-Fi");
    debug("ssid: " + String(WiFi.SSID()));
    debug("IP: " + WiFi.localIP().toString());
    delay(1000);
    debug("System Ready");
    proses_iot("");

  } else {
    //lcd.clear();

    debug("Gagal terhubung");
    delay(2000);
    debug("Beralih mode AP");
    delay(2000);

    debug("Gagal terhubung..");
    WiFi.softAP("wifi-ESP");
    debug("AP: Wifi-ESP");
    delay(5000);
    debug("IP:" + WiFi.softAPIP().toString());

    delay(2000);
    server.on("/", HTTP_GET, [](AsyncWebServerRequest * request) {
        String nama_ssidValue = (nama_ssid.length() > 0) ? nama_ssid : default_nama_ssid;
        String passwordValue = (password.length() > 0) ? password : default_password;
        String serverValue = (server_url.length() > 0) ? server_url : default_server;
        String apiKeyValue = (apikey.length() > 0) ? apikey : default_apikey;
        String htmlContent = R "( <
          !DOCTYPE html >
          <
          html >
          <
          head >
          <
          title > ESP32 WiFi Configuration < /title> <
          style >
          body {
            font - family: Arial, sans - serif;
            margin: 20 px;
          }
        input[type = "text"],
          input[type = "password"] {
            width: 100 % ;
            padding: 10 px;
            margin: 5 px 0;
            display: inline - block;
            border: 1 px solid #ccc;
            border - radius: 4 px;
            box - sizing: border - box;
          }

        input[type = "submit"]: hover {
            background - color: #45a049;

            }

            .container {

              padding: 20px;

              border-radius: 5px;

              background-color: # f2f2f2;
          } <
          /style> <
          /head> <
          body >
          <
          div style = "max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;" >
          <
          div class = "container" >
          <
          h2 > ESP WiFi Configuration < /h2> <
          form action = "/save"
        method = "post" >
          <
          label
        for = "nama_ssid" > WiFi SSID: < /label> <
          input type = "text"
        id = "nama_ssid"
        name = "nama_ssid"
        value = ")" + nama_ssidValue + R "("
        required > < br >
          <
          label
        for = "password" > WiFi Password: < /label> <
          input type = "text"
        id = "password"
        name = "password"
        value = ")" + passwordValue + R "("
        required > < br >
          <
          label
        for = "server" > Server URL: < /label> <
          input type = "text"
        id = "server"
        name = "server"
        value = ")" + serverValue + R "("
        required > < br >
          <
          label
        for = "apikey" > API Key: < /label> <
          input type = "text"
        id = "apikey"
        name = "apikey"
        value = ")" + apiKeyValue + R "("
        required > < br >
          <
          input style = " width: 100%;color: #fff; background-color: green; padding: 10px 20px; text-decoration: none; border-radius: 4px;"
        type = "submit"
        value = "SAVE CONFIGURATION" >
          <
          /form> <
          br >
          <
          br >
          Kembali Ke pengaturan Awal:
          <
          a href = "/reset"
        style = "color: #fff; background-color: red; padding: 10px 20px; text-decoration: none; border-radius: 4px;" > RESET DEFAULT < /a> <
          /div> <
          /div> <
          /body> <
          /html>
      )
      ";
      request -> send(200, "text/html", htmlContent);
    });
  server.on("/save", HTTP_POST, [](AsyncWebServerRequest * request) {
    if (request -> args() > 0) { // Pastikan ada argumen yang disampaikan
      for (uint8_t i = 0; i < request -> args(); i++) {
        if (request -> argName(i) == "nama_ssid") {
          nama_ssid = request -> arg(i);
        } else if (request -> argName(i) == "password") {
          password = request -> arg(i);
        } else if (request -> argName(i) == "server") {
          server_url = request -> arg(i);
        } else if (request -> argName(i) == "apikey") {
          apikey = request -> arg(i);
        }
      }
      saveCredentialsToEEPROM(); // Simpan konfigurasi ke EEPROM
      request -> send(200, "text/html", R "( <
        div style = "max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;" >
        <
        h2 style = "color: #4CAF50;" > Konfigurasi Berhasil Disimpan < /h2> <
        p > < br > Klik tombol dibawah ini untuk restart esp < br > < br > < br > < a href = "/restart"
        style = "color: #fff; background-color: #4CAF50; padding: 10px 20px; text-decoration: none; border-radius: 4px;" > RESTART ESP < /a></p >
        <
        /div> <
        /body>
      )
      ");
    } else {
      request -> send(400, "text/html", "Bad Request: Tidak ada data yang disampaikan.");
    }
  });
  server.on("/reset", HTTP_GET, [](AsyncWebServerRequest * request) {

    nama_ssid = default_nama_ssid;
    password = default_password;
    server_url = default_server;
    apikey = default_apikey;
    saveCredentialsToEEPROM();
    request -> send(200, "text/html", R "( <
      div style = "max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;" >
      <
      h2 style = "color: RED;" > Konfigurasi Berhasil Di Reset < /h2> <
      p > < br > Klik tombol dibawah ini untuk restart esp < br > < br > < br > < a href = "/restart"
      style = "color: #fff; background-color: red; padding: 10px 20px; text-decoration: none; border-radius: 4px;" > RESTART ESP < /a></p >
      <
      /div>
    )
    ");

  });
  server.on("/restart", HTTP_GET, [](AsyncWebServerRequest * request) {

    request -> send(200, "text/html", R "( <
      head >
      <
      meta http - equiv = "refresh"
      content = "5;url=/" >
      <
      /head> <
      body >
      <
      div style = "max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9;" >
      <
      p > < br > ESP Restart... < br > < br > < /p> <
      /div> <
      /body>
    )
    ");

    delay(1000); // Tambahkan jeda sebelum merestart
    ESP.restart(); // Restart ESP
    request -> redirect("/");
  });
}
server.begin();
}

int looping_iot = 0;
int out_1 = 0;
int out_2 = 0;
int out_3 = 0;
int out_4 = 0;
int out_5 = 0;
int out_6 = 0;
int out_7 = 0;
int out_8 = 0;
int out_9 = 0;
int out_10 = 0;

int treshold = 35;
int saklar = 1;
int relay1 = 0;
int relay2 = 0;

void proses_iot(String nilai) {
  if (WiFi.status() != WL_CONNECTED) return;

  WiFiClient client;
  HTTPClient http;
  String url = server_url + apikey + nilai; // Menggunakan server_url
  url.replace(" ", "%20");
  Serial.println("Request URL: " + url);
  http.begin(client, url);
  int httpResponseCode = http.GET();
  if (httpResponseCode == HTTP_CODE_OK) {
    const size_t capacity = JSON_OBJECT_SIZE(1024);
    DynamicJsonDocument jsonDoc(capacity);
    String jsonResponse = http.getString();
    DeserializationError error = deserializeJson(jsonDoc, jsonResponse);
    if (error) {
      Serial.println("Error parsing JSON: " + String(error.c_str()));
      return;
    }
    for (int i = 1; i <= 10; i++) {
      String out = jsonDoc["out_" + String(i)].as < String > ();
      Serial.println("out_" + String(i) + ": " + out);
    }
    out_1 = jsonDoc["out_1"].as < int > ();
    out_2 = jsonDoc["out_2"].as < int > ();
    out_3 = jsonDoc["out_3"].as < int > ();
    out_4 = jsonDoc["out_4"].as < int > ();
    out_5 = jsonDoc["out_5"].as < int > ();
    out_6 = jsonDoc["out_6"].as < int > ();
    out_7 = jsonDoc["out_7"].as < int > ();
    out_8 = jsonDoc["out_8"].as < int > ();
    out_9 = jsonDoc["out_9"].as < int > ();
    out_10 = jsonDoc["out_10"].as < int > ();

    treshold = out_1;
    saklar = out_2;
    relay1 = out_3;
    relay2 = out_4;
  } else {
    Serial.println("Error Code: " + String(httpResponseCode));
  }
  http.end();
}

int kipas_darurat = 0;
void setup() {
  Serial.begin(9600);
  lcd_i2c();
  dht11.begin();
  pinMode(port_buzzer, OUTPUT);
  buzzer_bipbip();
  pinMode(relay_1, OUTPUT);
  relay_1_off();
  pinMode(relay_2, OUTPUT);
  relay_2_off();
  EEPROM.begin(512);
  //BERI NILAI 1 JIKA MAU DIRESET (PERTAMA UPLOAD WAJIB RESET)
  reset_default = 0;
  loadCredentialsFromEEPROM();
  setupWiFi();

}

int deteksi_treshold = 0;
void loop() {

  if (saklar == 1) {
    //lcd_i2c("System Ready");

    float suhu_dht11 = baca_suhu_dht11();
    Serial.println("dht11 suhu: " + (String) suhu_dht11);
    float kelembaban_dht11 = baca_kelembaban_dht11();
    Serial.println("dht11  Kelembaban : " + (String) kelembaban_dht11);

    lcd_i2c("S:" + (String) suhu_dht11 + ", K:" + (String) kelembaban_dht11);
    lcd_i2c("      ", 0, 1);

    if (relay1 == 1) {
      relay_1_on();
    } else {
      relay_1_off();
    }

    if (suhu_dht11 > treshold) {
      if (deteksi_treshold == 0) {
        deteksi_treshold = 1;
        proses_iot("&suhu=" + (String) suhu_dht11 + "&kelembaban=" + (String) kelembaban_dht11);
        looping_iot = 0;
      }
      kipas_darurat = 1;
      buzzer_on();
      Serial.println("buzzer_on");
    } else {
      kipas_darurat = 0;
      deteksi_treshold = 0;
      buzzer_off();
      Serial.println("buzzer_off");
    }

    if (kipas_darurat == 1) {
      relay_2_on();
    } else {

      if (relay2 == 1) {
        relay_2_on();
      } else {
        relay_2_off();
      }

    }

    if (looping_iot > 10) {
      proses_iot("&suhu=" + (String) suhu_dht11 + "&kelembaban=" + (String) kelembaban_dht11);
      looping_iot = 0;
    } else {
      looping_iot = looping_iot + 1;
      Serial.println("Looping IOT : " + (String) looping_iot);
    }
    delay(500);
  } else {
    lcd_i2c("System OFF");
    lcd_i2c("          ", 0, 1);
    relay_1_off();
    relay_2_off();

    if (looping_iot > 10) {
      proses_iot("");
      looping_iot = 0;
    } else {
      looping_iot = looping_iot + 1;
      Serial.println("Looping IOT : " + (String) looping_iot);
    }

  }

}