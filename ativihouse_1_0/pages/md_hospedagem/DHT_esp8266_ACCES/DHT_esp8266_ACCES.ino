// no olvides suscribirte !!!!!!!!
// https://www.youtube.com/channel/UCKD9PvMAW0nYi681AZbSZSQ
////https://www.youtube.com/watch?v=hvveBxxdx0Q
// Librerias conexion Wifi - cliente ESp8266


// Librerías conexión Wifi - cliente ESP8266
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>

// Defino credenciales red
const char* ssid = "ABC";
const char* password = "12345678";

void setup() {
  Serial.begin(115200);
  Serial.println(F("Iniciando..."));

  WiFi.begin(ssid, password);
  Serial.print("Conectando...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConexión OK!");
  Serial.print("IP Local: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  // Función de envío por POST
  EnviarDados("1", "1");
  delay(1000); // Esperar 60 segundos antes de enviar nuevamente
}

// Rutina de envío de datos por POST
void EnviarDados(char* canal_1, char* canal_2) {
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    // Cria a URL com os parâmetros
    String parametros = "?mac=" + WiFi.macAddress() + 
                        "&ip=" + WiFi.localIP().toString() + 
                        "&mascara=" + WiFi.subnetMask().toString() +
                        "&gateway=" + WiFi.gatewayIP().toString() +
                        "&casa=1" + 
                        "&marca=teste" + 
                        "&modelo=teste" +
                        "&versao=teste" +
                        "&titulo=teste" +
                        "&local=teste" +
                        "&status=teste" +
                        "&canal_1=" + String(canal_1) + 
                        "&canal_2=" + String(canal_2);
    String url = "http://192.168.1.3/ativisoft_1_0/pages/md_hospedagem/dispositivo.php" + parametros;
    
    http.begin(client, url);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int codigo_respuesta = http.POST("");

    if (codigo_respuesta > 0) {
      Serial.println("Código HTTP: " + String(codigo_respuesta));
      if (codigo_respuesta == 200) {
        String cuerpo_respuesta = http.getString();
        Serial.print("URL: ");
        Serial.println(url);
        Serial.print("Resposta do servidor: ");
        Serial.println(cuerpo_respuesta);
        if(cuerpo_respuesta != ""){
          delay(2000);
        }
      }
    } else {
      Serial.print("Erro ao enviar POST, código: ");
      Serial.println(codigo_respuesta);
    }

    http.end();
  } else {
    Serial.println("Erro na conexão WIFI");
  }
}


