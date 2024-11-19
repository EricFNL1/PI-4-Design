#include <WiFi.h>
#include <WebServer.h>
#include <DHT.h>
#include <ArduinoOTA.h>  // Biblioteca para OTA
#include <WiFiManager.h>

// Configurações do WiFi
const char* ssid = "SMARTGROW";
const char* password = "QWERTmorango123";

// Configurações do DHT22
#define DHTPIN 15
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// Configurações do sensor de umidade do solo
#define SOIL_MOISTURE_PIN 32

// Pinos dos relés que controlam dispositivos
#define RELAY_PIN_1 5  // Pino do relé que controla a lâmpada
#define RELAY_PIN_3 2  // Pino do relé que controla os coolers
#define RELAY_PIN_4 4  // Pino do relé que controla a bomba de água

// Cria um servidor na porta 80
WebServer server(80);

// Variáveis globais
bool isAutomaticMode = false;  // Indica se está no modo automático
unsigned long previousMillisLight = 0;
unsigned long previousMillisPump = 0;
unsigned long previousMillisCooler = 0;
bool isLightOn = false;  // Estado atual da luz

void setup() {
  delay(2000);

  Serial.begin(115200);
  dht.begin();
  pinMode(SOIL_MOISTURE_PIN, INPUT);
  pinMode(RELAY_PIN_1, OUTPUT);
  pinMode(RELAY_PIN_3, OUTPUT);
  pinMode(RELAY_PIN_4, OUTPUT);

  // Inicializa os relés como desligados
  digitalWrite(RELAY_PIN_1, HIGH);
  digitalWrite(RELAY_PIN_3, HIGH);
  digitalWrite(RELAY_PIN_4, HIGH);
  
  // Configuração do WiFiManager
  WiFiManager wifiManager;
  wifiManager.setTimeout(180);

  if (!wifiManager.autoConnect("SMARTGROW", "QWERTmorango123")) {
    Serial.println("Falha na conexão e tempo limite alcançado. Modo AP ativado!");
  }
  ArduinoOTA.begin();

  // Configuração do servidor
  server.on("/", handleRoot);
  server.on("/data", handleData);
  server.on("/toggleRelayOn", handleRelayOn);
  server.on("/toggleRelayOff", handleRelayOff);
  server.on("/activatePump", handleActivatePump);
  server.on("/toggleRelay3On", handleRelay3On);
  server.on("/toggleRelay3Off", handleRelay3Off);
  server.on("/toggleMode", handleToggleMode);  // Alternar entre manual e automático
  server.begin();
  Serial.println("Servidor iniciado");
}

void handleRoot() {
  String html = "<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">"
                "<style>body { font-family: Arial, sans-serif; background-color: #e09292; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }"
                "h2 { color: #333; font-size: 24px; }"
                "p { font-size: 18px; color: #555; }"
                "#container { background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; }"
                "#temp, #hum, #soil { font-weight: bold; font-size: 22px; color: #4CAF50; }"
                "button { margin-top: 15px; padding: 10px 20px; font-size: 16px; color: white; background-color: #c74b36; border: none; border-radius: 5px; cursor: pointer; }"
                "</style>"
                "<script>"
                "function updateData() {"
                "  var xhr = new XMLHttpRequest();"
                "  xhr.open('GET', '/data', true);"
                "  xhr.onreadystatechange = function() {"
                "    if (xhr.readyState == 4 && xhr.status == 200) {"
                "      var data = JSON.parse(xhr.responseText);"
                "      document.getElementById('temp').innerHTML = data.temperature + ' &deg;C';"
                "      document.getElementById('hum').innerHTML = data.humidity + ' %';"
                "      document.getElementById('soil').innerHTML = data.soil_moisture + ' %';"
                "    }"
                "  };"
                "  xhr.send();"
                "}"
                "setInterval(updateData, 2000);"
                "function sendCommand(endpoint) {"
                "  var xhr = new XMLHttpRequest();"
                "  xhr.open('GET', endpoint, true);"
                "  xhr.send();"
                "}"
                "function toggleMode() {"
                "  var xhr = new XMLHttpRequest();"
                "  xhr.open('GET', '/toggleMode', true);"
                "  xhr.onreadystatechange = function() {"
                "    if (xhr.readyState == 4 && xhr.status == 200) {"
                "      document.getElementById('mode').innerHTML = xhr.responseText;"
                "    }"
                "  };"
                "  xhr.send();"
                "}"
                "</script></head><body><div id='container'>"
                "<h2>Smart Grow</h2>"
                "<p>Temperatura: <span id='temp'>--</span></p>"
                "<p>Umidade: <span id='hum'>--</span></p>"
                "<p>Umidade do Solo: <span id='soil'>--</span></p>"
                "<button onclick=\"sendCommand('/toggleRelayOn')\">Ligar Iluminação</button>"
                "<button onclick=\"sendCommand('/toggleRelayOff')\">Desligar Iluminação</button>"
                "<button onclick=\"sendCommand('/activatePump')\">Ativar Bomba</button>"
                "<button onclick=\"sendCommand('/toggleRelay3On')\">Ligar Ventilação</button>"
                "<button onclick=\"sendCommand('/toggleRelay3Off')\">Desligar Ventilação</button>"
                "<p>Modo Atual: <span id='mode'>" + String(isAutomaticMode ? "Automático" : "Manual") + "</span></p>"
                "<button onclick='toggleMode()'>Alternar Modo</button>"
                "</div></body></html>";

  server.send(200, "text/html", html);
}

