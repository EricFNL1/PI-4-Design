#include <WiFi.h>
#include <WebServer.h>
#include <DHT.h>
#include <ArduinoOTA.h> // Biblioteca para OTA

// Configurações do WiFi
const char* ssid = "ESP32-Access-Point";
const char* password = "12345678E";

// Configurações do DHT22
#define DHTPIN 15
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

// Configurações do sensor de umidade do solo
#define SOIL_MOISTURE_PIN 32

// Pinos dos relés que controlam dispositivos
#define RELAY_PIN 5       // Pino do relé que controla a lâmpada ou outro dispositivo
#define PUMP_RELAY_PIN 4  // Pino do relé que controla a bomba de água
#define RELAY_PIN_3 2     // Define o pino 2 para o relé da porta 3 (ventilação)

// Cria um servidor na porta 80
WebServer server(80);

void setup() {
    delay(1000); // Delay para estabilização após power-up
    
    Serial.begin(115200);
    Serial.println("Iniciando sensores e configurando pinos...");
    dht.begin();
    pinMode(SOIL_MOISTURE_PIN, INPUT);
    pinMode(RELAY_PIN, OUTPUT);
    pinMode(PUMP_RELAY_PIN, OUTPUT);
    pinMode(RELAY_PIN_3, OUTPUT); // Inicializa o pino do relé 3

    // Inicializa todos os relés como desligados
    digitalWrite(RELAY_PIN, HIGH); 
    digitalWrite(PUMP_RELAY_PIN, HIGH);
    digitalWrite(RELAY_PIN_3, HIGH); // Inicializa o relé 3 como desligado

    // Conexão Wi-Fi
    Serial.println("Configurando o Access Point...");
    WiFi.softAP(ssid, password);
    IPAddress IP = WiFi.softAPIP();
    Serial.print("Endereço IP do AP: ");
    Serial.println(IP);

    // Inicializa o OTA
    ArduinoOTA.begin();
    Serial.println("OTA iniciado.");

    // Configuração das rotas do servidor
    Serial.println("Configurando as rotas do servidor...");
    server.on("/", handleRoot);
    server.on("/data", handleData);
    server.on("/toggleRelayOn", handleRelayOn);
    server.on("/toggleRelayOff", handleRelayOff);
    server.on("/activatePump", handleActivatePump);
    server.on("/toggleRelay3On", handleRelay3On); // Nova rota para relé 3
    server.on("/toggleRelay3Off", handleRelay3Off); // Nova rota para relé 3
    server.begin();
    Serial.println("Servidor HTTP iniciado");
}

// Função para a página principal (HTML)
void handleRoot() {
    String html = "<!DOCTYPE html><html><head><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
    html += "<style>";
    html += "body { font-family: Arial, sans-serif; background-color: #f7f7f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }";
    html += "h2 { color: #333; font-size: 24px; }";
    html += "p { font-size: 18px; color: #555; }";
    html += "#container { background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; }";
    html += "#temp, #hum, #soil { font-weight: bold; font-size: 22px; color: #007BFF; }";
    html += "button { margin-top: 15px; padding: 10px 20px; font-size: 16px; color: white; background-color: #4CAF50; border: none; border-radius: 5px; cursor: pointer; }";
    html += "</style>";
    html += "<script>";
    html += "function updateData() {";
    html += "  var xhr = new XMLHttpRequest();";
    html += "  xhr.open('GET', '/data', true);";
    html += "  xhr.onreadystatechange = function() {";
    html += "    if (xhr.readyState == 4 && xhr.status == 200) {";
    html += "      var data = JSON.parse(xhr.responseText);";
    html += "      document.getElementById('temp').innerHTML = data.temperature + ' &deg;C';";
    html += "      document.getElementById('hum').innerHTML = data.humidity + ' %';";
    html += "      document.getElementById('soil').innerHTML = data.soil_moisture + ' %';";
    html += "    }";
    html += "  };";
    html += "  xhr.send();";
    html += "}";
    html += "setInterval(updateData, 2000);";
    html += "function toggleRelay(state) {";
    html += "  var xhr = new XMLHttpRequest();";
    html += "  xhr.open('GET', '/toggleRelay' + state, true);";
    html += "  xhr.send();";
    html += "}";
    html += "function activatePump() {";  
    html += "  var xhr = new XMLHttpRequest();";
    html += "  xhr.open('GET', '/activatePump', true);";
    html += "  xhr.send();";
    html += "}";
    html += "function toggleRelay3(state) {"; // Função para relé 3
    html += "  var xhr = new XMLHttpRequest();";
    html += "  xhr.open('GET', '/toggleRelay3' + state, true);";
    html += "  xhr.send();";
    html += "}";
    html += "</script>";
    html += "</head><body><div id='container'><h2>Estação Meteorológica e de Solo ESP32</h2><p>Temperatura: <span id='temp'>--</span></p><p>Umidade: <span id='hum'>--</span></p><p>Umidade do Solo: <span id='soil'>--</span></p>";
    html += "<button onclick='toggleRelay(\"On\")'>Ligar Relé</button>";
    html += "<button onclick='toggleRelay(\"Off\")'>Desligar Relé</button>";
    html += "<button onclick='activatePump()'>Ativar Bomba</button>";
    html += "<button onclick='toggleRelay3(\"On\")'>Ligar Ventilação</button>"; // Botão para ligar ventilação
    html += "<button onclick='toggleRelay3(\"Off\")'>Desligar Ventilação</button>"; // Botão para desligar ventilação
    html += "</div></body></html>";
    
    server.send(200, "text/html", html);
}

// Função para fornecer os dados do sensor em formato JSON
void handleData() {
    float h = dht.readHumidity();
    float t = dht.readTemperature();
    int soilMoistureValue = analogRead(SOIL_MOISTURE_PIN);
    float soilMoisturePercent = map(soilMoistureValue, 0, 4095, 100, 0);

    if (isnan(h) || isnan(t) || soilMoistureValue == -1) {
        server.send(500, "application/json", "{\"error\":\"Falha ao ler os sensores\"}");
        return;
    }

    String json = "{\"temperature\":" + String(t, 1) + ",\"humidity\":" + String(h, 1) + ",\"soil_moisture\":" + String(soilMoisturePercent) + "}";
    server.send(200, "application/json", json);
}

// Funções para controlar os relés
void handleRelayOn() {
    digitalWrite(RELAY_PIN, LOW); 
    server.send(200, "text/plain", "Relé está LIGADO");
}

void handleRelayOff() {
    digitalWrite(RELAY_PIN, HIGH);
    server.send(200, "text/plain", "Relé está DESLIGADO");
}

// Funções para controlar o relé da porta 3 (ventilação)
void handleRelay3On() {
    digitalWrite(RELAY_PIN_3, LOW); 
    server.send(200, "text/plain", "Ventilação está LIGADA");
}

void handleRelay3Off() {
    digitalWrite(RELAY_PIN_3, HIGH);
    server.send(200, "text/plain", "Ventilação está DESLIGADA");
}

// Função para ativar a bomba por 1,5 segundos
void handleActivatePump() {
    digitalWrite(PUMP_RELAY_PIN, LOW); 
    delay(1500); 
    digitalWrite(PUMP_RELAY_PIN, HIGH); 
    server.send(200, "text/plain", "Bomba ativada por 1,5 segundos");
}

void loop() {
    ArduinoOTA.handle(); // Necessário para permitir atualizações OTA
    server.handleClient();
}
