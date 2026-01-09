// ====== NOTIFICATION CLASS MAP (TAILWIND SAFE) ======
const notifClassMap = {
    green:
        'mt-3 text-xs sm:text-sm md:text-base font-medium ' +
        'text-green-300 bg-green-900/40 border border-green-700/40 ' +
        'px-3 sm:px-4 py-1 sm:py-2 rounded-lg shadow-md ' +
        'transition-all duration-300 text-center',

    red:
        'mt-3 text-xs sm:text-sm md:text-base font-medium ' +
        'text-red-300 bg-red-900/40 border border-red-700/40 ' +
        'px-3 sm:px-4 py-1 sm:py-2 rounded-lg shadow-md ' +
        'transition-all duration-300 text-center',

    blue:
        'mt-3 text-xs sm:text-sm md:text-base font-medium ' +
        'text-blue-300 bg-blue-900/40 border border-blue-700/40 ' +
        'px-3 sm:px-4 py-1 sm:py-2 rounded-lg shadow-md ' +
        'transition-all duration-300 text-center',
}

// Helper notif
const setNotif = (el, text, color) => {
    if (!el) return
    el.textContent = text
    el.className = notifClassMap[color]
}

// ====== CARD UPDATE (setiap 0.5 detik) ======
async function updateCards() {
    try {
        const res = await fetch('/get-data')
        const data = await res.json()

        const tempNotif = document.getElementById('temp-notif')
        const humiNotif = document.getElementById('humi-notif')

        document.getElementById('temperature').innerText =
            data.temperature ?? '--'
        document.getElementById('humidity').innerText = data.humidity ?? '--'

        document.getElementById('max-temp').innerText =
            data.max_temperature ?? '--'
        document.getElementById('min-temp').innerText =
            data.min_temperature ?? '--'
        document.getElementById('max-humi').innerText =
            data.max_humidity ?? '--'
        document.getElementById('min-humi').innerText =
            data.min_humidity ?? '--'

        const setNotif = (el, text, color) => {
            el.innerText = text
            el.className =
                `mt-3 text-xs sm:text-sm md:text-base font-medium text-${color}-300 bg-${color}-900/40 border border-${color}-700/40 px-3 sm:px-4 py-1 sm:py-2 rounded-lg shadow-md transition-all duration-300 text-center`.trim()
        }

        if (data.max_temperature && data.temperature >= data.max_temperature) {
            setNotif(
                tempNotif,
                `⚠️ Suhu terlalu panas (max: ${data.max_temperature}°C)`,
                'red',
            )
        } else if (
            data.min_temperature &&
            data.temperature <= data.min_temperature
        ) {
            setNotif(
                tempNotif,
                `❄️ Suhu terlalu dingin (min: ${data.min_temperature}°C)`,
                'blue',
            )
        } else {
            setNotif(tempNotif, '😊 Suhu udara normal', 'green')
        }

        if (data.max_humidity && data.humidity >= data.max_humidity) {
            setNotif(
                humiNotif,
                `⚠️ Kelembapan diatas batas (max: ${data.max_humidity}%)`,
                'red',
            )
        } else if (data.min_humidity && data.humidity <= data.min_humidity) {
            setNotif(
                humiNotif,
                `⚠️ Kelembapan dibawah batas (min: ${data.min_humidity}%)`,
                'blue',
            )
        } else {
            setNotif(humiNotif, '😊 Kelembapan normal', 'green')
        }
    } catch (err) {
        console.error('❌ Gagal mengambil data untuk card:', err)
    }
}

updateCards()
setInterval(updateCards, 1000)

// ====== INISIALISASI CHART ======
const ctx = document.getElementById('sensorChart').getContext('2d')
const sensorChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Temperature (°C)',
                borderColor: 'rgba(239,68,68,1)',
                backgroundColor: 'rgba(239,68,68,0.2)',
                data: [],
                tension: 0.3,
                fill: true,
            },
            {
                label: 'Humidity (%)',
                borderColor: 'rgba(56,189,248,1)',
                backgroundColor: 'rgba(56,189,248,0.2)',
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
                ticks: { color: '#9ca3af' },
                grid: { color: 'rgba(255,255,255,0.05)' },
            },
            y: {
                ticks: { color: '#9ca3af' },
                grid: { color: 'rgba(255,255,255,0.05)' },
            },
        },
        plugins: {
            legend: { labels: { color: '#f3f4f6' } },
        },
    },
})

// ====== CHART UPDATE (setiap 10 detik) ======
async function updateChart() {
    try {
        const res = await fetch('/get-data')
        const data = await res.json()
        const now = new Date().toLocaleTimeString()

        sensorChart.data.labels.push(now)
        sensorChart.data.datasets[0].data.push(data.temperature ?? 0)
        sensorChart.data.datasets[1].data.push(data.humidity ?? 0)

        if (sensorChart.data.labels.length > 15) {
            sensorChart.data.labels.shift()
            sensorChart.data.datasets.forEach((ds) => ds.data.shift())
        }

        sensorChart.update()
    } catch (err) {
        console.error('❌ Gagal mengambil data untuk chart:', err)
    }
}