void handleData() {
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  int soilMoistureValue = analogRead(SOIL_MOISTURE_PIN);
  float soilMoisturePercent = map(soilMoistureValue, 1100, 2700, 100, 0);

  String json = "{\"temperature\":" + String(t) + ",\"humidity\":" + String(h) + ",\"soil_moisture\":" + String(soilMoisturePercent) + "}";
  server.send(200, "application/json", json);
}

void handleToggleMode() {
  isAutomaticMode = !isAutomaticMode;  // Alterna entre os modos
  server.send(200, "text/plain", isAutomaticMode ? "Automático" : "Manual");
}

void handleRelayOn() { digitalWrite(RELAY_PIN_1, LOW); server.send(200, "text/plain", "Luz Ligada"); }
void handleRelayOff() { digitalWrite(RELAY_PIN_1, HIGH); server.send(200, "text/plain", "Luz Desligada"); }
void handleRelay3On() { digitalWrite(RELAY_PIN_3, LOW); server.send(200, "text/plain", "Ventilação Ligada"); }
void handleRelay3Off() { digitalWrite(RELAY_PIN_3, HIGH); server.send(200, "text/plain", "Ventilação Desligada"); }
void handleActivatePump() { digitalWrite(RELAY_PIN_4, LOW); delay(1500); digitalWrite(RELAY_PIN_4, HIGH); server.send(200, "text/plain", "Bomba Ativada"); }

void loop() {
  ArduinoOTA.handle();
  server.handleClient();

  if (isAutomaticMode) {
    unsigned long currentMillis = millis();

    // Controle da luz (40s ligada, 20s desligada)
    if (currentMillis - previousMillisLight >= (isLightOn ? 40000 : 20000)) {
      isLightOn = !isLightOn;
      digitalWrite(RELAY_PIN_1, isLightOn ? LOW : HIGH);
      previousMillisLight = currentMillis;
    }

    // Controle da bomba de água (umidade abaixo de 40% por 5s)
    int soilMoistureValue = analogRead(SOIL_MOISTURE_PIN);
    float soilMoisturePercent = map(soilMoistureValue, 1100, 2700, 100, 0);
    if (soilMoisturePercent < 40 && currentMillis - previousMillisPump >= 5000) {
      digitalWrite(RELAY_PIN_4, LOW);
      delay(1500);
      digitalWrite(RELAY_PIN_4, HIGH);
      previousMillisPump = currentMillis;
    }

    // Controle dos coolers (temperatura > 28°C ou < 25°C)
    float temperature = dht.readTemperature();
    if (temperature > 28) {
      digitalWrite(RELAY_PIN_3, LOW);
      previousMillisCooler = currentMillis;
    } else if (temperature < 25 && currentMillis - previousMillisCooler >= 5000) {
      digitalWrite(RELAY_PIN_3, HIGH);
    }
  }
}
