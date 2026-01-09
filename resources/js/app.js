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