updateChart()
setInterval(updateChart, 10000)

// ====== CHART LABELS DELETE (2 labels setiap 60 detik) ======
setInterval(() => {
    const removeCount = 2

    if (sensorChart.data.labels.length > removeCount) {
        sensorChart.data.labels.splice(0, removeCount)
        sensorChart.data.datasets.forEach((ds) =>
            ds.data.splice(0, removeCount),
        )
        sensorChart.update()
    }
}, 60000)

let currentPage = 1
const limit = 5

async function loadLogs(page = 1) {
    try {
        const res = await fetch(`/get-logs?page=${page}&limit=${limit}`)
        const result = await res.json()

        const logs = result.data
        const total = result.total
        const totalPages = Math.ceil(total / limit)

        const tbody = document.getElementById('logTableBody')

        if (!logs || logs.length === 0) {
            tbody.innerHTML = `
                      <tr>
                          <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                              <i class="bi bi-inbox text-2xl mb-2 block"></i>
                              Belum ada log request
                          </td>
                      </tr>
                  `
            return
        }

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
                        `,
            )
            .join('')

        renderPagination(page, totalPages)

        currentPage = page
    } catch (error) {
        console.error('❌ Gagal memuat log:', error)
    }
}

// ====== PAGINATION ======
function renderPagination(page, totalPages) {
    const container = document.getElementById('paginationContainer')
    container.innerHTML = ''

    const buttonClasses =
        'px-3 py-1 rounded-lg border border-white/10 bg-white/5 text-gray-300 hover:bg-purple-600 hover:text-white transition-all duration-200 cursor-pointer'

    const disabledClasses =
        'px-3 py-1 rounded-lg border border-white/5 bg-gray-800/40 text-gray-600 cursor-not-allowed'

    const makeButton = (
        label,
        targetPage,
        disabled = false,
        active = false,
    ) => {
        const btn = document.createElement('button')
        btn.innerHTML = label

        if (disabled) {
            btn.className = disabledClasses
        } else if (active) {
            btn.className =
                'px-3 py-1 rounded-lg bg-purple-600 text-white font-semibold border border-purple-400 shadow-lg shadow-purple-600/30'
        } else {
            btn.className = buttonClasses
            btn.onclick = () => loadLogs(targetPage)
        }

        return btn
    }

    container.appendChild(makeButton('⟪', 1, page === 1))
    container.appendChild(makeButton('⟨', page - 1, page === 1))

    let start = Math.max(1, page - 2)
    let end = Math.min(totalPages, page + 2)

    if (page <= 2) end = Math.min(5, totalPages)
    if (page >= totalPages - 1) start = Math.max(1, totalPages - 4)

    for (let p = start; p <= end; p++) {
        container.appendChild(makeButton(p, p, false, p === page))
    }

    container.appendChild(makeButton('⟩', page + 1, page === totalPages))
    container.appendChild(makeButton('⟫', totalPages, page === totalPages))
}

// Refresh logs
document
    .getElementById('refreshLogsBtn')
    .addEventListener('click', () => loadLogs(currentPage))

setInterval(() => loadLogs(currentPage), 5000)

// Load pertama kali
loadLogs()

// ====== UPDATE TOMBOL BACA SENSOR ======
// Update event listener tombol baca sensor untuk refresh log setelah request
document
    .getElementById('readSensorBtn')
    .addEventListener('click', async function () {
        const btn = this
        const statusDiv = document.getElementById('readStatus')

        btn.disabled = true
        btn.innerHTML =
            '<i class="bi bi-arrow-repeat animate-spin"></i> Memproses...'
        statusDiv.innerHTML =
            '<p class="text-yellow-400">🟡 Mengirim permintaan baca sensor...</p>'

        try {
            const response = await fetch('/trigger-read-sensor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })

            const data = await response.json()

            if (response.ok) {
                statusDiv.innerHTML =
                    '<p class="text-green-400">✅ Permintaan terkirim! menunggu data sensor...</p>'

                loadLogs()

                const checkInterval = setInterval(async () => {
                    const statusResponse = await fetch('/get-data')
                    const statusData = await statusResponse.json()

                    if (!statusData.read_request) {
                        clearInterval(checkInterval)
                        statusDiv.innerHTML =
                            '<p class="text-blue-400">✅ Data sensor berhasil diperbarui!</p>'
                        btn.disabled = false
                        btn.innerHTML =
                            '<i class="bi bi-arrow-repeat"></i> Baca Sensor Sekarang'

                        updateCards()
                        loadLogs()
                    }
                }, 2000)
            } else {
                throw new Error(data.error || 'Gagal mengirim permintaan')
            }
        } catch (error) {
            console.error('Error:', error)
            statusDiv.innerHTML =
                '<p class="text-red-400">❌ Gagal mengirim permintaan: ' +
                error.message +
                '</p>'
            btn.disabled = false
            btn.innerHTML =
                '<i class="bi bi-arrow-repeat"></i> Baca Sensor Sekarang'
        }
    })
