# 🌡️ Temperature & Humidity Monitoring with Auto Window System

Monitoring Suhu & Kelembapan Realtime Menggunakan **DHT22**, **ESP8266**, **Laravel**, **Blade**, **MySQL**, dan **Servo Motor** untuk membuka jendela otomatis.

Aplikasi ini adalah sistem monitoring suhu (°C) dan kelembapan (%) secara realtime menggunakan sensor **DHT22**. Data dikirim melalui mikrokontroler (ESP8266) menuju **backend Laravel**, disimpan ke database **MySQL**, dan ditampilkan pada dashboard berbasis **Blade**.

Sistem ini dilengkapi **servo otomatis** yang membuka jendela ketika suhu melebihi batas maksimal, serta fitur **manual log retrieval** melalui tombol di dashboard.

Selain **servo otomatis dan manual log** ada tambahan fitur yang mana fitur ini berupa sebuah tombol yang dapat mengubah status pada suatu objek atau perangkat elektronik (On/Off atau Open/Closed).

---

## 🎯 Tujuan Fitur Kontrol Wireless

- Menyalakan / mematikan LED indikator dari jarak jauh
- Memberikan indikator visual status sistem
- Kontrol manual tanpa mengganggu sistem otomatis
- Dasar pengembangan perangkat IoT lain (relay, buzzer, dll)

## 🚀 Fitur Utama

### 🟦 Backend (Laravel)

- REST API untuk menerima data suhu & kelembapan dan status
- Penyimpanan data ke MySQL
- Log history temperatur & kelembapan
- Pengaturan batas maksimal suhu (threshold)
- Kontrol servo otomatis berdasarkan ambang batas
- Endpoint untuk mengambil data log secara manual (export)
- MVC Laravel + Route + Controller + Middleware

**Endpoint Utama:**

- `POST /public/update-data` → menerima data dari mikrokontroler
- `GET /public/get-data` → mengambil data terbaru (untuk frontend)
- `GET /public/get-logs` → mengambil data logs dari mikrokontroler
- `GET /public/devices/status` → mengambil dan mengirim data status ke perangkat IoT
- `GET /public/check-read-request` → memeriksa data status ke perangkat IoT

---

### 🟧 Frontend (Laravel Blade)

- Dashboard realtime
- Card suhu & kelembapan
- Grafik perubahan data
- Auto-refresh data
- Tombol update logs (mengambil logs secara manual)
- Tombol on/off perangkat elektronik (wireless control)
- UI responsive & ringan

---

### 🔧 Hardware

- Sensor **DHT22**
- ESP8266 / ESP32
- Servo motor (SG90)
- LED Indicator
- Mekanisme jendela otomatis
- Pengiriman data via HTTP POST

---

## 📁 Struktur Project

```
/project-root
│
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ ├── Models/
│ └── ...
│
├── resources/
│ └── views/   # Blade UI
│
├── public/
├── database/
├── routes/
│ └── web.php
│
└── ...
```

---

# ⚙️ Instalasi & Menjalankan Proyek

## 1. Clone Repository

```bash
git clone https://github.com/username/tempdity-laravel-monitoring.git
cd tempdity-laravel-monitoring
```

---

# 🟦 Backend (Laravel)

## Instalasi

```bash
composer install
cp .env.example .env
```

Atur koneksi database MySQL:

```
DB_DATABASE=iot_monitoring
DB_USERNAME=root
DB_PASSWORD=
```

Generate key:

```bash
php artisan key:generate
```

Migrasi database:

```bash
php artisan migrate
```

## Menjalankan Server

```bash
php artisan serve
```

Backend berjalan di:

```
http://localhost:8000
```

---

# 📡 Endpoint API

### **POST /public/update-data/{tmp}/{hmd}**

Digunakan mikrokontroler untuk mengirim data baru.

**Payload:**

```json
{
    "temperature": 29.4,
    "humidity": 72.1,
    "max_temperature": 30,
    "min_temperature": 21,
    "max_humidity": 60,
    "min_humidity": 40
}
```

**Fitur otomatis:**

- Jika suhu > max_temperature → `servo = buka_jendela`
- Jika normal → `servo = buka_setengah_jendela`
- Jika suhu < min_temperature `servo = tutup_jendela`

---

### **GET /api/sensor/get-data**

Mengambil data sensor terbaru untuk dashboard.

**Contoh response:**

```json
{
    "temperature": 28.9,
    "humidity": 67.4,
    "time": "2025-11-20T14:00:00Z"
}
```

### Endpoint Kontrol Perangkat

#### **POST /api/device/toggle/{id}**

Digunakan oleh frontend (UI).

**Request Body:**

```json
{
    "status": "ON"
}
```

atau

```json
{
    "status": "OFF"
}
```

**Response:**

```json
{
    "message": "Device status updated",
    "device_status": "OFF"
}
```

---

# 🟧 Frontend (Blade)

Menjalankan frontend bawaan Laravel:

```bash
php artisan serve
```

Akses dashboard:

```
http://localhost:8000/
```

**Fitur Dashboard:**

- Realtime temperature & humidity
- Grafik perubahan data
- Status servo (OPEN / CLOSE)
- Tombol update logs (Mengambil log secara manual)
- Auto-refresh API

---

# 🔌 Contoh Kode ESP8266 / ESP32

```cpp
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <DHT.h>

#define DHTPIN 2
#define DHTTYPE DHT22

DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.begin(115200);
  WiFi.begin("WiFi-Name", "WiFi-Password");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  dht.begin();
}

void loop() {
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();

  if (!isnan(temperature) && !isnan(humidity)) {

    WiFiClient client;
    HTTPClient http;

    http.begin(client, "http://YOUR_SERVER_IP/api/sensor/update");
    http.addHeader("Content-Type", "application/json");

    String json = "{\"temperature\":" + String(temperature,1) +
                  ",\"humidity\":" + String(humidity,1) + "}";

    int httpCode = http.POST(json);

    Serial.printf("HTTP Code: %d\n", httpCode);
    Serial.println(http.getString());

    http.end();
  }

  delay(3000);
}
```

---

## 🔁 Pemisahan Jalur Kontrol Sistem

| Komponen  | Dikontrol Oleh | Keterangan |
| --------- | -------------- | ---------- |
| Servo     | Logika suhu    | Otomatis   |
| LED       | UI Button      | Manual     |
| Sensor    | ESP            | Realtime   |
| Dashboard | API            | Monitoring |

---

# 📐 Arsitektur Sistem

```
[DHT22] → [ESP8266/ESP32] → [Laravel Backend + MySQL]
                         ↓
                 [Servo Otomatis] ← suhu melebihi batas
                         ↓
              [Dashboard Laravel Blade]
                         ↓
                   [LED Menyala] ← ketika status on
```

---

# 📄 Lisensi

Proyek ini menggunakan lisensi **MIT**.

---
