<!-- Temperature Card -->
<div
    class="w-full md:w-1/2 bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 text-center shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_14px_25px_rgba(239,68,68,0.25)] hover:scale-[1.02] transition-all duration-300 h-44 md:h-48 flex flex-col justify-center"
>
    <div class="flex flex-col items-center space-y-2">
        <i class="bi bi-thermometer-half text-4xl text-red-400"></i>

        <h2 class="text-base font-semibold tracking-wide text-gray-300">
            Temperature
        </h2>

        <p class="text-4xl font-extrabold text-red-400">
            <span id="temperature">--</span>
            °C
        </p>
    </div>

    <div>
        <p id="temp-notif"></p>
    </div>
</div>

<!-- Humidity Card -->
<div
    class="w-full md:w-1/2 bg-white/10 backdrop-blur-2xl border border-white/10 rounded-2xl p-6 text-center shadow-[0_8px_25px_rgba(255,255,255,0.05)] hover:shadow-[0_14px_25px_rgba(56,189,248,0.25)] hover:scale-[1.02] transition-all duration-300 h-44 md:h-48 flex flex-col justify-center"
>
    <div class="flex flex-col items-center space-y-2">
        <i class="bi bi-droplet text-4xl text-sky-500"></i>

        <h2 class="text-base font-semibold tracking-wide text-gray-300">
            Humidity
        </h2>

        <p class="text-4xl font-extrabold text-sky-400">
            <span id="humidity">--</span>
            %
        </p>
    </div>

    <div>
        <p id="humi-notif"></p>
    </div>
</div>
