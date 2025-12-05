<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>TempDity – DHT22 Sensor Monitoring</title>

    <!-- Icon & Tailwind -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/tailwindcss/dataTables.tailwindcss.min.css">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- DataTables + Tailwind -->    

    <style>
      /* Hilangkan spinner di Chrome, Edge, Opera */
      input[type="number"]::-webkit-outer-spin-button,
      input[type="number"]::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
      }

      /* Hilangkan spinner di Firefox */
      input[type="number"] {
          -moz-appearance: textfield;
      }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>

  <body class="bg-linear-to-br from-gray-800 via-gray-900 to-black h-max">
    <div class="text-white max-h-screen flex flex-col">
      <!-- Header -->
      <header class="bg-white/10 backdrop-blur-md shadow-md py-4 text-center border-b border-white/10">
        <h1 class="text-3xl font-semibold tracking-widest text-[#1E90FF] text-shadow-sm text-shadow-[#00bfff80] font-sans">TempDity</h1>
        
        <p class="text-sm text-gray-300 mt-1">DHT22 Sensor Monitoring</p>
      </header>

      <!-- Card Section -->
      <main class="flex-1 flex flex-col md:flex-row gap-6 justify-center items-stretch p-6 md:max-w-300 mx-auto w-full">
        <!-- Temperature Card -->
        <div class="w-full md:w-1/2 bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 text-center shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_14px_25px_rgba(239,68,68,0.25)] hover:scale-[1.02] transition-all duration-300 h-44 md:h-48 flex flex-col justify-center">
          <div class="flex flex-col items-center space-y-2">
            <i class="bi bi-thermometer-half text-4xl text-red-400"></i>

            <h2 class="text-base font-semibold tracking-wide text-gray-300">
              Temperature
            </h2>

            <p class="text-4xl font-extrabold text-red-400">
              <span id="temperature">--</span>°C
            </p>
          </div>

          <div>
            <p id="temp-notif" class=""></p>
          </div>
        </div>

        <!-- Humidity Card -->
        <div class="w-full md:w-1/2 bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 text-center shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_14px_25px_rgba(56,189,248,0.25)] hover:scale-[1.02] transition-all duration-300 h-44 md:h-48 flex flex-col justify-center">
          <div class="flex flex-col items-center space-y-2">
            <i class="bi bi-droplet text-4xl text-sky-500"></i>

            <h2 class="text-base font-semibold tracking-wide text-gray-300">
              Humidity
            </h2>

            <p class="text-4xl font-extrabold text-sky-400">
              <span id="humidity">--</span>%
            </p>
          </div>

          <div>
            <p id="humi-notif" class=""></p>
          </div>
        </div>
      </main>

      <section id="minmax-temp" class="max-w-6xl flex flex-col md:flex-row gap-6 mx-auto w-full">
        <div class="mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 my-0.5 hover:scale-[1.02] transition-all duration-300">
          <div class="flex flex-row items-center space-x-2">
            <i class="bi bi-thermometer-half text-2xl text-red-400"></i>

            <p class="text-xl tracking-wider">Temperature</p>
          </div>

          <div class="flex flex-row justify-evenly mt-6">
            <div>
              <p class="text-lg tracking-wide">Minimum</p>
    
              <p id="min-temp" class="text-center text-xl tracking-wider text-red-400 font-bold">--</p>
            </div>
            <div>
              <p class="text-lg tracking-wide">Maximum</p>

              <p id="max-temp" class="text-center text-xl tracking-wider text-red-400 font-bold">--</p>
            </div>
          </div>
        </div>
        
        <div class="mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 my-0.5 hover:scale-[1.02] transition-all duration-300">
          <div class="flex md:flex-row items-center space-x-2">
            <i class="bi bi-droplet text-2xl text-sky-500"></i>

            <p class="text-xl tracking-wider">Humidity</p>
          </div>

          <div class="flex flex-row justify-evenly mt-6">
            <div>
              <p class="text-lg tracking-wide">Minimum</p>
    
              <p id="min-humi" class="text-center text-xl tracking-wider text-sky-500 font-bold">--</p>
            </div>
            <div>
              <p class="text-lg tracking-wide">Maximum</p>

              <p id="max-humi" class="text-center text-xl tracking-wider text-sky-500 font-bold">--</p>
            </div>
          </div>
        </div>
      </section>

      <section id="input-form" class="max-w-6xl mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300">
        <h2 class="text-2xl text-center font-semibold tracking-wide text-gray-300 mb-6 flex items-center justify-center gap-2">
          <i class="bi bi-thermometer-half text-4xl text-red-400"></i>
          Batas TempDity
          <i class="bi bi-droplet text-4xl text-sky-500"></i>
        </h2>

        
        <div class="grid grid-cols-none md:grid-cols-2 gap-8">
          <form action="update-nmin" method="POST" class="space-y-4">
            @csrf
            <div class="flex flex-col gap-4">
              <div class="relative flex-1">
                <label for="jenis_nilai" class="text-gray-300 text-base mb-1 block">Nilai Minimum</label>
                <select name="jenis_nilai" id="jenis_nilai" class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  <option value="" disabled selected>Pilih Nilai</option>
                  <option value="min_temperature">Min Temperature</option>
                  <option value="min_humidity">Min Humidity</option>
                </select>
              </div>
  
              <div class="flex-1">
                <label for="nilai" class="text-gray-300 text-base mb-1 block">Nilai</label>
                <input type="number" name="nilai" id="nilai" step="0.1" class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" required>
              </div>
            </div>
            
            <div class="text-center">
              <button type="submit" class="mt-2 px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200 cursor-pointer">Simpan Nilai</button>
            </div>
          </form>
          
          <form action="update-nmax" method="POST" class="space-y-4">
            @csrf
            <div class="flex flex-col gap-4">
              <div class="relative flex-1">
                <label for="jenis_nilai" class="text-gray-300 text-base mb-1 block">Nilai Maksimum</label>
                <select name="jenis_nilai" id="jenis_nilai" class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                  <option value="" disabled selected>Pilih Nilai</option>
                  <option value="max_temperature">Max Temperature</option>
                  <option value="max_humidity">Max Humidity</option>
                </select>
              </div>
              
              <div class="flex-1">
                <label for="nilai" class="text-gray-300 text-base mb-1 block">Nilai</label>
                <input type="number" name="nilai" id="nilai" step="0.1" class="w-full px-4 py-2 rounded-lg bg-gray-900 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400" required>
              </div>
            </div>
            
            <div class="text-center">
              <button type="submit" class="mt-2 px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200 cursor-pointer">Simpan Nilai</button>
            </div>
          </form>
        </div>
      </section>

      <!-- Chart Section -->
      <section class="max-w-6xl mx-auto w-11/12 h-auto md:w-full md:h-auto bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.5)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300">
        <h2 class="text-center text-lg font-semibold tracking-wide text-gray-300 mb-4">
          Real-time Sensor Chart
        </h2>
      
        <canvas id="sensorChart" height="100"></canvas>
      </section>

      <section id="manual-read" class="max-w-6xl mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300">
        <h2 class="text-2xl text-center font-semibold tracking-wide text-gray-300 mb-6 flex items-center justify-center gap-2">
            <i class="bi bi-play-circle text-4xl text-green-400"></i>
            Manual
            <i class="bi bi-sensor text-4xl text-green-400"></i>
        </h2>

        <div class="text-center">
            <button type="button" id="readSensorBtn" class="px-8 py-4 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold text-lg transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 mx-auto">
                <i class="bi bi-arrow-repeat"></i>
                Update Sensor
            </button>
            
            <div id="readStatus" class="mt-4 text-sm text-gray-300"></div>
        </div>
      </section>

      <section id="log-section" class="max-w-6xl mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300">
        <h2 class="text-2xl text-center font-semibold tracking-wide text-gray-300 mb-6 flex items-center justify-center gap-2">
            <i class="bi bi-clock-history text-4xl text-purple-400"></i>
            Log Request Manual
            <i class="bi bi-list-check text-4xl text-purple-400"></i>
        </h2>

        <div class="overflow-x-auto">
            <table id="logsTable" class="w-full text-sm text-left text-gray-300">
                <thead class="text-xs text-gray-400 uppercase bg-gray-900/50 border-b border-gray-700">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-center">No</th>
                        <th scope="col" class="px-4 py-3">Waktu Request</th>
                        <th scope="col" class="px-4 py-3">Waktu Response</th>
                        <th scope="col" class="px-4 py-3 text-center">Suhu</th>
                        <th scope="col" class="px-4 py-3 text-center">Humidity</th>
                        <th scope="col" class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="logTableBody">
                    <!-- Data log akan diisi oleh JavaScript -->
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <i class="bi bi-arrow-repeat animate-spin text-2xl mb-2 block"></i>
                            Memuat log...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="flex flex-col md:flex-row items-center justify-between mx-4">
          <div id="paginationContainer" class="mt-6 flex items-center justify-center gap-2 select-none"></div>

  
          <div class="mt-4 text-center">
              <button id="refreshLogsBtn" class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white font-semibold transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 mx-auto">
                  <i class="bi bi-arrow-clockwise"></i>
                  Refresh Log
              </button>
          </div>
        </div>
      </section>
      
      <!-- Footer -->
      <footer class="text-center py-3 text-gray-500 text-xs md:text-sm">
        <p>© 2025 TempDity | Real-time DHT22 Sensor Data</p>
      </footer>
    </div>
  </body>

  <!-- Script Section -->
  <script>
      // ====== CARD UPDATE (setiap 0.5 detik) ======
      async function updateCards() {
        try {
              const res = await fetch("/get-data");
              const data = await res.json();

              const tempNotif = document.getElementById("temp-notif");
              const humiNotif = document.getElementById("humi-notif");

              document.getElementById("temperature").innerText =
                  data.temperature ?? "--";
              document.getElementById("humidity").innerText =
                  data.humidity ?? "--";

              document.getElementById("max-temp").innerText =
                  data.max_temperature ?? "--";
              document.getElementById("min-temp").innerText =
                  data.min_temperature ?? "--";
              document.getElementById("max-humi").innerText =
                  data.max_humidity ?? "--";
              document.getElementById("min-humi").innerText =
                  data.min_humidity ?? "--";
              
              const setNotif = (el, text, color) => {
                el.innerText = text;
                el.className = `mt-3 text-xs sm:text-sm md:text-base font-medium text-${color}-300 bg-${color}-900/40 border border-${color}-700/40 px-3 sm:px-4 py-1 sm:py-2 rounded-lg shadow-md transition-all duration-300 text-center`.trim();
              }

              if (data.max_temperature && data.temperature >= data.max_temperature) {
                  setNotif(tempNotif, `⚠️ Suhu terlalu panas (max: ${data.max_temperature}°C)`, "red");
              } else if (data.min_temperature && data.temperature <= data.min_temperature) {
                  setNotif(tempNotif, `❄️ Suhu terlalu dingin (min: ${data.min_temperature}°C)`, "blue");
              } else {
                  setNotif(tempNotif, "😊 Suhu udara normal", "green");
              }

              if (data.max_humidity && data.humidity >= data.max_humidity) {
                  setNotif(humiNotif, `⚠️ Kelembapan diatas batas (max: ${data.max_humidity}%)`, "red");
              } else if (data.min_humidity && data.humidity <= data.min_humidity) {
                  setNotif(humiNotif, `⚠️ Kelembapan dibawah batas (min: ${data.min_humidity}%)`, "blue");
              } else {
                  setNotif(humiNotif, "😊 Kelembapan normal", "green");
              }

            } catch (err) {
              console.error("❌ Gagal mengambil data untuk card:", err);
            }
        }

        updateCards();
        setInterval(updateCards, 1000);

        // ====== INISIALISASI CHART ======
        const ctx = document.getElementById("sensorChart").getContext("2d");
        const sensorChart = new Chart(ctx, {
            type: "line",
            data: {
              labels: [],
              datasets: [
                  {
                    label: "Temperature (°C)",
                    borderColor: "rgba(239,68,68,1)",
                    backgroundColor: "rgba(239,68,68,0.2)",
                    data: [],
                    tension: 0.3,
                    fill: true,
                  },
                  {
                    label: "Humidity (%)",
                    borderColor: "rgba(56,189,248,1)",
                    backgroundColor: "rgba(56,189,248,0.2)",
                    data: [],
                    tension: 0.3,
                    fill: true, 
                  },
              ],
            },
            options: {
              responsive: true,
              scales: {
                  x: {
                      ticks: { color: "#9ca3af" },
                      grid: { color: "rgba(255,255,255,0.05)" },
                  },
                  y: {
                      ticks: { color: "#9ca3af" },
                      grid: { color: "rgba(255,255,255,0.05)" },
                  },
              },
              plugins: {
                  legend: { labels: { color: "#f3f4f6" } },
              },
            },
        });

        // ====== CHART UPDATE (setiap 10 detik) ======
        async function updateChart() {
            try {
              const res = await fetch("/get-data");
              const data = await res.json();
              const now = new Date().toLocaleTimeString();

              sensorChart.data.labels.push(now);
              sensorChart.data.datasets[0].data.push(data.temperature ?? 0);
              sensorChart.data.datasets[1].data.push(data.humidity ?? 0);

              if (sensorChart.data.labels.length > 15) {
                sensorChart.data.labels.shift();
                sensorChart.data.datasets.forEach((ds) => ds.data.shift());
              }

              sensorChart.update();
            } catch (err) {
              console.error("❌ Gagal mengambil data untuk chart:", err);
            }
        }

        updateChart();
        setInterval(updateChart, 10000);

        // ====== CHART LABELS DELETE (2 labels setiap 60 detik) ======
        setInterval(() => {
            const removeCount = 2; 

            if (sensorChart.data.labels.length > removeCount) {
              sensorChart.data.labels.splice(0, removeCount);
              sensorChart.data.datasets.forEach((ds) =>
                ds.data.splice(0, removeCount)
              );
              sensorChart.update();
            }
        }, 60000);

      let currentPage = 1;
      const limit = 5;

      async function loadLogs(page = 1) {
          try {
              const res = await fetch(`/get-logs?page=${page}&limit=${limit}`);
              const result = await res.json();

              const logs = result.data;
              const total = result.total;
              const totalPages = Math.ceil(total / limit);

              const tbody = document.getElementById("logTableBody");

              if (!logs || logs.length === 0) {
                  tbody.innerHTML = `
                      <tr>
                          <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                              <i class="bi bi-inbox text-2xl mb-2 block"></i>
                              Belum ada log request
                          </td>
                      </tr>
                  `;
                  return;
              }

              // Render table data
              tbody.innerHTML = logs
                  .map(
                      (log, index) => `
                  <tr class="border-b border-gray-700/50 hover:bg-white/5 transition-colors">
                      <td class="px-4 py-3 text-center font-medium">${(page - 1) * limit + index + 1}</td>
                      <td class="px-4 py-3">
                          <div class="flex items-center gap-2">
                              <i class="bi bi-clock text-blue-400"></i>
                              ${log.request_time}
                          </div>
                      </td>
                      <td class="px-4 py-3">
                          <div class="flex items-center gap-2">
                              <i class="bi bi-check-circle ${log.response_time !== '--' ? 'text-green-400' : 'text-gray-500'}"></i>
                              ${log.response_time}
                          </div>
                      </td>
                      <td class="px-4 py-3 text-center">
                          ${
                              log.temperature !== '--'
                                  ? `<span class="font-bold text-red-400">${log.temperature}°C</span>`
                                  : '<span class="text-gray-500">--</span>'
                          }
                      </td>
                      <td class="px-4 py-3 text-center">
                          ${
                              log.humidity !== '--'
                                  ? `<span class="font-bold text-sky-400">${log.humidity}%</span>`
                                  : '<span class="text-gray-500">--</span>'
                          }
                      </td>
                      <td class="px-4 py-3 text-center">${log.status_badge}</td>
                  </tr>
              `
                  )
                  .join("");

              // Render Beautiful Pagination
              renderPagination(page, totalPages);

              currentPage = page;
          } catch (error) {
              console.error("❌ Gagal memuat log:", error);
          }
      }

      // BEAUTY PAGINATION RENDERER
      function renderPagination(page, totalPages) {
          const container = document.getElementById("paginationContainer");
          container.innerHTML = "";

          const buttonClasses =
              "px-3 py-1 rounded-lg border border-white/10 bg-white/5 text-gray-300 hover:bg-purple-600 hover:text-white transition-all duration-200 cursor-pointer";

          const disabledClasses =
              "px-3 py-1 rounded-lg border border-white/5 bg-gray-800/40 text-gray-600 cursor-not-allowed";

          // Helper to create buttons
          const makeButton = (label, targetPage, disabled = false, active = false) => {
              const btn = document.createElement("button");
              btn.innerHTML = label;

              if (disabled) {
                  btn.className = disabledClasses;
              } else if (active) {
                  btn.className =
                      "px-3 py-1 rounded-lg bg-purple-600 text-white font-semibold border border-purple-400 shadow-lg shadow-purple-600/30";
              } else {
                  btn.className = buttonClasses;
                  btn.onclick = () => loadLogs(targetPage);
              }

              return btn;
          };

          // FIRST & PREV
          container.appendChild(makeButton("⟪", 1, page === 1));
          container.appendChild(makeButton("⟨", page - 1, page === 1));

          // Page numbers (limit 5 at once)
          let start = Math.max(1, page - 2);
          let end = Math.min(totalPages, page + 2);

          if (page <= 2) end = Math.min(5, totalPages);
          if (page >= totalPages - 1) start = Math.max(1, totalPages - 4);

          for (let p = start; p <= end; p++) {
              container.appendChild(makeButton(p, p, false, p === page));
          }

          // NEXT & LAST
          container.appendChild(makeButton("⟩", page + 1, page === totalPages));
          container.appendChild(makeButton("⟫", totalPages, page === totalPages));
      }

      // Refresh logs
      document.getElementById("refreshLogsBtn").addEventListener("click", () =>
          loadLogs(currentPage)
      );

      // Auto refresh tetap ikut halaman
      setInterval(() => loadLogs(currentPage), 5000);

      // Load pertama kali
      loadLogs();



      // ====== UPDATE TOMBOL BACA SENSOR ======
      // Update event listener tombol baca sensor untuk refresh log setelah request
      document.getElementById('readSensorBtn').addEventListener('click', async function() {
          const btn = this;
          const statusDiv = document.getElementById('readStatus');
          
          btn.disabled = true;
          btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Memproses...';
          statusDiv.innerHTML = '<p class="text-yellow-400">🟡 Mengirim permintaan baca sensor...</p>';
          
          try {
              const response = await fetch('/trigger-read-sensor', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  }
              });
              
              const data = await response.json();
              
              if (response.ok) {
                  statusDiv.innerHTML = '<p class="text-green-400">✅ Permintaan terkirim! menunggu data sensor...</p>';
                  
                  // Refresh log setelah request
                  loadLogs();
                  
                  // Cek status setiap 2 detik sampai read_request false
                  const checkInterval = setInterval(async () => {
                      const statusResponse = await fetch('/get-data');
                      const statusData = await statusResponse.json();
                      
                      if (!statusData.read_request) {
                          clearInterval(checkInterval);
                          statusDiv.innerHTML = '<p class="text-blue-400">✅ Data sensor berhasil diperbarui!</p>';
                          btn.disabled = false;
                          btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Baca Sensor Sekarang';
                          
                          // Refresh data cards dan log
                          updateCards();
                          loadLogs();
                      }
                  }, 2000);
                  
              } else {
                  throw new Error(data.error || 'Gagal mengirim permintaan');
              }
              
          } catch (error) {
              console.error('Error:', error);
              statusDiv.innerHTML = '<p class="text-red-400">❌ Gagal mengirim permintaan: ' + error.message + '</p>';
              btn.disabled = false;
              btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Baca Sensor Sekarang';
          }
      });
  </script>
</html>
