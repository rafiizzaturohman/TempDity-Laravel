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
</script>
