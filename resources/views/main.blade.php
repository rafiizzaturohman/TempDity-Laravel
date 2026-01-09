<div class="text-white max-h-screen flex flex-col">
    <!-- Header -->
    <header
        class="bg-white/10 backdrop-blur-md shadow-md py-4 text-center border-b border-white/10"
    >
        <h1
            class="text-3xl font-semibold tracking-widest text-[#1E90FF] text-shadow-sm text-shadow-[#00bfff80] font-sans"
        >
            TempDity
        </h1>

        <p class="text-sm text-gray-300 mt-1">DHT22 Sensor Monitoring</p>
    </header>

    <main>
        <section
            class="flex-1 flex flex-col md:flex-row gap-6 justify-center items-stretch p-6 md:max-w-300 mx-auto w-full"
        >
            @include('components.informations.live-tempdity')
        </section>

        <section
            id="minmax-temp"
            class="max-w-6xl flex flex-col md:flex-row gap-6 mx-auto w-full"
        >
            @include('components.informations.minmax-tempdity')
        </section>

        <section
            id="input-form"
            class="max-w-6xl mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300"
        >
            <h2
                class="text-2xl text-center font-semibold tracking-wide text-gray-300 mb-6 flex items-center justify-center gap-2"
            >
                <i class="bi bi-thermometer-half text-4xl text-red-400"></i>
                Batas TempDity
                <i class="bi bi-droplet text-4xl text-sky-500"></i>
            </h2>

            @include('components.minmax-input')
        </section>

        <section
            class="max-w-6xl mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300"
        >
            <h2
                class="text-2xl text-center font-semibold tracking-wide text-gray-300 mb-6"
            >
                Smart Home Control
            </h2>

            @include('components.smartcontrol')
        </section>

        <!-- Chart Section -->
        <section
            class="max-w-6xl mx-auto w-11/12 h-auto md:w-full md:h-auto bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300"
        >
            <h2
                class="text-center text-lg font-semibold tracking-wide text-gray-300 mb-4"
            >
                Real-time Sensor Chart
            </h2>

            <canvas id="sensorChart" height="100"></canvas>
        </section>

        <!-- Manual Log Section -->
        <section
            id="manual-read"
            class="max-w-6xl mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300"
        >
            <h2
                class="text-2xl text-center font-semibold tracking-wide text-gray-300 mb-6 flex items-center justify-center gap-2"
            >
                <i class="bi bi-play-circle text-4xl text-green-400"></i>
                Manual Log
                <i class="bi bi-sensor text-4xl text-green-400"></i>
            </h2>

            <div class="text-center">
                <button
                    type="button"
                    id="readSensorBtn"
                    class="px-8 py-4 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold text-lg transition-all duration-200 cursor-pointer flex items-center justify-center gap-2 mx-auto"
                >
                    <i class="bi bi-arrow-repeat"></i>
                    Update Sensor
                </button>

                <div id="readStatus" class="mt-4 text-sm text-gray-300"></div>
            </div>
        </section>

        <!-- Manual Log Information Section -->
        <section
            id="log-section"
            class="max-w-6xl mx-auto w-11/12 md:w-full bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_10px_25px_rgba(249,248,246,0.2)] p-6 mt-4 mb-6 hover:scale-[1.02] transition-all duration-300"
        >
            <h2
                class="text-2xl text-center font-semibold tracking-wide text-gray-300 mb-6 flex items-center justify-center gap-2"
            >
                <i class="bi bi-clock-history text-4xl text-purple-400"></i>
                Log Request Manual
                <i class="bi bi-list-check text-4xl text-purple-400"></i>
            </h2>

            @include('components.informations.manual-log')
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-center py-3 text-gray-500 text-xs md:text-sm">
        <p>© 2025 TempDity | Real-time DHT22 Sensor Data</p>
    </footer>
</div>

<script>
    function toggleDevice(id) {
        fetch(`/devices/toggle/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                Accept: 'application/json',
            },
        })
            .then((res) => res.json())
            .then((data) => {
                const btn = document.getElementById(`device-${data.id}`)
                const statusText = btn.querySelector('.status-text')

                btn.classList.remove('text-green-400', 'text-red-400')

                if (data.status) {
                    if (data.name === 'lampu4' || data.name === 'lampu5') {
                        btn.classList.add('text-green-400')
                        statusText.innerText = 'Open'
                    } else {
                        btn.classList.add('text-green-400')
                        statusText.innerText = 'ON'
                    }
                } else {
                    if (data.name === 'lampu4' || data.name === 'lampu5') {
                        btn.classList.add('text-red-400')
                        statusText.innerText = 'Close'
                    } else {
                        btn.classList.add('text-red-400')
                        statusText.innerText = 'OFF'
                    }
                }
            })
            .catch((err) => console.error(err))
    }

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
</script>
