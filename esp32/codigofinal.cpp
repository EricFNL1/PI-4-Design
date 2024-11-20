#include <WiFi.h>
#include <WebServer.h>
#include <DHT.h>
#include <ArduinoOTA.h> // Biblioteca para Atualizações Over-The-Air (OTA)

// Configurações do WiFi
const char* ssid = "SMARTGROW";            // Nome da rede Wi-Fi
const char* password = "QWERTmorango123";  // Senha da rede Wi-Fi

// Configurações do DHT22 (Sensor de Temperatura e Umidade)
#define DHTPIN 15         // Pino de conexão do DHT22
#define DHTTYPE DHT22     // Tipo do sensor
DHT dht(DHTPIN, DHTTYPE); // Instância do sensor DHT

// Configurações do sensor de umidade do solo
#define SOIL_MOISTURE_PIN 32 // Pino de conexão do sensor de umidade do solo

// Pinos dos relés que controlam os dispositivos
#define RELAY_PIN_1 5  // Relé da lâmpada
#define RELAY_PIN_3 2  // Relé dos coolers
#define RELAY_PIN_4 4  // Relé da bomba de água

// Configurações do servidor Web
WebServer server(80); // Inicializa o servidor na porta 80

// Variáveis globais
bool isAutomaticMode = false;    // Indica se o sistema está no modo automático
unsigned long previousMillisLight = 0;  // Controle de tempo para a luz
unsigned long previousMillisPump = 0;   // Controle de tempo para a bomba de água
unsigned long previousMillisCooler = 0; // Controle de tempo para os coolers
bool isLightOn = false; // Estado atual da luz (ligada ou desligada)

// Função de configuração inicial
void setup() {
  delay(2000); // Aguarda 2 segundos para inicialização

  // Configuração da comunicação serial
  Serial.begin(115200);

  // Inicializa o sensor DHT22
  dht.begin();

  // Configuração dos pinos
  pinMode(SOIL_MOISTURE_PIN, INPUT);  // Sensor de umidade do solo
  pinMode(RELAY_PIN_1, OUTPUT);      // Relé da lâmpada
  pinMode(RELAY_PIN_3, OUTPUT);      // Relé dos coolers
  pinMode(RELAY_PIN_4, OUTPUT);      // Relé da bomba de água

  // Desliga todos os relés na inicialização
  digitalWrite(RELAY_PIN_1, HIGH);
  digitalWrite(RELAY_PIN_3, HIGH);
  digitalWrite(RELAY_PIN_4, HIGH);

  // Configuração do Wi-Fi no modo Access Point
  WiFi.softAP(ssid, password);

  // Inicializa o recurso de atualização OTA
  ArduinoOTA.begin();

  // Configurações das rotas do servidor
  server.on("/", handleRoot);               // Página principal
  server.on("/data", handleData);           // Dados dos sensores
  server.on("/toggleRelayOn", handleRelayOn);     // Ligar luz
  server.on("/toggleRelayOff", handleRelayOff);   // Desligar luz
  server.on("/activatePump", handleActivatePump); // Ativar bomba
  server.on("/toggleRelay3On", handleRelay3On);   // Ligar ventilação
  server.on("/toggleRelay3Off", handleRelay3Off); // Desligar ventilação
  server.on("/toggleMode", handleToggleMode);     // Alternar modo manual/automático

  // Inicializa o servidor Web
  server.begin();
  Serial.println("Servidor iniciado");
}

// Função para servir a página principal
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

// Função para enviar os dados dos sensores
void handleData() {
  float h = dht.readHumidity();         // Lê a umidade
  float t = dht.readTemperature();      // Lê a temperatura
  int soilMoistureValue = analogRead(SOIL_MOISTURE_PIN); // Lê o valor do sensor de umidade do solo
  float soilMoisturePercent = map(soilMoistureValue, 1100, 2700, 100, 0); // Converte para percentual

  // Cria JSON com os dados
  String json = "{\"temperature\":" + String(t) + ",\"humidity\":" + String(h) + ",\"soil_moisture\":" + String(soilMoisturePercent) + "}";
  server.send(200, "application/json", json);
}

// Alterna entre os modos manual e automático
void handleToggleMode() {
  isAutomaticMode = !isAutomaticMode; // Alterna o estado do modo
  server.send(200, "text/plain", isAutomaticMode ? "Automático" : "Manual");
}

// Funções para controle dos relés
void handleRelayOn() { digitalWrite(RELAY_PIN_1, LOW); server.send(200, "text/plain", "Luz Ligada"); }
void handleRelayOff() { digitalWrite(RELAY_PIN_1, HIGH); server.send(200, "text/plain", "Luz Desligada"); }
void handleRelay3On() { digitalWrite(RELAY_PIN_3, LOW); server.send(200, "text/plain", "Ventilação Ligada"); }
void handleRelay3Off() { digitalWrite(RELAY_PIN_3, HIGH); server.send(200, "text/plain", "Ventilação Desligada"); }
void handleActivatePump() { digitalWrite(RELAY_PIN_4, LOW); delay(1500); digitalWrite(RELAY_PIN_4, HIGH); server.send(200, "text/plain", "Bomba Ativada"); }

// Loop principal
void loop() {
  ArduinoOTA.handle();  // Gerencia as atualizações OTA
  server.handleClient(); // Gerencia os pedidos do cliente

  // Funções do modo automático
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
